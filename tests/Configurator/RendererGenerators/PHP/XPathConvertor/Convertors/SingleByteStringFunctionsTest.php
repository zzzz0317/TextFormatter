<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Runner
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\AbstractConvertor
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor\Convertors\SingleByteStringFunctions
*/
class SingleByteStringFunctionsTest extends AbstractConvertorTest
{
	public function getConvertorTests()
	{
		return [
			// Contains
			[
				'contains(@foo, @bar)',
				"(strpos(\$node->getAttribute('foo'),\$node->getAttribute('bar'))!==false)"
			],
			// NotContains
			[
				'not(contains(@foo, @bar))',
				"(strpos(\$node->getAttribute('foo'),\$node->getAttribute('bar'))===false)"
			],
			// NotStartsWith
			[
				'not(starts-with(@foo, @bar))',
				"(strpos(\$node->getAttribute('foo'),\$node->getAttribute('bar'))!==0)"
			],
			// StartsWith
			[
				'starts-with(@foo, @bar)',
				"(strpos(\$node->getAttribute('foo'),\$node->getAttribute('bar'))===0)"
			],
			// StringLength
			[
				'string-length(@foo)',
				"preg_match_all('(.)su',\$node->getAttribute('foo'))"
			],
		];
	}
}