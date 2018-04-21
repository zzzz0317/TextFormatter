<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Runner;
use s9e\TextFormatter\Tests\Test;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Core
*/
class CoreTest extends Test
{
	/**
	* @dataProvider getConvertorTests
	*/
	public function test($original, $expected)
	{
		$runner = new Runner;
		$runner->setConvertors([new \s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Core($runner)]);

		$this->assertEquals($expected, $runner->convert($original));
	}

	public function getConvertorTests()
	{
		return [
			[
				"'foo'",
				"'foo'"
			],
			[
				'"foo"',
				"'foo'"
			],
		];
	}
}