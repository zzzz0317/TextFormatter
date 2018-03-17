<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP;

use LogicException;
use RuntimeException;

class XPathConvertor
{
	/**
	* @var string PCRE version
	*/
	public $pcreVersion;

	/**
	* @var string Regexp used to match XPath expressions
	*/
	protected $regexp;

	/**
	* @var bool Whether to use the mbstring functions as a replacement for XPath expressions
	*/
	public $useMultibyteStringFunctions = false;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->pcreVersion = PCRE_VERSION;
	}

	/**
	* Convert an XPath expression (used in a condition) into PHP code
	*
	* This method is similar to convertXPath() but it selectively replaces some simple conditions
	* with the corresponding DOM method for performance reasons
	*
	* @param  string $expr XPath expression
	* @return string       PHP code
	*/
	public function convertCondition($expr)
	{
		$expr = trim($expr);

		// Replace @attr with boolean(@attr) in boolean expressions
		$expr = preg_replace_callback(
			[
				'(^(?:[$@]\\S+(?:$|\\s+(?:and|or)\\s*))+)',
				'((?:(?:\\s+(?:and|or)\\s*)[$@]\\S+)+$)'
			],
			function ($m)
			{
				return preg_replace('(@\\S+)', 'boolean($0)', $m[0]);
			},
			$expr
		);

		// XSL: <xsl:if test="@foo > 1">
		// PHP: if ($node->getAttribute('foo') > 1)
		if (preg_match('#^([$@][-\\w]+)\\s*([<>])\\s*(\\d+)$#', $expr, $m))
		{
			return $this->convertXPath($m[1]) . $m[2] . $m[3];
		}

		// If the condition does not seem to contain a relational expression, or start with a
		// function call, we wrap it inside of a boolean() call
		if (!preg_match('#[=<>]|\\bor\\b|\\band\\b|^[-\\w]+\\s*\\(#', $expr))
		{
			// XSL: <xsl:if test="parent::foo">
			// PHP: if ($this->xpath->evaluate("boolean(parent::foo)",$node))
			$expr = 'boolean(' . $expr . ')';
		}

		// XSL: <xsl:if test="@foo='bar'">
		// PHP: if ($this->xpath->evaluate("@foo='bar'",$node))
		return $this->convertXPath($expr);
	}

	/**
	* Convert an XPath expression (used as value) into PHP code
	*
	* @param  string $expr XPath expression
	* @return string       PHP code
	*/
	public function convertXPath($expr)
	{
		$expr = trim($expr);

		$this->generateXPathRegexp();
		if (preg_match($this->regexp, $expr, $m))
		{
			$methodName = null;
			foreach ($m as $k => $v)
			{
				if (is_numeric($k) || $v === '' || $v === null || !method_exists($this, $k))
				{
					continue;
				}

				$methodName = $k;
				break;
			}

			if (isset($methodName))
			{
				// Default argument is the whole matched string
				$args = [$m[$methodName]];

				// Overwrite the default arguments with the named captures
				$i = 0;
				while (isset($m[$methodName . $i]))
				{
					$args[$i] = $m[$methodName . $i];
					++$i;
				}

				return call_user_func_array([$this, $methodName], $args);
			}
		}

		// If the condition does not seem to contain a relational expression, or start with a
		// function call, we wrap it inside of a string() call
		if (!preg_match('#[=<>]|\\bor\\b|\\band\\b|^[-\\w]+\\s*\\(#', $expr))
		{
			$expr = 'string(' . $expr . ')';
		}

		// Replace parameters in the expression
		return '$this->xpath->evaluate(' . $this->exportXPath($expr) . ',$node)';
	}

	protected function not($expr)
	{
		return '!(' . $this->convertCondition($expr) . ')';
	}


	protected function parens($expr)
	{
		return '(' . $this->convertXPath($expr) . ')';
	}

	/**
	* Export an XPath expression as PHP with special consideration for XPath variables
	*
	* Will return PHP source representing the XPath expression, with special consideration for XPath
	* variables which are returned as a method call to XPath::export()
	*
	* @param  string $expr XPath expression
	* @return string       PHP representation of the expression
	*/
	protected function exportXPath($expr)
	{
		$phpTokens = [];
		foreach ($this->tokenizeXPathForExport($expr) as list($type, $content))
		{
			$methodName  = 'exportXPath' . ucfirst($type);
			$phpTokens[] = $this->$methodName($content);
		}

		return implode('.', $phpTokens);
	}

	/**
	* Convert a "current()" XPath expression to its PHP source representation
	*
	* @return string
	*/
	protected function exportXPathCurrent()
	{
		return '$node->getNodePath()';
	}

	/**
	* Convert a fragment of an XPath expression to its PHP source representation
	*
	* @param  string $fragment
	* @return string
	*/
	protected function exportXPathFragment($fragment)
	{
		return var_export($fragment, true);
	}

	/**
	* Convert an XSLT parameter to its PHP source representation
	*
	* @param  string $param Parameter, including the leading $
	* @return string
	*/
	protected function exportXPathParam($param)
	{
		$paramName = ltrim($param, '$');

		return '$this->getParamAsXPath(' . var_export($paramName, true) . ')';
	}

	/**
	* Generate a regexp used to parse XPath expressions
	*
	* @return void
	*/
	protected function generateXPathRegexp()
	{
		if (isset($this->regexp))
		{
			return;
		}

		$patterns = [
			'attr'      => ['@', '(?<attr0>[-\\w]+)'],
			'dot'       => '\\.',
			'name'      => 'name\\(\\)',
			'lname'     => 'local-name\\(\\)',
			'param'     => ['\\$', '(?<param0>\\w+)'],
			'string'    => '"[^"]*"|\'[^\']*\'',
			'number'    => ['(?<number0>-?)', '(?<number1>\\d++)'],
			'strlen'    => ['string-length', '\\(', '(?<strlen0>(?&value)?)', '\\)'],
			'contains'  => [
				'contains',
				'\\(',
				'(?<contains0>(?&value))',
				',',
				'(?<contains1>(?&value))',
				'\\)'
			],
			'translate' => [
				'translate',
				'\\(',
				'(?<translate0>(?&value))',
				',',
				'(?<translate1>(?&string))',
				',',
				'(?<translate2>(?&string))',
				'\\)'
			],
			'substr' => [
				'substring',
				'\\(',
				'(?<substr0>(?&value))',
				',',
				'(?<substr1>(?&value))',
				'(?:, (?<substr2>(?&value)))?',
				'\\)'
			],
			'substringafter' => [
				'substring-after',
				'\\(',
				'(?<substringafter0>(?&value))',
				',',
				'(?<substringafter1>(?&string))',
				'\\)'
			],
			'substringbefore' => [
				'substring-before',
				'\\(',
				'(?<substringbefore0>(?&value))',
				',',
				'(?<substringbefore1>(?&value))',
				'\\)'
			],
			'startswith' => [
				'starts-with',
				'\\(',
				'(?<startswith0>(?&value))',
				',',
				'(?<startswith1>(?&value))',
				'\\)'
			],
			'math' => [
				'(?<math0>(?&attr)|(?&number)|(?&param))',
				'(?<math1>[-+*]|div)',
				'(?<math2>(?&math)|(?&math0))'
			],
			'notcontains' => [
				'not',
				'\\(',
				'contains',
				'\\(',
				'(?<notcontains0>(?&value))',
				',',
				'(?<notcontains1>(?&value))',
				'\\)',
				'\\)'
			]
		];

		$exprs = [];
		if (version_compare($this->pcreVersion, '8.13', '>='))
		{

			// Create a regexp that matches a parenthesized expression
			// NOTE: could be expanded to support any expression
			$exprs[] = '(?<parens>\\( (?<parens0>(?&bool)|(?&cmp)|(?&math)) \\))';

			// Create a regexp that matches boolean operations
			$exprs[] = '(?<bool>(?<bool0>(?&cmp)|(?&not)|(?&value)|(?&parens)) (?<bool1>and|or) (?<bool2>(?&bool)|(?&cmp)|(?&not)|(?&value)|(?&parens)))';

			// Create a regexp that matches not() expressions
			$exprs[] = '(?<not>not \\( (?<not0>(?&bool)|(?&value)) \\))';

			// Modify the math pattern to accept parenthesized expressions
			$patterns['math'][0] = str_replace('))', ')|(?&parens))', $patterns['math'][0]);
			$patterns['math'][1] = str_replace('))', ')|(?&parens))', $patterns['math'][1]);
		}

		// Create a regexp that matches values, such as "@foo" or "42"
		$valueExprs = [];
		foreach ($patterns as $name => $pattern)
		{
			if (is_array($pattern))
			{
				$pattern = implode(' ', $pattern);
			}

			if (strpos($pattern, '?&') === false || version_compare($this->pcreVersion, '8.13', '>='))
			{
				$valueExprs[] = '(?<' . $name . '>' . $pattern . ')';
			}
		}
		array_unshift($exprs, '(?<value>' . implode('|', $valueExprs) . ')');

		// Assemble the final regexp
		$regexp = '#^(?:' . implode('|', $exprs) . ')$#S';

		// Replace spaces with any amount of whitespace
		$regexp = str_replace(' ', '\\s*', $regexp);

		$this->regexp = $regexp;
	}

	/**
	* Match the relevant components of an XPath expression
	*
	* @param  string $expr XPath expression
	* @return array
	*/
	protected function matchXPathForExport($expr)
	{
		$tokenExprs = [
			'(?<current>\\bcurrent\\(\\))',
			'(?<param>\\$\\w+)',
			'(?<fragment>"[^"]*"|\'[^\']*\'|.)'
		];
		preg_match_all('(' . implode('|', $tokenExprs) . ')s', $expr, $matches, PREG_SET_ORDER);

		// Merge fragment tokens
		$i = count($matches);
		while (--$i > 0)
		{
			if (isset($matches[$i]['fragment'], $matches[$i - 1]['fragment']))
			{
				$matches[$i - 1]['fragment'] .= $matches[$i]['fragment'];
				unset($matches[$i]);
			}
		}

		return array_values($matches);
	}

	/**
	* Tokenize an XPath expression for use in PHP
	*
	* @param  string $expr XPath expression
	* @return array
	*/
	protected function tokenizeXPathForExport($expr)
	{
		$tokens = [];
		foreach ($this->matchXPathForExport($expr) as $match)
		{
			foreach (array_reverse($match) as $k => $v)
			{
				// Use the last non-numeric match
				if (!is_numeric($k))
				{
					$tokens[] = [$k, $v];
					break;
				}
			}
		}

		return $tokens;
	}
}