<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class MultiByteStringFunctions extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'Substring' => 'substring \\( ((?&value)) , ((?&value)) (?:, ((?&value)))? \\)'
		];
	}
}