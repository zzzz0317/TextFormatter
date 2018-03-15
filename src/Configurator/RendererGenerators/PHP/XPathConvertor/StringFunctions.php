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
}