<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2018 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;

use RuntimeException;

class Runner
{
	/**
	* @var array
	*/
	protected $callbacks;

	/**
	* @var string
	*/
	protected $regexp = '((?!))';

	/**
	* 
	*
	* @return string
	*/
	public function convert($expr)
	{
		if (preg_match($this->regexp, $expr, $m))
		{
			foreach (array_reverse(array_keys($m)) as $name)
			{
				if (isset($this->callbacks[$name]))
				{
					return call_user_func_array($this->callbacks[$name], $this->getArguments($m, $name));
				}
			}
		}

		throw new RuntimeException('Cannot convert ' . $expr);
	}

	/**
	* 
	*
	* @return void
	*/
	public function setConvertors(array $convertors)
	{
		$this->callbacks = [];
		$groups          = [];
		$regexps         = [];
		foreach ($convertors as $convertor)
		{
			foreach ($convertor->getRegexpGroups() as $name => $group)
			{
				$groups[$group][] = '(?&' . $name . ')';
			}

			foreach ($convertor->getRegexps() as $name => $regexp)
			{
				$regexp = $this->insertCaptureNames($name, $regexp);
				$regexp = str_replace(' ', '\\s*', $regexp);
				$regexp = '(?<' . $name . '>' . $regexp . ')';

				$regexps[$name]         = $regexp;
				$this->callbacks[$name] = [$convertor, 'convert' . $name];
			}
		}

		foreach ($groups as $group => $captures)
		{
			sort($captures);
			$regexps[] = '(?<' . $group . '>' . implode('|', $captures) . ')';
		}

		$this->regexp = '(^(?:' . implode('|', $regexps) . ')$)';
	}

	/**
	* 
	*
	* @param  array    $matches
	* @param  string   $name
	* @return string[]
	*/
	protected function getArguments(array $matches, $name)
	{
		$args = [];
		$i    = 0;
		while (isset($matches[$name . $i]))
		{
			$args[] = $matches[$name . $i];
			++$i;
		}

		return $args;
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
			'((?<!\\\\)\\((?!\\?))',
			function ($m) use (&$i, $name)
			{
				return '(?<' . $name . $i++ . '>';
			},
			$regexp
		);
	}
}