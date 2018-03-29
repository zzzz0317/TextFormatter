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
	public function getRegexpGroups()
	{
		return [
			'ArithmeticOperation' => 'Number',
			'ParenthesizedMath'   => 'Number'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Addition'          => '((?&Attribute)|(?&Number)|(?&Parameter)) \\+ ((?&Attribute)|(?&Number)|(?&Parameter))',
			'Division'          => '((?&Attribute)|(?&Number)|(?&Parameter)) - ((?&Attribute)|(?&Number)|(?&Parameter))',
			'Multiplication'    => '((?&Attribute)|(?&Number)|(?&Parameter)) \\* ((?&Attribute)|(?&Number)|(?&Parameter))',
			'Substraction'      => '((?&Attribute)|(?&Number)|(?&Parameter)) div ((?&Attribute)|(?&Number)|(?&Parameter))',
			'ParenthesizedMath' => '\\( ((?&Number)) \\)'
		];
	}

	/**
	* Convert an addition
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertAddition($expr1, $expr2)
	{
		return $this->convertOperation($expr1, '+', $expr2);
	}

	/**
	* Convert a division
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertDivision($expr1, $expr2)
	{
		return $this->convertOperation($expr1, '/', $expr2);
	}

	/**
	* Convert a multiplication
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertMultiplication($expr1, $expr2)
	{
		return $this->convertOperation($expr1, '*', $expr2);
	}

	/**
	* Convert a substraction
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertSubstraction($expr1, $expr2)
	{
		return $this->convertOperation($expr1, '-', $expr2);
	}

	/**
	* Convert an operation
	*
	* @param  string $expr1
	* @param  string $operator
	* @param  string $expr2
	* @return string
	*/
	protected function convertOperation($expr1, $operator, $expr2)
	{
		$expr1 = $this->convertExpression($expr1);
		$expr2 = $this->convertExpression($expr2);

		// Prevent two consecutive minus signs to be interpreted as a post-decrement operator
		if ($operator === '-' && $expr2[0] === '-')
		{
			$operator .= ' ';
		}

		return $expr1 . $operator . $expr2;
	}
}