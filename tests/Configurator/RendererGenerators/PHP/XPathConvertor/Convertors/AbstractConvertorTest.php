<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\BooleanFunctions;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\BooleanOperators;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Comparisons;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Core;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Math;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\MultiByteStringManipulation;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\SingleByteStringFunctions;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\SingleByteStringManipulation;
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
		$runner->setConvertors([
			new BooleanFunctions($runner),
			new BooleanOperators($runner),
			new Comparisons($runner),
			new Core($runner),
			new Math($runner),
			new MultiByteStringManipulation($runner),
			new SingleByteStringFunctions($runner),
			new SingleByteStringManipulation($runner)
		]);

		$this->assertEquals($expected, $runner->convert($original));
	}

	abstract public function getConvertorTests();
}