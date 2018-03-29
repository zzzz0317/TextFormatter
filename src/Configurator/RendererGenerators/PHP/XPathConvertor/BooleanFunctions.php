<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class BooleanFunctions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'BooleanParam'  => 'Boolean',
			'HasAttribute'  => 'Boolean',
			'HasAttributes' => 'Boolean',
			'Not'           => 'Boolean',
			'NotAttribute'  => 'Boolean',
			'NotParam'      => 'Boolean'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'BooleanParam'  => 'boolean \\( (?&Parameter) \\)',
			'HasAttribute'  => 'boolean \\( (?&Attribute) \\)',
			'HasAttributes' => 'boolean \\( @\\* \\)',
			'Not'           => 'not \\( ((?&Boolean)|(?&Comparison)) \\)',
			'NotAttribute'  => 'not \\( (?&Attribute) \\)',
			'NotParam'      => 'not \\( (?&Parameter) \\)'
		];
	}

	/**
	* Convert a call to boolean() with a param
	*
	* @param  string $paramName
	* @return string
	*/
	public function convertBooleanParam($paramName)
	{
		return '($this->params[' . var_export($paramName, true) . "]!=='')";
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
	* Convert a call to boolean(@*)
	*
	* @return string
	*/
	public function convertHasAttributes($attrName)
	{
		return '$node->attributes->length';
	}

	/**
	* Convert a call to not() with a boolean expression
	*
	* @param  string $expr
	* @return string
	*/
	public function convertNot($expr)
	{
		return '!(' . $this->convertConditional($expr) . ')';
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
		return '($this->params[' . var_export($paramName, true) . "]==='')";
	}
}