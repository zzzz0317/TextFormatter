<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class BooleanOperators extends AbstractConvertor
{
	/**
	* {@inheritdoc}
	*/
	public function getRegexpGroups()
	{
		return [
			'And' => 'Boolean',
			'Or'  => 'Boolean'
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function getRegexps()
	{
		return [
			'And' => '((?&Boolean)|(?&Comparison)) and ((?&Boolean)|(?&Comparison))',
			'Or'  => '((?&Boolean)|(?&Comparison)) or ((?&Boolean)|(?&Comparison))'
		];
	}
}