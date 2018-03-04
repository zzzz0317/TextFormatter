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
	* 
	*
	* @return array[]
	*/
	abstract public function getRegexps();

	/**
	* 
	*
	* @param  string $expr
	* @return string
	*/
	protected function convertCondition($expr)
	{
		$this->convertor->convertCondition($expr);
	}

	/**
	* 
	*
	* @param  string $expr
	* @return string
	*/
	protected function convertXPath($expr)
	{
		$this->convertor->convertXPath($expr);
	}
}