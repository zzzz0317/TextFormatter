<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class BooleanExpressions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'BooleanParam'  => 'boolean \\( \\$(\\w+) \\)',
			'HasAttribute'  => 'boolean \\( @ ([-\\w]+) \\)',
			'HasAttributes' => 'boolean \\( @\\* \\)',
			'NotAttribute'  => 'not \\( @ ([-\\w]+) \\)',
			'NotParam'      => 'boolean \\( \\$(\\w+) \\)'
		];
	}

	/**
	* Convert a call to boolean() with an attribute
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertHasAttribute($attrName)
	{
		return '$node->hasAttribute(' . var_export($attrName, true) . ')';
	}

	/**
	* Convert a call to boolean() with a param
	*
	* @param  string $paramName
	* @return string
	*/
	public function convertBooleanParam($paramName)
	{
		return '!empty($this->params[' . var_export($paramName, true) . '])';
	}

	/**
	* Convert a 
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertHasAttributes($attrName)
	{
		return '$node->attributes->length';
	}

	/**
	* Convert a call to not() with an attribute
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertNotAttribute($attrName)
	{
		return '!$node->hasAttribute(' . var_export($attrName, true) . ')';
	}

	/**
	* Convert a call to not() with a param
	*
	* @param  string $paramName
	* @return string
	*/
	public function convertNotParam($paramName)
	{
		return 'empty($this->params[' . var_export($paramName, true) . '])';
	}
}