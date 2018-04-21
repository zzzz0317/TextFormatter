<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP;

use RuntimeException;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Runner;

class XPathConvertor
{
	/**
	* @var Runner
	*/
	protected $runner;

	/**
	* Constructor
	*/
	public function __construct(Runner $runner = null)
	{
		if (!isset($runner))
		{
			$runner = new Runner;
			$runner->setDefaultConvertors();
		}

		$this->runner = $runner;
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
		// Replace @attr with boolean(@attr) in boolean expressions
		$expr = preg_replace(
			'((^|\\(\\s*|\\s(?:and|or)\\s*)([\\(\\s]*)([$@][-\\w]+|@\\*)([\\)\\s]*)(?=$|\\s+(?:and|or)))',
			'$1$2boolean($3)$4',
			trim($expr)
		);

		// Replace not(boolean(@attr)) with not(@attr)
		$expr = preg_replace(
			'(not\\(boolean\\(([$@][-\\w]+)\\)\\))',
			'not($1)',
			$expr
		);

		try
		{
			return $this->runner->convert($expr);
		}
		catch (RuntimeException $e)
		{
			// Do nothing
		}

		// If the condition does not seem to contain a relational expression, or start with a
		// function call, we wrap it inside of a boolean() call
		if (!preg_match('([=<>]|\\bor\\b|\\band\\b|^[-\\w]+\\s*\\()', $expr))
		{
			$expr = 'boolean(' . $expr . ')';
		}

		return '$this->xpath->evaluate(' . $this->exportXPath($expr) . ',$node)';
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
		try
		{
			return $this->runner->convert($expr);
		}
		catch (RuntimeException $e)
		{
			// Do nothing
		}

		// Replace parameters in the expression
		return '$this->xpath->evaluate(' . $this->exportXPath($expr) . ',$node)';
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