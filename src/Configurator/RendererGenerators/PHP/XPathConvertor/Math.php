<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class Math extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Math' => '((?&Attribute)|(?&Number)|(?&Param)|(?&Parens)) ([-+*]|div) ((?-4)|(?-3))'
		];
	}

	/**
	* Convert an arithmetic operation
	*
	* @param  string $expr1
	* @param  string $operator
	* @param  string $expr2
	* @return string
	*/
	public function convertMath($expr1, $operator, $expr2)
	{
		if (!is_numeric($expr1))
		{
			$expr1 = $this->convertXPath($expr1);
		}
		if (!is_numeric($expr2))
		{
			$expr2 = $this->convertXPath($expr2);
		}
		if ($operator === 'div')
		{
			$operator = '/';
		}

		return $expr1 . $operator . $expr2;
	}
}