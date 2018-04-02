<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

class Runner
{
	/**
	* @var AbstractConvertor[]
	*/
	protected $convertors;

	/**
	* 
	*
	* @return void
	*/
	public function setConvertors(array $convertors)
	{
		$this->convertors = $convertors;

		$this->buildRegexp();
	}

	/**
	* 
	*
	* @return void
	*/
	protected function buildRegexp()
	{
		$exprs = [];
		foreach ($this->convertors as $convertor)
		{
			$exprs += $convertor->getRegexps();
		}

		foreach ($exprs as $name => $expr)
		{
			$expr = $this->insertCaptureNames($name, $expr);
			$expr = str_replace(' ', '\\s*', $expr);
			$expr = '(?<' . $name . '>' . $expr . ')';

			$exprs[$name] = $expr;
		}

		print_r($exprs);
	}

	/**
	* 
	*
	* @return void
	*/
	protected function insertCaptureNames($name, $regexp)
	{
		$i = 0;
		return preg_replace_callback(
			'((?<!\\\\)\\((?![&:]))',
			function ($m) use (&$i, $name)
			{
				return '(?<' . $name . $i++ . '>';
			},
			$regexp
		);
	}

	/**
	* 
	*
	* @return void
	*/
	public function convert($expr)
	{

	}
}