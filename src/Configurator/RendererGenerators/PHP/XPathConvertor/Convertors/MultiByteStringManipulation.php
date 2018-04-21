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
			'Substring' => 'substring \\( ((?&String)) , ((?&Number)) (?:, ((?&Number)))? \\)'
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
	public function convertSubstring($exprString, $exprPos, $exprLen = PHP_INT_MAX)
	{
		$args = [$this->convert($exprString)];

		// NOTE: negative values for the second argument do not produce the same result as
		//       specified in XPath if the argument is not a literal number

		// Hardcode the value if possible
		if (is_numeric($exprPos))
		{
			$args[] = max(0, $exprPos - 1);
		}
		else
		{
			$args[] = 'max(0,' . $this->convert($exprPos) . '-1)';
		}

		if (is_numeric($exprLen))
		{
			$len = $exprLen;
			if (is_numeric($exprPos) && $exprPos < 1)
			{
				// Handle substring(0,2) as per XPath 1.0
				$len += $exprPos - 1;
			}
			$args[] = max(0, $len);
		}
		else
		{
			$args[] = 'max(0,' . $this->convert($exprLen) . ')';
		}
		$args[] = "'utf-8'";

		return 'mb_substr(' . implode(',', $args) . ')';
	}
}