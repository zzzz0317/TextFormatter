<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\AbstractConvertor
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\MultiByteStringManipulation
*/
class MultiByteStringManipulationTest extends AbstractConvertorTest
{
	public function getConvertorTests()
	{
		return [
			// Substring
			[
				"substring('\xC3\xB7\xC3\xB7\xC3\xB7', 2, 1)",
				"mb_substr('\xC3\xB7\xC3\xB7\xC3\xB7',1,1,'utf-8')"
			],
			[
				"substring('\xC3\xB7\xC3\xB7\xC3\xB7', 2)",
				"mb_substr('\xC3\xB7\xC3\xB7\xC3\xB7',1,1,'utf-8')"
			],
		];
	}
}