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
	* Return whether this convertor can be used recursively
	*
	* @return bool
	*/
	public function canRecurse()
	{
		return true;
	}

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
}