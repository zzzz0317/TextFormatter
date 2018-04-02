<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

class BooleanOperators extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'BooleanSub' => 'Boolean'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'And'        => '((?&Boolean)|(?&Comparison)) and ((?&And)|(?&Boolean)|(?&Comparison)|(?&Or))',
			'BooleanSub' => '\\( ((?&And)|(?&Boolean)|(?&Comparison)|(?&Or)) \\)',
			'Or'         => '((?&Boolean)|(?&Comparison)) or ((?&And)|(?&Boolean)|(?&Comparison)|(?&Or))'
		];
	}

	/**
	* Convert a "and" operation
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertAnd($expr1, $expr2)
	{
		return $this->convert($expr1) . '&&' . $this->convert($expr2);
	}

	/**
	* Convert a boolean subexpression
	*
	* @param  string $expr
	* @return string
	*/
	public function convertBooleanSub($expr)
	{
		return '(' . $this->convert($expr) . ')';
	}

	/**
	* Convert a "or" operation
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertOr($expr1, $expr2)
	{
		return $this->convert($expr1) . '||' . $this->convert($expr2);
	}
}