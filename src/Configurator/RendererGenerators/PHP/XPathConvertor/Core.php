<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class Core extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'Attribute'     => 'String',
			'Dot'           => 'String',
			'LiteralNumber' => '-? \\d++',
			'LiteralString' => 'String',
			'LocalName'     => 'String',
			'Name'          => 'String',,
			'Parameter'     => 'String',
			'Parens'        => 'String',
			'Parens'        => 'String'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Attribute' => '@ ([-\\w]+)',
			'Dot'       => '\\.',
			'LocalName' => 'local-name \\(\\)',
			'Name'      => 'name \\(\\)',
			'Parameter' => '\\$(\\w+)',
			'Parens'    => '\\( (?R) \\)',
			'StringLiteral' => '"[^"]*"|\'[^\']*\''
		];
	}

	/**
	* Convert the attribute syntax
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertAttribute($attrName)
	{
		return '$node->getAttribute(' . var_export($attrName, true) . ')';
	}

	/**
	* Convert the dot syntax
	*
	* @return string
	*/
	public function convertDot()
	{
		return '$node->textContent';
	}

	/**
	* Convert a literal number
	*
	* @param  string $number
	* @return string
	*/
	public function convertLiteralNumber($number)
	{
		$number = ltrim($number, '0') ?: '0';

		return "'" . $number . "'";
	}

	/**
	* Convert a literal string
	*
	* @param  string $string Literal string, including the quotes
	* @return string
	*/
	public function convertLiteralString($string)
	{
		return var_export(substr($string, 1, -1), true);
	}

	/**
	* Convert a local-name() function call
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertLocalName()
	{
		return '$node->localName';
	}

	/**
	* Convert a name() function call
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertName()
	{
		return '$node->nodeName';
	}

	/**
	* Convert the paramsyntax
	*
	* @param  string $paramName
	* @return string
	*/
	public function convertParam($paramName)
	{
		return '$this->params[' . var_export($paramName, true) . ']';
	}

	/**
	* Convert a parenthesized expression
	*
	* @param  string $expr
	* @return string
	*/
	public function convertParens($expr)
	{
		return '(' . $this->convert($expr) . ')';
	}
}