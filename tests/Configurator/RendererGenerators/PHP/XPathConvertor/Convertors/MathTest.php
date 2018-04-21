<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\AbstractConvertor
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\Math
*/
class MathTest extends AbstractConvertorTest
{
	public function getConvertorTests()
	{
		return [
			// Addition
			[
				'@foo + 10',
				"\$node->getAttribute('foo')+10"
			],
			[
				'5 + 5',
				'5+5'
			],
			[
				'1 + 2 + 3',
				'1+2+3'
			],
			// Division
			[
				'10 div 2',
				'10/2'
			],
			[
				'10 div 2 + 1',
				'10/2+1'
			],
			// MathSub
			[
				'10 div (2 + 1)',
				'10/(2+1)'
			],
			// Multiplication
			[
				'1 * 2',
				'1*2'
			],
			[
				'1 * 2 * 3',
				'1*2*3'
			],
			// Substraction
			[
				'@foo - 10',
				"\$node->getAttribute('foo')-10"
			],
			[
				'6 - (2 * 3)',
				'6-(2*3)'
			],
		];
	}
}