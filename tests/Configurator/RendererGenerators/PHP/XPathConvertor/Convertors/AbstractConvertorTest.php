<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Runner;
use s9e\TextFormatter\Tests\Test;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\AbstractConvertor
*/
abstract class AbstractConvertorTest extends Test
{
	/**
	* @dataProvider getConvertorTests
	*/
	public function test($original, $expected)
	{
		$runner = new Runner;
		$runner->setDefaultConvertors();

		if ($expected === false)
		{
			$this->setExpectedException('RuntimeException', 'Cannot convert');
		}

		$this->assertEquals($expected, $runner->convert($original));
	}

	abstract public function getConvertorTests();
}