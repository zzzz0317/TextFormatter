<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

class MultiByteStringManipulation extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'Substring' => 'String'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Substring' => 'substring \\( ((?&String)) , ((?&Math)|(?&Number)) (?:, ((?&Math)|(?&Number)))? \\)'
		];
	}

	/**
	* Convert a substring() function call
	*
	* @param  string         $exprString
	* @param  string         $exprPos
	* @param  integer|string $exprLen
	* @return string
	*/
	public function convertSubstring($exprString, $exprPos, $exprLen = null)
	{
		$args   = [];
		$args[] = $this->convert($exprString);
		$args[] = $this->convertPos($exprPos);
		$args[] = (isset($exprLen)) ? $this->convertLen($exprLen) : 'null';
		$args[] = "'utf-8'";

		return 'mb_substr(' . implode(',', $args) . ')';
	}

	/**
	* 
	*
	* @return void
	*/
	protected function convertLen($expr)
	{
		// NOTE: negative values for the second argument do not produce the same result as
		//       specified in XPath if the argument is not a literal number
		if (is_numeric($expr))
		{
			return max(0, $expr);
		}

		return 'max(0,' . $this->convert($expr) . ')';
	}

	/**
	* 
	*
	* @return void
	*/
	protected function convertPos($expr)
	{
		if (is_numeric($expr))
		{
			return max(0, $expr - 1);
		}

		return 'max(0,' . $this->convert($expr) . '-1)';
	}
}