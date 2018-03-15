<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class StringFunctions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Contains'        => 'contains \\( ((?&value)) , ((?&value)) \\)',
			'NotContains'     => 'not \\( contains \\( ((?&value)) , ((?&value)) \\) \\)'
			'StartsWith'      => 'starts-with \\( ((?&value)) , ((?&value)) \\)',
			'StringLength'    => 'string-length \\( ((?&value)?) \\)',
			'SubstringAfter'  => 'substring-after \\( ((?&value)) , ((?&string)) \\)',
			'SubstringBefore' => 'substring-before \\( ((?&value)) , ((?&value)) \\)',
			'Translate'       => 'translate \\( ((?&value)) , ((?&string)) , ((?&string)) \\)'
		];
	}

	public function convertStringLength($expr)
	{
		if ($expr === '')
		{
			$expr = '.';
		}

		return "preg_match_all('(.)su'," . $this->convertXPath($expr) . ')';
	}

	public function convertContains($haystack, $needle)
	{
		return '(strpos(' . $this->convertXPath($haystack) . ',' . $this->convertXPath($needle) . ')!==false)';
	}

	public function convertNotContains($haystack, $needle)
	{
		return '(strpos(' . $this->convertXPath($haystack) . ',' . $this->convertXPath($needle) . ')===false)';
	}

	public function convertStartsWith($string, $substring)
	{
		return '(strpos(' . $this->convertXPath($string) . ',' . $this->convertXPath($substring) . ')===0)';
	}

	public function convertSubstringAfter($expr, $str)
	{
		return 'substr(strstr(' . $this->convertXPath($expr) . ',' . $this->convertXPath($str) . '),' . (strlen($str) - 2) . ')';
	}

	public function convertSubstringBefore($expr1, $expr2)
	{
		return 'strstr(' . $this->convertXPath($expr1) . ',' . $this->convertXPath($expr2) . ',true)';
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
		$php = 'strtr(' . $this->convertXPath($expr) . ',';
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