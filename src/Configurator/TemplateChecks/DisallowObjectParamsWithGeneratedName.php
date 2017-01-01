<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2017 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\TemplateChecks;

use DOMElement;
use DOMXPath;
use s9e\TextFormatter\Configurator\Exceptions\UnsafeTemplateException;
use s9e\TextFormatter\Configurator\Items\Tag;
use s9e\TextFormatter\Configurator\TemplateCheck;

class DisallowObjectParamsWithGeneratedName extends TemplateCheck
{
	/**
	* Check for <param> elements with a generated "name" attribute
	*
	* This check will reject <param> elements whose "name" attribute is generated by an
	* <xsl:attribute/> element. This is a setup that has no practical use and should be eliminated
	* because it makes it much harder to check the param's name, and therefore infer the type of
	* content it expects
	*
	* @param  DOMElement $template <xsl:template/> node
	* @param  Tag        $tag      Tag this template belongs to
	* @return void
	*/
	public function check(DOMElement $template, Tag $tag)
	{
		$xpath = new DOMXPath($template->ownerDocument);
		$query = '//object//param[contains(@name, "{") or .//xsl:attribute[translate(@name, "NAME", "name") = "name"]]';
		$nodes = $xpath->query($query);

		foreach ($nodes as $node)
		{
			throw new UnsafeTemplateException("A 'param' element with a suspect name has been found", $node);
		}
	}
}