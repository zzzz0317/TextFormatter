<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

abstract class AbstractConvertor
{
	/**
	* @var XPathConvertor
	*/
	protected $convertor;

	/**
	* Constructor
	*/
	public function __construct(XPathConvertor $convertor)
	{
		$this->convertor = $convertor;
	}

	/**
	* Return the name of the group each regexp belongs to
	*
	* @return array
	*/
	public function getRegexpGroups()
	{
		return [];
	}

	/**
	* 
	*
	* @return array
	*/
	abstract public function getRegexps();

	/**
	* 
	*
	* @param  string $expr
	* @return string
	*/
	protected function convert($expr)
	{
		$this->convertor->convertXPath($expr);
	}

	/**
	* Convert given expression
	*
	* @param  string $expr
	* @return string
	*/
	protected function convertExpression($expr)
	{
		return ($this->isNumber($expr)) ? $this->normalizeNumber($expr) : $this->convert($expr);
	}

	/**
	* Test whether given expression is a literal number
	*
	* @param  string $expr
	* @return bool
	*/
	protected function isNumber($expr)
	{
		return (bool) preg_match('(^-?\\s*\\d++$)', $expr);
	}

	/**
	* Normalize a number representation
	*
	* @param  string $sign
	* @param  string $number
	* @return string
	*/
	protected function normalizeNumber($sign, $number)
	{
		// Remove leading zeros and normalize -0 to 0
		$number = ltrim($number, '0');

		return ($number === '') ? '0' : $sign . $number;
	}
}