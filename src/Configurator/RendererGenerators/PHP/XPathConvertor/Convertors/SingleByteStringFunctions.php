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
			'Contains'      => 'Boolean',
			'NotContains'   => 'Boolean',
			'NotStartsWith' => 'Boolean',
			'StartsWith'    => 'Boolean',
			'StringLength'  => 'Number'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Contains'      => 'contains \\( ((?&String)) , ((?&String)) \\)',
			'NotContains'   => 'not \\( contains \\( ((?&String)) , ((?&String)) \\) \\)',
			'NotStartsWith' => 'not \\( starts-with \\( ((?&String)) , ((?&String)) \\) \\)',
			'StartsWith'    => 'starts-with \\( ((?&String)) , ((?&String)) \\)',
			'StringLength'  => 'string-length \\( ((?&String))? \\)'
		];
	}

	/**
	* Convert a call to contains()
	*
	* @param  string $haystack Expression for the haystack part of the call
	* @param  string $needle   Expression for the needle part of the call
	* @return string
	*/
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

	/**
	* Convert a call to not(starts-with())
	*
	* @param  string $string    Expression for the string part of the call
	* @param  string $substring Expression for the substring part of the call
	* @return string
	*/
	public function convertNotStartsWith($string, $substring)
	{
		return '(strpos(' . $this->convert($string) . ',' . $this->convert($substring) . ')!==0)';
	}

	/**
	* Convert a call to starts-with()
	*
	* @param  string $string    Expression for the string part of the call
	* @param  string $substring Expression for the substring part of the call
	* @return string
	*/
	public function convertStartsWith($string, $substring)
	{
		return '(strpos(' . $this->convert($string) . ',' . $this->convert($substring) . ')===0)';
	}

	/**
	* Convert a call to string-length()
	*
	* @param  string $expr
	* @return string
	*/
	public function convertStringLength($expr = '.')
	{
		return "preg_match_all('(.)su'," . $this->convert($expr) . ')';
	}
}