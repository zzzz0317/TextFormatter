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
			'GreaterThanOrEqualTo' => '((?&Number)|(?&String)) >= ([1-9]\\d*)',
			'LessThan'             => '(\\d+) < ((?&Number)|(?&String))',
			'LessThanOrEqualTo'    => '([1-9]\\d*) <= ((?&Number)|(?&String))',
			'NonEquality'          => '((?&Number)|(?&String)) != ((?&Number)|(?&String))'
		];
	}

	/**
	* Convert a call to boolean() with an attribute
	*
	* @param  string $attrName
	* @return string
	*/
	public function convertEquality($expr1, $operator, $expr2)
	{
		

		// If either operand is a number, represent it as a PHP number and replace the identity
		// identity operators
		foreach ([$expr1, $expr2] as $expr)
		{
			if (is_numeric($expr))
			{
				$operators['=']  = '==';
				$operators['!='] = '!=';

				$operands[] = preg_replace('(^0(.+))', '$1', $expr);
			}
			else
			{
				$operands[] = $this->convert($expr);
			}
		}

		return implode($operators[$operator], $operands);
	}
}