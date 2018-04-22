<?php

namespace s9e\TextFormatter\Tests\Configurator\RendererGenerators\PHP;

use Exception;
use ReflectionMethod;
use ReflectionProperty;
use RuntimeException;
use s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor;
use s9e\TextFormatter\Tests\Test;

/**
* @covers s9e\TextFormatter\Configurator\RendererGenerators\PHP\XPathConvertor
*/
class XPathConvertorTest extends Test
{
	/**
	* @dataProvider getConvertXPathTestsBasic
	* @testdox convertXPath() basic tests
	*/
	public function testConvertXPathBasic($original, $expected)
	{
		$convertor = new XPathConvertor;
		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}
		$this->assertSame($expected, $convertor->convertXPath($original));
	}

	/**
	* @dataProvider getConvertXPathTestsAdvanced
	* @testdox convertXPath() advanced tests (PCRE >= 8.13)
	*/
	public function testConvertXPathAdvanced($original, $expected, $fallback = null)
	{
		if (version_compare(PCRE_VERSION, '8.13', '<'))
		{
			$this->markTestSkipped('This optimization requires PCRE 8.13 or newer');
		}
		$convertor = new XPathConvertor;
		$this->assertSame($expected, $convertor->convertXPath($original));
	}

	/**
	* @dataProvider getConvertXPathTestsMbstring
	* @testdox convertXPath() mbstring tests
	*/
	public function testConvertXPathMbstring($original, $expected, $setup = null)
	{
		if (version_compare(PCRE_VERSION, '8.13', '<'))
		{
			$this->markTestSkipped('This optimization requires PCRE 8.13 or newer');
		}
		$convertor = new XPathConvertor;
		$convertor->useMultibyteStringFunctions = true;
		$this->assertSame($expected, $convertor->convertXPath($original));
	}

	/**
	* @dataProvider getConvertConditionTestsBasic
	* @testdox convertCondition() basic tests
	*/
	public function testConvertConditionBasic($original, $expected)
	{
		$convertor = new XPathConvertor;
		$this->assertSame($expected, $convertor->convertCondition($original));
	}

	/**
	* @dataProvider getConvertConditionTestsAdvanced
	* @testdox convertCondition() advanced tests (PCRE >= 8.13)
	*/
	public function testConvertConditionAdvanced($original, $expected, $fallback = null)
	{
		if (version_compare(PCRE_VERSION, '8.13', '<'))
		{
			$this->markTestSkipped('This optimization requires PCRE 8.13 or newer');
		}
		$convertor = new XPathConvertor;
		$this->assertSame($expected, $convertor->convertCondition($original));
	}

	public function getConvertXPathTestsBasic()
	{
		return [
			[
				'@bar',
				"\$node->getAttribute('bar')"
			],
			[
				'.',
				"\$node->textContent"
			],
			[
				'$foo',
				"\$this->params['foo']"
			],
			[
				"'foo'",
				"'foo'"
			],
			[
				'"foo"',
				"'foo'"
			],
			[
				'local-name()',
				'$node->localName'
			],
			[
				'name()',
				'$node->nodeName'
			],
			[
				'123',
				'123'
			],
			[
				'normalize-space(@bar)',
				"\$this->xpath->evaluate('normalize-space(@bar)',\$node)"
			],
//			[
//				'substring(.,1,2)',
//				"\$this->xpath->evaluate('substring(.,1,2)',\$node)"
//			],
//			[
//				'substring(.,0,2)',
//				"\$this->xpath->evaluate('substring(.,0,2)',\$node)"
//			],
//			[
//				'substring(.,@x,1)',
//				"\$this->xpath->evaluate('substring(.,@x,1)',\$node)"
//			],
//			[
//				'substring(.,1,@x)',
//				"\$this->xpath->evaluate('substring(.,1,@x)',\$node)"
//			],
//			[
//				'substring(.,2)',
//				"\$this->xpath->evaluate('substring(.,2)',\$node)"
//			],
			[
				'//X[@a = current()/@a]',
				"\$this->xpath->evaluate('//X[@a = '.\$node->getNodePath().'/@a]',\$node)"
			],
			[
				'0',
				'0'
			],
			[
				'0777',
				'777'
			],
			[
				'-0777',
				'-777'
			],
		];
	}

	public function getConvertXPathTestsAdvanced()
	{
		return [
			[
				'string-length(@bar)',
				"preg_match_all('(.)su',\$node->getAttribute('bar'))"
			],
			[
				'string-length()',
				"preg_match_all('(.)su',\$node->textContent)"
			],
			[
				'translate(@bar,"abc","ABC")',
				"strtr(\$node->getAttribute('bar'),'abc','ABC')",
				"\$this->xpath->evaluate('translate(@bar,\"abc\",\"ABC\")',\$node)",
			],
			[
				'translate(@bar,"abc","ABC")',
				"strtr(\$node->getAttribute('bar'),'abc','ABC')",
				"\$this->xpath->evaluate('translate(@bar,\"abc\",\"ABC\")',\$node)"
			],
			[
				'translate(@bar,"éè","ÉÈ")',
				"strtr(\$node->getAttribute('bar'),['é'=>'É','è'=>'È'])",
				"\$this->xpath->evaluate('translate(@bar,\"éè\",\"ÉÈ\")',\$node)"
			],
			[
				'translate(@bar,"ab","ABC")',
				"strtr(\$node->getAttribute('bar'),'ab','AB')",
				"\$this->xpath->evaluate('translate(@bar,\"ab\",\"ABC\")',\$node)"
			],
			[
				'translate(@bar,"abcd","AB")',
				"strtr(\$node->getAttribute('bar'),['a'=>'A','b'=>'B','c'=>'','d'=>''])",
				"\$this->xpath->evaluate('translate(@bar,\"abcd\",\"AB\")',\$node)"
			],
			[
				'translate(@bar,"abbd","ABCD")',
				"strtr(\$node->getAttribute('bar'),'abd','ABD')",
				"\$this->xpath->evaluate('translate(@bar,\"abbd\",\"ABCD\")',\$node)"
			],
			[
				'substring-after(@foo,"/")',
				"substr(strstr(\$node->getAttribute('foo'),'/'),1)",
				"\$this->xpath->evaluate('substring-after(@foo,\"/\")',\$node)"
			],
			[
				'substring-after(@foo,"&amp;")',
				"substr(strstr(\$node->getAttribute('foo'),'&amp;'),5)",
				"\$this->xpath->evaluate('substring-after(@foo,\"&amp;\")',\$node)"
			],
			[
				'substring-before(@foo,"/")',
				"strstr(\$node->getAttribute('foo'),'/',true)",
				"\$this->xpath->evaluate('substring-before(@foo,\"/\")',\$node)"
			],
			[
				'substring-before(@foo,@bar)',
				"strstr(\$node->getAttribute('foo'),\$node->getAttribute('bar'),true)"
			],
			// Math
			[
				'@foo + 12',
				"\$node->getAttribute('foo')+12",
				"\$this->xpath->evaluate('string(@foo + 12)',\$node)"
			],
			[
				'44 + $bar',
				"44+\$this->params['bar']",
				"\$this->xpath->evaluate('string(44 + '.\$this->getParamAsXPath('bar').')',\$node)"
			],
			[
				'@h * 3600 + @m * 60 + @s',
				"\$node->getAttribute('h')*3600+\$node->getAttribute('m')*60+\$node->getAttribute('s')",
				"\$this->xpath->evaluate('string(@h * 3600 + @m * 60 + @s)',\$node)"
			],
			[
				'@x div@y',
				"\$node->getAttribute('x')/\$node->getAttribute('y')",
				"\$this->xpath->evaluate('string(@x div@y)',\$node)"
			],
			[
				'(@height + 49)',
				"(\$node->getAttribute('height')+49)",
				"\$this->xpath->evaluate('string((@height + 49))',\$node)"
			],
			[
				'100 * (@height + 49) div @width',
				"100*(\$node->getAttribute('height')+49)/\$node->getAttribute('width')",
				"\$this->xpath->evaluate('string(100 * (@height + 49) div @width)',\$node)"
			],
		];
	}

	public function getConvertXPathTestsMbstring()
	{
		return [
			[
				'substring(.,1,2)',
				"mb_substr(\$node->textContent,0,2,'utf-8')"
			],
//			[
//				'substring(.,@x,1)',
//				"mb_substr(\$node->textContent,max(0,\$node->getAttribute('x')-1),1,'utf-8')"
//			],
//			[
//				'substring(.,1,@x)',
//				"mb_substr(\$node->textContent,0,max(0,\$node->getAttribute('x')),'utf-8')"
//			],
			[
				'substring(.,2)',
				"mb_substr(\$node->textContent,1,null,'utf-8')"
			],
		];
	}

	public function getConvertConditionTestsBasic()
	{
		return [
			[
				'@foo',
				"\$node->hasAttribute('foo')"
			],
			[
				'not(@foo)',
				"!\$node->hasAttribute('foo')"
			],
			[
				'$foo',
				"\$this->params['foo']!==''"
			],
			[
				'not($foo)',
				"\$this->params['foo']===''"
			],
			[
				'@width > 0',
				"\$node->getAttribute('width')>0"
			],
			[
				'@*',
				'$node->attributes->length'
			],
		];
	}

	public function getConvertConditionTestsAdvanced()
	{
		return [
			[
				".='foo'",
				"\$node->textContent=='foo'"
			],
			[
				"@foo='foo'",
				"\$node->getAttribute('foo')=='foo'"
			],
			[
				".='fo\"o'",
				"\$node->textContent=='fo\"o'"
			],
			[
				'.=\'"_"\'',
				'$node->textContent==\'"_"\''
			],
			[
				".='foo'or.='bar'",
				"\$node->textContent=='foo'||\$node->textContent=='bar'"
			],
			[
				'.=3',
				"\$node->textContent==3"
			],
			[
				'.=0',
				"\$node->textContent==0"
			],
			[
				'.=022',
				"\$node->textContent==22"
			],
			[
				'044=.',
				"44==\$node->textContent"
			],
			[
				'@foo != @bar',
				"\$node->getAttribute('foo')!=\$node->getAttribute('bar')"
			],
			[
				'@foo = @bar or @baz',
				"\$node->getAttribute('foo')==\$node->getAttribute('bar')||\$node->hasAttribute('baz')"
			],
			[
				'not(@foo) and @bar',
				"!\$node->hasAttribute('foo')&&\$node->hasAttribute('bar')"
			],
			[
				'not(@foo and @bar)',
				"!(\$node->hasAttribute('foo')&&\$node->hasAttribute('bar'))"
			],
			[
				".='x'or.='y'or.='z'",
				"\$node->textContent=='x'||\$node->textContent=='y'||\$node->textContent=='z'"
			],
			[
				"@x and @y and @z and @a",
				"\$node->hasAttribute('x')&&\$node->hasAttribute('y')&&\$node->hasAttribute('z')&&\$node->hasAttribute('a')"
			],
			[
				"@type='gifv' and @width and @height and @height != 0",
				"\$node->getAttribute('type')=='gifv'&&\$node->hasAttribute('width')&&\$node->hasAttribute('height')&&\$node->getAttribute('height')!=0"
			],
			[
				"contains(@foo,'x')",
				"(strpos(\$node->getAttribute('foo'),'x')!==false)"
			],
			[
				" contains( @foo , 'x' ) ",
				"(strpos(\$node->getAttribute('foo'),'x')!==false)"
			],
			[
				"not(contains(@id, 'bar'))",
				"(strpos(\$node->getAttribute('id'),'bar')===false)"
			],
			[
				"starts-with(@foo,'bar')",
				"(strpos(\$node->getAttribute('foo'),'bar')===0)"
			],
			[
				'@foo and (@bar or @baz)',
				"\$node->hasAttribute('foo')&&(\$node->hasAttribute('bar')||\$node->hasAttribute('baz'))"
			],
			[
				'(@a = @b) or (@b = @c)',
				"(\$node->getAttribute('a')==\$node->getAttribute('b'))||(\$node->getAttribute('b')==\$node->getAttribute('c'))"
			],
			[
				'ancestor::foo',
				"\$this->xpath->evaluate('boolean(ancestor::foo)',\$node)"
			],
			[
				"starts-with(@type,'decimal-') or starts-with(@type,'lower-') or starts-with(@type,'upper-')",
				"(strpos(\$node->getAttribute('type'),'decimal-')===0)||(strpos(\$node->getAttribute('type'),'lower-')===0)||(strpos(\$node->getAttribute('type'),'upper-')===0)"
			],
			[
				'@tld="es" and $AMAZON_ASSOCIATE_TAG_ES',
				"\$node->getAttribute('tld')=='es'&&\$this->params['AMAZON_ASSOCIATE_TAG_ES']!==''"
			],
			[
				'@tld="es"and$AMAZON_ASSOCIATE_TAG_ES',
				"\$node->getAttribute('tld')=='es'&&\$this->params['AMAZON_ASSOCIATE_TAG_ES']!==''"
			],
		];
	}
}