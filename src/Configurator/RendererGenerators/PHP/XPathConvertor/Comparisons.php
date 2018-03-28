<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class Comparisons extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'Equality'             => 'Comparison',
			'GreaterThan'          => 'Comparison',
			'GreaterThanOrEqualTo' => 'Comparison',
			'LessThan'             => 'Comparison',
			'LessThanOrEqualTo'    => 'Comparison',
			'NonEquality'          => 'Comparison'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Equality'             => '((?&Number)|(?&String)) = ((?&Number)|(?&String))',
			'GreaterThan'          => '((?&Number)|(?&String)) > (\\d+)',
			'GreaterThanOrEqualTo' => '((?&Number)|(?&String)) >= (0*[1-9]\\d*)',
			'LessThan'             => '(\\d+) < ((?&Number)|(?&String))',
			'LessThanOrEqualTo'    => '(0*[1-9]\\d*) <= ((?&Number)|(?&String))',
			'NonEquality'          => '((?&Number)|(?&String)) != ((?&Number)|(?&String))'
		];
	}

	/**
	* Convert an equality test
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertEquality($expr1, $expr2)
	{
		$operator = ($this->isNumber($expr1) && $this->isNumber($expr2)) ? '===' : '==';

		return $this->convertComparison($expr1, $operator, $expr2);
	}

	/**
	* Convert a "greater than" comparison
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertGreaterThan($expr1, $expr2)
	{
		return $this->convertComparison($expr1, '>', $expr2);
	}

	/**
	* Convert a "greater than or equal to" comparison
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertGreaterThanOrEqualTo($expr1, $expr2)
	{
		return $this->convertComparison($expr1, '>=', $expr2);
	}

	/**
	* Convert a "less than" comparison
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertLessThan($expr1, $expr2)
	{
		return $this->convertComparison($expr1, '<', $expr2);
	}

	/**
	* Convert a "less than or equal to" comparison
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertLessThanOrEqualTo($expr1, $expr2)
	{
		return $this->convertComparison($expr1, '<=', $expr2);
	}

	/**
	* Convert a non-equality test
	*
	* @param  string $expr1
	* @param  string $expr2
	* @return string
	*/
	public function convertNonEquality($expr1, $expr2)
	{
		$operator = ($this->isNumber($expr1) && $this->isNumber($expr2)) ? '!==' : '!=';

		return $this->convertComparison($expr1, $operator, $expr2);
	}

	/**
	* Convert a comparison
	*
	* @param  string $expr1
	* @param  string $operator
	* @param  string $expr2
	* @return string
	*/
	protected function convertComparison($expr1, $operator, $expr2)
	{
		$expr1 = ($this->isNumber($expr1)) ? Core::normalizeNumber($expr1) : $this->convert($expr1);
		$expr2 = ($this->isNumber($expr2)) ? Core::normalizeNumber($expr2) : $this->convert($expr2);

		return $expr1 . $operator . $expr2;
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
}