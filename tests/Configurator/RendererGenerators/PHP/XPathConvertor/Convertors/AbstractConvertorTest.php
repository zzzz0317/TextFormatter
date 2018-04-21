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
		$className = substr(get_class($this), 0, -4);
		$className = str_replace('\\Tests\\', '\\', $className);

		$runner = new Runner;
		$runner->setConvertors([new $className($runner)]);

		$this->assertEquals($expected, $runner->convert($original));
	}

	abstract public function getConvertorTests();
}