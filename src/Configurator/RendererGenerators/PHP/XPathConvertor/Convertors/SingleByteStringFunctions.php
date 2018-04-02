<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

class SingleByteStringFunctions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'Contains'        => 'Boolean',
			'NotContains'     => 'Boolean',
			'NotStartsWith'   => 'Boolean',
			'StartsWith'      => 'Boolean',
			'StringLength'    => 'Number',
			'SubstringAfter'  => 'String',
			'SubstringBefore' => 'String',
			'Translate'       => 'String'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Contains'        => 'contains \\( ((?&String)) , ((?&String)) \\)',
			'NotContains'     => 'not \\( contains \\( ((?&String)) , ((?&String)) \\) \\)',
			'NotStartsWith'   => 'not \\( starts-with \\( ((?&String)) , ((?&String)) \\) \\)',
			'StartsWith'      => 'starts-with \\( ((?&String)) , ((?&String)) \\)',
			'StringLength'    => 'string-length \\( ((?&String)?) \\)',
			'SubstringAfter'  => 'substring-after \\( ((?&String)) , ((?&LiteralString)) \\)',
			'SubstringBefore' => 'substring-before \\( ((?&String)) , ((?&String)) \\)',
			'Translate'       => 'translate \\( ((?&String)) , ((?&LiteralString)) , ((?&LiteralString)) \\)'
		];
	}

	public function convertContains($haystack, $needle)
	{
		return '(strpos(' . $this->convert($haystack) . ',' . $this->convert($needle) . ')!==false)';
	}

	/**
	* Convert a call to not(contains())
	*
	* @param  string $haystack Expression for the haystack part of the call
	* @param  string $needle   Expression for the needle part of the call
	* @return string
	*/
	public function convertNotContains($haystack, $needle)
	{
		return '(strpos(' . $this->convert($haystack) . ',' . $this->convert($needle) . ')===false)';
	}

	public function convertNotStartsWith($string, $substring)
	{
		return '(strpos(' . $this->convert($string) . ',' . $this->convert($substring) . ')!==0)';
	}

	public function convertStartsWith($string, $substring)
	{
		return '(strpos(' . $this->convert($string) . ',' . $this->convert($substring) . ')===0)';
	}

	public function convertStringLength($expr)
	{
		if ($expr === '')
		{
			$expr = '.';
		}

		return "preg_match_all('(.)su'," . $this->convert($expr) . ')';
	}

	public function convertSubstringAfter($expr, $str)
	{
		return 'substr(strstr(' . $this->convert($expr) . ',' . $this->convert($str) . '),' . (strlen($str) - 2) . ')';
	}

	public function convertSubstringBefore($expr1, $expr2)
	{
		return 'strstr(' . $this->convert($expr1) . ',' . $this->convert($expr2) . ',true)';
	}

	public function convertTranslate($expr, $from, $to)
	{
		$from = $this->splitChars($from);
		$to   = $this->splitChars($to);

		// Add missing elements to $to then remove duplicates from $from and keep matching elements
		$to   = array_pad($to, count($from), '');
		$from = array_unique($from);
		$to   = array_intersect_key($to, $from);

		// Build the strtr() call
		$php = 'strtr(' . $this->convert($expr) . ',';
		if ($this->isAsciiChars($from) && $this->isAsciiChars($to))
		{
			$php .= var_export(implode('', $from), true) . ',' . var_export(implode('', $to), true);
		}
		else
		{
			$php .= $this->serializeMap($from, $to);
		}
		$php .= ')';

		return $php;
	}

	/**
	* Test whether given list of strings contains only single ASCII characters
	*
	* @param  string[] $chars
	* @return bool
	*/
	protected function isAsciiChars(array $chars)
	{
		return ([1] === array_unique(array_map('strlen', $chars)));
	}

	/**
	* Serialize the lists of characters to replace with strtr()
	*
	* @param  string[] $from
	* @param  string[] $to
	* @return string
	*/
	protected function serializeMap(array $from, array $to)
	{
		$elements = [];
		foreach ($from as $k => $str)
		{
			$elements[] = var_export($str, true) . '=>' . var_export($to[$k], true);
		}

		return '[' . implode(',', $elements) . ']';
	}

	/**
	* Split individual characters from given string
	*
	* @param  string   $string Original string, including quotes
	* @return string[]
	*/
	protected function splitStringChars($string)
	{
		preg_match_all('(.)su', substr($string, 1, -1), $matches);

		return $matches[0];
	}
}