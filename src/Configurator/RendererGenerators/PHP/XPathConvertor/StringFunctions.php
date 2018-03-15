<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class StringFunctions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Contains'        => 'contains \\( ((?&value)) , ((?&value)) \\)',
			'NotContains'     => 'not \\( contains \\( ((?&value)) , ((?&value)) \\) \\)'
			'StartsWith'      => 'starts-with \\( ((?&value)) , ((?&value)) \\)',
			'StringLength'    => 'string-length \\( ((?&value)?) \\)',
			'SubstringAfter'  => 'substring-after \\( ((?&value)) , ((?&string)) \\)',
			'SubstringBefore' => 'substring-before \\( ((?&value)) , ((?&value)) \\)',
			'Translate'       => 'translate \\( ((?&value)) , ((?&string)) , ((?&string)) \\)'
		];
	}
}