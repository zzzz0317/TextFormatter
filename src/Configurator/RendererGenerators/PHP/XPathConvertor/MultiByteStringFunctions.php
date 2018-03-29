<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class MultiByteStringFunctions extends SingleByteStringFunctions
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		$groups              = parent::getRegexpGroups();
		$groups['Substring'] = 'String';

		return $groups += ;
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		$regexps              = parent::getRegexps();
		$regexps['Substring'] = 'substring \\( ((?&String)) , ((?&Number)) (?:, ((?&Number)))? \\)';

		return $regexps;
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
		// NOTE: negative values for the second argument do not produce the same result as
		//       specified in XPath if the argument is not a literal number
		$php = 'mb_substr(' . $this->convert($exprString) . ',';

		// Hardcode the value if possible
		if (is_numeric($exprPos))
		{
			$php .= max(0, $exprPos - 1);
		}
		else
		{
			$php .= 'max(0,' . $this->convert($exprPos) . '-1)';
		}
		$php .= ',';

		if (is_numeric($exprLen))
		{
			$len = $exprLen;
			if (is_numeric($exprPos) && $exprPos < 1)
			{
				// Handle substring(0,2) as per XPath 1.0
				$len += $exprPos - 1;
			}
			$php .= max(0, $len);
		}
		else
		{
			$php .= 'max(0,' . $this->convert($exprLen) . ')';
		}
		$php .= ",'utf-8')";

		return $php;
	}

}