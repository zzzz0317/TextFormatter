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
			'Contains'        => 'contains \\( (?<0>(?&value)) , (?<1>(?&value)) \\)',
			'NotContains'     => 'not \\( contains \\( (?<0>(?&value)) , (?<1>(?&value)) \\) \\)'
			'StartsWith'      => 'starts-with \\( (?<0>(?&value)) , (?<1>(?&value)) \\)',
			'StringLength'    => 'string-length \\( (?<0>(?&value)?) \\)',
			'SubstringAfter'  => 'substring-after \\( (?<0>(?&value)) , (?<1>(?&string)) \\)',
			'SubstringBefore' => 'substring-before \\( (?<0>(?&value)) , (?<1>(?&value)) \\)',
			'Translate'       => 'translate \\( (?<0>(?&value)) , (?<1>(?&string)) , (?<2>(?&string)) \\)'
		];
	}
}