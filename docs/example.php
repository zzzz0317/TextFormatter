<?php

include __DIR__ . '/../src/s9e/TextFormatter/autoloader.php';

$configurator = new s9e\TextFormatter\Configurator;

// Add some BBCodes from the default repository that you can find in
// ../src/s9e/TextFormatter/Plugins/BBCodes/Configurator/repository.xml
$configurator->BBCodes->addFromRepository('B');
$configurator->BBCodes->addFromRepository('I');
$configurator->BBCodes->addFromRepository('U');
$configurator->BBCodes->addFromRepository('S');
$configurator->BBCodes->addFromRepository('COLOR');
$configurator->BBCodes->addFromRepository('URL');
$configurator->BBCodes->addFromRepository('EMAIL');
$configurator->BBCodes->addFromRepository('CODE');
$configurator->BBCodes->addFromRepository('QUOTE');
$configurator->BBCodes->addFromRepository('LIST');
$configurator->BBCodes->addFromRepository('*');
$configurator->BBCodes->addFromRepository('SPOILER');

// Add custom [size] BBCode which forces values to be between 8px and 36px
$configurator->BBCodes->addCustom(
	'[size={RANGE=8,36}]{TEXT}[/size]',
	'<span style="font-size:{RANGE}px">{TEXT}</span>'
);

// NOTE: trying to add unsafe BBCodes results in an UnsafeTemplateException being thrown
//$configurator->BBCodes->addCustom('[BAD={TEXT1}]{TEXT2}[/BAD]', '<a href="{TEXT1}">{TEXT2}</a>');
//$configurator->BBCodes->addCustom('[BAD={TEXT1}]{TEXT2}[/BAD]', '<b onblur="{TEXT1}">{TEXT2}</b>');
//$configurator->BBCodes->addCustom('[BAD={TEXT1}]{TEXT2}[/BAD]', '<b style="{TEXT1}">{TEXT2}</b>');
//$configurator->BBCodes->addCustom('[BAD]{TEXT}[/BAD]',          '<script>{TEXT}"</script>');
//$configurator->BBCodes->addCustom('[BAD]{TEXT}[/BAD]',          '<style>{TEXT}"</script>');

// Add a couple of censored words, one with a custom replacement
$configurator->Censor->add('apple*');
$configurator->Censor->add('bananas', 'oranges');

// Add a couple of emoticons. Normally you would use an <img> tag, but here we'll use HTML entities
// instead
$configurator->Emoticons->add(':)', '&#x263A;');
$configurator->Emoticons->add(':(', '&#x263B;');

// We'll also allow a bit of HTML. Specifically, <a> elements with a non-optional href attribute and
// HTML entities
$configurator->HTMLElements->allowElement('a');
$configurator->HTMLElements->allowAttribute('a', 'href')->required = true;

// Automatically linkify URLs in plain text with the Autolink plugin
$configurator->Autolink;

// Finally, instead of having to explicitly define what tag is allowed where and how, we'll let the
// configurator define a bunch of rules based on HTML5
$configurator->addHTML5Rules();

// ...or uncomment the following for a look at what rules would be created
/**
print_r(s9e\TextFormatter\Configurator\Helpers\HTML5\RulesGenerator::getRules(
	$configurator->tags,
	array('renderer' => $configurator->getRenderer())
));
/**/

//==============================================================================

// Done with configuration, now we create a parser and its renderer
$parser   = $configurator->getParser();
$renderer = $configurator->getRenderer();

// The parser and renderer should be cached somewhere so we don't have recreate them every time
//file_put_contents('/tmp/parser.txt',   serialize($parser));
//file_put_contents('/tmp/renderer.txt', serialize($renderer));

// Parse a simple message then render it as HTML. The XML result is what you save in your database
// while the HTML rendering is what you show to the users
$text = "Hello, [i]world[/i] :)\nFind more examples in the [url=https://github.com/s9e/TextFormatter/tree/master/docs/Cookbook]Cookbook[/url].";
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html, "\n";
