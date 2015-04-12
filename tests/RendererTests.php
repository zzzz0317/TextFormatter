<?php

namespace s9e\TextFormatter\Tests;

use s9e\TextFormatter\Renderer;
use s9e\TextFormatter\Tests\Test;

trait RendererTests
{
	/**
	* @testdox Renders plain text
	*/
	public function testPlainText()
	{
		$xml = '<t>Plain text</t>';

		$this->assertSame(
			'Plain text',
			$this->configurator->getRenderer()->render($xml)
		);
	}

	/**
	* @testdox Renders multi-line text
	*/
	public function testMultiLineTextHTML()
	{
		$xml = '<t>One<br/>two</t>';

		$this->assertSame(
			'One<br>two',
			$this->configurator->getRenderer()->render($xml)
		);
	}

	/**
	* @testdox Renders rich text
	*/
	public function testRichText()
	{
		$xml = '<r>Hello <B><s>[b]</s>world<e>[/b]</e></B>!</r>';

		$this->configurator->tags->add('B')->template = '<b><xsl:apply-templates/></b>';

		$this->assertSame(
			'Hello <b>world</b>!',
			$this->configurator->getRenderer()->render($xml)
		);
	}

	/**
	* @testdox getParameter() returns the default value of a parameter
	*/
	public function testGetParameterDefault()
	{
		$this->configurator->tags->add('X')->template = '<xsl:value-of select="$foo"/>';
		$this->configurator->rendering->parameters->add('foo', 'bar');

		$renderer = $this->configurator->getRenderer();

		$this->assertSame('bar', $renderer->getParameter('foo'));
	}

	/**
	* @testdox getParameter() returns the set value of a parameter
	*/
	public function testGetParameterSet()
	{
		$this->configurator->tags->add('X')->template = '<xsl:value-of select="$foo"/>';
		$this->configurator->rendering->parameters->add('foo', 'bar');

		$renderer = $this->configurator->getRenderer();
		$renderer->setParameter('foo', 'baz');

		$this->assertSame('baz', $renderer->getParameter('foo'));
	}

	/**
	* @testdox getParameter() returns an empty string for undefined parameters
	*/
	public function testGetParameterUndefined()
	{
		$renderer = $this->configurator->getRenderer();

		$this->assertSame('', $renderer->getParameter('foo'));
	}

	/**
	* @testdox getParameters() returns the values of all parameters, defined and set
	*/
	public function testGetParameters()
	{
		$this->configurator->tags->add('X')->template = '<xsl:value-of select="$foo"/>';
		$this->configurator->rendering->parameters->add('bar', 'BAR');

		$renderer = $this->configurator->getRenderer();
		$renderer->setParameter('baz', 'BAZ');

		$this->assertEquals(
			['foo' => '', 'bar' => 'BAR', 'baz' => 'BAZ'],
			$renderer->getParameters()
		);
	}

	/**
	* @testdox setParameter() sets the value of a parameter
	*/
	public function testSetParameter()
	{
		$this->configurator->tags->add('X')->template = '<xsl:value-of select="$foo"/>';
		$this->configurator->rendering->parameters->add('foo');

		$renderer = $this->configurator->getRenderer();
		$renderer->setParameter('foo', 'bar');

		$this->assertSame(
			'bar',
			$renderer->render('<r><X/></r>')
		);
	}

	/**
	* @testdox setParameters() sets the values of any number of parameters in an associative array
	*/
	public function testSetParameters()
	{
		$this->configurator->tags->add('X')->template
			= '<xsl:value-of select="$foo"/><xsl:value-of select="$bar"/>';
		$this->configurator->rendering->parameters->add('foo');
		$this->configurator->rendering->parameters->add('bar');

		$renderer = $this->configurator->getRenderer();
		$renderer->setParameters([
			'foo' => 'FOO',
			'bar' => 'BAR'
		]);

		$this->assertSame(
			'FOOBAR',
			$renderer->render('<r><X/></r>')
		);
	}

	/**
	* @testdox setParameter() accepts values that contain both types of quotes
	*/
	public function testSetParameterBothQuotes()
	{
		$this->configurator->tags->add('X')->template = '<xsl:value-of select="$foo"/>';
		$this->configurator->rendering->parameters->add('foo');
		$renderer = $this->configurator->getRenderer();

		$values = [
			'"\'...\'"',
			'\'\'""...\'\'"\'"'
		];

		foreach ($values as $value)
		{
			$renderer->setParameter('foo', $value);
			$this->assertSame($value, $renderer->render('<r><X/></r>'));
		}
	}

	/**
	* @testdox Custom parameters are properly saved and restored after serialization
	*/
	public function testGetParameterUnserialized()
	{
		$this->configurator->rendering->parameters['x'] = 'y';
		$renderer = $this->configurator->getRenderer();
		$renderer->setParameter('foo', 'xxx');

		$this->assertEquals(
			['foo' => 'xxx', 'x' => 'y'],
			unserialize(serialize($renderer))->getParameters()
		);
	}

	/**
	* @testdox DTDs in the XML representation cause an exception to be thrown
	* @expectedException InvalidArgumentException DTD
	*/
	public function testDTD()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'
		     . '<!DOCTYPE foo [<!ELEMENT r ANY><!ENTITY foo "FOO">]>'
		     . '<r>x&foo;y</r>';

		$this->configurator->getRenderer()->render($xml);
	}

	/**
	* @testdox Is not vulnerable to XXE
	* @expectedException InvalidArgumentException DTD
	*/
	public function testXXE()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'
		     . '<!DOCTYPE foo [<!ELEMENT r ANY><!ENTITY xxe SYSTEM "data:text/plain,Hello">]>'
		     . '<r>x&xxe;y</r>';

		$this->configurator->getRenderer()->render($xml);
	}
}