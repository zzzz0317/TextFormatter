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
			'Contains'        => 'contains \\( ((?&Value)) , ((?&Value)) \\)',
			'StartsWith'      => 'starts-with \\( ((?&Value)) , ((?&Value)) \\)',
			'StringLength'    => 'string-length \\( ((?&Value)?) \\)',
			'SubstringAfter'  => 'substring-after \\( ((?&Value)) , ((?&String)) \\)',
			'SubstringBefore' => 'substring-before \\( ((?&Value)) , ((?&Value)) \\)',
			'Translate'       => 'translate \\( ((?&Value)) , ((?&String)) , ((?&String)) \\)'
		];
	}

	public function convertContains($haystack, $needle)
	{
		return '(strpos(' . $this->convert($haystack) . ',' . $this->convert($needle) . ')!==false)';
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