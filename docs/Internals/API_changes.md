## 2.0.0 (not released)

The `parseEqualityExpr()` method will be moved from `s9e\TextFormatter\Configurator\Helpers\TemplateParser` to `s9e\TextFormatter\Configurator\Helpers\XPathHelper`.


## 1.0.0

The following method and properties have been removed from `s9e\TextFormatter\Plugins\MediaEmbed\Configurator`:

 - `appendTemplate()` — The [same functionality](../Plugins/MediaEmbed/Append_template.md) can be implemented as a template normalizer.
 - `$captureURLs` — Disabling the plugin at runtime produces the same effect.
 - `$createIndividualBBCodes` — Individual BBCodes can be [created manually](../Plugins/MediaEmbed/Synopsis.md#example).

In addition, support for custom schemes has been removed from the MediaEmbed plugin. The [same functionality](../Plugins/Preg/Practical_examples.md#capture-spotify-uris) can be produced using the Preg plugin.

The `predefinedAttributes` property of `s9e\TextFormatter\Plugins\BBCodes\Configurator\BBCode` has been removed, as well as the `s9e\TextFormatter\Plugins\BBCodes\Configurator\AttributeValueCollection` class.

The return value of tag filters is not used to invalidate tags anymore. Tags must be explicitly invalidated in tag filters.

Support for attribute generators and the `{RANDOM}` token in BBCode definitions has been removed. The same behaviour can be defined in PHP by prepending a custom tag filter to a tag's `filterChain`.

The `s9e\TextFormatter\Configurator\Exceptions\InvalidTemplateException` and `s9e\TextFormatter\Configurator\Exceptions\InvalidXslException` classes have been removed.


## 0.13.0

`s9e\TextFormatter\Parser\BuiltInFilters` has been removed and split into multiple classes.

`s9e\TextFormatter\Parser\Logger::get()` has been renamed `s9e\TextFormatter\Parser\Logger::getLogs()`.


## 0.12.0

Support for PHP 5.3 has been abandoned. Releases are now based on the `release/php5.4` branch, which requires PHP 5.4.7 or greater. The `release/php5.3` branch will remain active for some time but is unsupported.

The PHP renderer's source has been removed from the renderer instance.

The `HostedMinifier` and `RemoteCache` minifiers have been removed.

`s9e\TextFormatter\Configurator\Helpers\TemplateHelper::getMetaElementsRegexp()` has been removed.

`s9e\TextFormatter\Configurator\Helpers\TemplateInspector::getDOM()` has been removed.

The `metaElementsRegexp` property of `s9e\TextFormatter\Renderer` has been removed. Meta elements `e`, `i` and `s` are now always removed from the source XML before rendering.

The `quickRenderingTest` property of the PHP renderer is now protected.

`s9e\TextFormatter\Configurator\Helpers\XPathHelper::export()` has been moved to `s9e\TextFormatter\Utils\XPath::export()`.

`s9e\TextFormatter\Configurator\TemplateNormalization` has been replaced by `s9e\TextFormatter\Configurator\TemplateNormalizations\AbstractNormalization`.

The `branchTableThreshold` property of `s9e\TextFormatter\Configurator\RendererGenerators\PHP\Serializer` has been removed.

The `generateConditionals()` and `generateBranchTable()` methods of `s9e\TextFormatter\Configurator\RendererGenerators\PHP\Quick` have been removed.

The template used by the Emoji plugin is now hardcoded and defaults to using EmojiOne 3.1's PNG assets. The following methods have been removed from the Emoji configurator:

 * `forceImageSize()`
 * `omitImageSize()`
 * `setImageSize()`
 * `useEmojiOne()`
 * `usePNG()`
 * `useSVG()`
 * `useTwemoji()`


## 0.11.0

The optional argument of `s9e\TextFormatter\Configurator\RulesGenerator::getRules()` has been removed.

The optional argument of `s9e\TextFormatter\Configurator::finalize()` has been removed.

The following methods have been removed:

 * `s9e\TextFormatter\Configurator::addHTML5Rules()`  
   Tag rules are systematically added during `finalize()`. See [Automatic rules generation](../Rules/Automatic_rules_generation.md).

 * `s9e\TextFormatter\Configurator\Collections\Ruleset::defaultChildRule()`  
   The default is now `deny`.

 * `s9e\TextFormatter\Configurator\Collections\Ruleset::defaultDescendantRule()`  
   The default is now `deny`.

 * `s9e\TextFormatter\Configurator\Helpers\TemplateInspector::isIframe()`

In addition, the meaning of the `allowDescendant` and `denyDescendant` rules have been changed to exclude the tag's child. See [Tag rules](../Rules/Tag_rules.md).


## 0.10.0

`s9e\TextFormatter\Plugins\Censor\Helper::reparse()` has been removed.

`s9e\TextFormatter\Parser\Tag::setSortPriority()` has been removed. See the [0.7.0 notes](#070) for more info.


## 0.9.0

`s9e\TextFormatter\Configurator\TemplateForensics` has been renamed to `s9e\TextFormatter\Configurator\TemplateInspector`.

`s9e\TextFormatter\Configurator\Items\Template::getForensics()` has been renamed to `s9e\TextFormatter\Configurator\Items\Template::getInspector()`.


## 0.8.0

The `s9e\TextFormatter\Plugins\MediaEmbed\Configurator\SiteDefinitionProvider` interface has been removed.

`$configurator->MediaEmbed->defaultSites` is now an iterable collection that implements the `ArrayAccess` interface. See [its API](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Plugins/MediaEmbed/Configurator/Collections/SiteDefinitionCollection.html).


## 0.7.0

`s9e\TextFormatter\Parser\Tag::setSortPriority()` has been deprecated. It will emit a warning upon use and will be removed in a future version.

The following methods now accept an additional argument to set a tag's priority at the time of its creation:

 * [addBrTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addBrTag)
 * [addCopyTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addCopyTag)
 * [addEndTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addEndTag)
 * [addIgnoreTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addIgnoreTag)
 * [addParagraphBreak](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addParagraphBreak)
 * [addSelfClosingTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addSelfClosingTag)
 * [addStartTag](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addStartTag)
 * [addTagPair](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addTagPair)
 * [addVerbatim](https://s9e.github.io/TextFormatter/api/s9e/TextFormatter/Parser.html#method_addVerbatim)