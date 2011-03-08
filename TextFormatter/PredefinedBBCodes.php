<?php

/**
* @package   s9e\Toolkit
* @copyright Copyright (c) 2010 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\Toolkit\TextFormatter;

/**
* This class attempts to hold the definitions of the most commonly requested BBCodes.
* It is partially based on user requests found in forum software-oriented websites.
*
* @link http://www.phpbb.com/kb/article/adding-custom-bbcodes-in-phpbb3/
*/
class PredefinedBBCodes
{
	public function __construct(ConfigBuilder $cb)
	{
		$this->cb = $cb;
	}

	public function addB()
	{
		$this->cb->addBBCodeFromExample('[B]{TEXT}[/B]', '<strong>{TEXT}</strong>');
	}

	public function addI()
	{
		$this->cb->addBBCodeFromExample('[I]{TEXT}[/I]', '<em>{TEXT}</em>');
	}

	public function addU()
	{
		$this->cb->addBBCodeFromExample(
			'[U]{TEXT}[/U]',
			'<span style="text-decoration:underline">{TEXT}</span>'
		);
	}

	public function addS()
	{
		$this->cb->addBBCodeFromExample(
			'[S]{TEXT}[/S]',
			'<span style="text-decoration:line-through">{TEXT}</span>'
		);
	}

	/**
	* Polymorphic URL tag with optional support for the "title" attribute
	*
	* [URL]http://www.example.org[/URL]
	* [URL=http://www.example.org]example.org[/URL]
	* [URL title="The best site ever"]http://www.example.org[/URL]
	*/
	public function addURL()
	{
		$this->cb->addBBCode('URL', array(
			'default_param'    => 'url',
			'content_as_param' => true
		));

		$this->cb->addBBCodeParam('URL', 'url', 'url');
		$this->cb->addBBCodeParam('URL', 'title', 'text', array('is_required' => false));

		$this->cb->setBBCodeTemplate(
			'URL',
			'<a href="{@url}"><xsl:if test="@title"><xsl:attribute name="title"><xsl:value-of select="@title"/></xsl:attribute></xsl:if><xsl:apply-templates/></a>'
		);
	}

	/**
	* Polymorphic IMG tag with optional support for "title" and "alt"
	*
	* Note that no attempt is made to verify that the image's source is actually an image.
	*
	* [IMG]http://www.example.org/img.png[/IMG]
	*/
	public function addIMG()
	{
		$this->cb->addBBCode('IMG', array(
			'default_param'    => 'src',
			'content_as_param' => true,
			'auto_close'       => true,
			'default_rule'     => 'deny'
		));

		$this->cb->addBBCodeParam('IMG', 'src', 'url');
		$this->cb->addBBCodeParam('IMG', 'alt', 'text', array('is_required' => false));
		$this->cb->addBBCodeParam('IMG', 'title', 'text', array('is_required' => false));

		$this->cb->setBBCodeTemplate(
			'IMG',
			'<img src="{@src}"><xsl:if test="@alt"><xsl:attribute name="alt"><xsl:value-of select="@alt"/></xsl:attribute></xsl:if><xsl:if test="@title"><xsl:attribute name="title"><xsl:value-of select="@title"/></xsl:attribute></xsl:if></img>'
		);
	}

	public function addLIST()
	{
		$styles = array(
			'1',
			'01',
			'a',
			'i',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#list-content
			*/
			'normal', 'none',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#glyphs
			*/
			'box', 'check', 'circle', 'diamond', 'disc', 'hyphen', 'square',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#algorithmic
			*/
			'armenian', 'cjk-ideographic', 'ethiopic-numeric', 'georgian', 'hebrew', 'japanese-formal', 'japanese-informal', 'lower-armenian', 'lower-roman', 'simp-chinese-formal', 'simp-chinese-informal', 'syriac', 'tamil', 'trad-chinese-formal', 'trad-chinese-informal', 'upper-armenian', 'upper-roman',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#algorithmic
			*/
			'arabic-indic', 'binary', 'bengali', 'cambodian', 'decimal', 'decimal-leading-zero', 'devanagari', 'gujarati', 'gurmukhi', 'kannada', 'khmer', 'lao', 'lower-hexadecimal', 'malayalam', 'mongolian', 'myanmar', 'octal', 'oriya', 'persian', 'telugu', 'tibetan', 'thai', 'upper-hexadecimal', 'urdu',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#alphabetic
			*/
			'afar', 'amharic', 'amharic-abegede', 'cjk-earthly-branch', 'cjk-heavenly-stem', 'ethiopic', 'ethiopic-abegede', 'ethiopic-abegede-am-et', 'ethiopic-abegede-gez', 'ethiopic-abegede-ti-er', 'ethiopic-abegede-ti-et', 'ethiopic-halehame-aa-er', 'ethiopic-halehame-aa-et', 'ethiopic-halehame-am-et', 'ethiopic-halehame-gez', 'ethiopic-halehame-om-et', 'ethiopic-halehame-sid-et', 'ethiopic-halehame-so-et', 'ethiopic-halehame-ti-er', 'ethiopic-halehame-ti-et', 'ethiopic-halehame-tig', 'hangul', 'hangul-consonant', 'hiragana', 'hiragana-iroha', 'katakana', 'katakana-iroha', 'lower-alpha', 'lower-greek', 'lower-norwegian', 'lower-latin', 'oromo', 'sidama', 'somali', 'tigre', 'tigrinya-er', 'tigrinya-er-abegede', 'tigrinya-et', 'tigrinya-et-abegede', 'upper-alpha', 'upper-greek', 'upper-norwegian', 'upper-latin',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#symbolic
			*/
			'asterisks', 'footnotes',
			/**
			* @see http://www.w3.org/TR/2002/WD-css3-lists-20021107/#non-repeating
			*/
			'circled-decimal', 'circled-lower-latin', 'circled-upper-latin', 'dotted-decimal', 'double-circled-decimal', 'filled-circled-decimal', 'parenthesised-decimal', 'parenthesised-lower-latin'
		);

		// [LIST]
		$this->cb->addBBCode('LIST', array(
			'default_param' => 'style',
			'trim_before'   => true,
			'trim_after'    => true,
			'ltrim_content' => true,
			'rtrim_content' => true
		));

		$this->cb->addBBCodeParam('LIST', 'start', 'uint', array('is_required' => false));

		$this->cb->addBBCodeParam('LIST', 'style', 'regexp', array(
			'default' => 'disc',
			'is_required' => false,
			'regexp' => '/^' . ConfigBuilder::buildRegexpFromList($styles) . '$/iD'
		));

		$this->cb->setBBCodeTemplate(
			'LIST',
			'<ol>
				<xsl:attribute name="style">list-style-type:<xsl:choose>
					<xsl:when test="@style=\'1\'">decimal</xsl:when>
					<xsl:when test="@style=\'01\'">decimal-leading-zero</xsl:when>
					<xsl:when test="@style=\'a\'">lower-alpha</xsl:when>
					<xsl:when test="@style=\'A\'">upper-alpha</xsl:when>
					<xsl:when test="@style=\'i\'">lower-roman</xsl:when>
					<xsl:when test="@style=\'I\'">upper-roman</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="@style"/>
					</xsl:otherwise>
				</xsl:choose></xsl:attribute>

				<xsl:if test="@start">
					<xsl:attribute name="start">
						<xsl:value-of select="@start"/>
					</xsl:attribute>
				</xsl:if>

				<xsl:apply-templates/>
			</ol>'
		);

		// [LI]
		$this->cb->addBBCode('LI', array(
			'trim_before'   => true,
			'trim_after'    => true,
			'ltrim_content' => true,
			'rtrim_content' => true
		));

		// create an alias so that [*] be interpreted as [LI]
		$this->cb->addBBCodeAlias('LI', '*');

		// [*] should only be used directly under [LIST]
		$this->cb->addBBCodeRule('LI', 'require_parent', 'list');

		// also, let's make so that when we have two consecutive [*] we close
		// the first one when opening the second, instead of it behind its child
		$this->cb->addBBCodeRule('LI', 'close_parent', 'LI');

		$this->cb->setBBCodeTemplate('LI', '<li><xsl:apply-templates/></li>');
	}

	/**
	* Accepts both URLs and identifiers:
	*
	* [GOOGLEVIDEO]-4381488634998231167[/GOOGLEVIDEO]
	* [GOOGLEVIDEO]http://video.google.com/videoplay?docid=-4381488634998231167[/GOOGLEVIDEO]
	*/
	public function addGOOGLEVIDEO()
	{
		$regexp =
			'/^(?:' . preg_quote('http://video.google.com/videoplay?docid=', '/') . ')?(-?\\d+)/';

		$this->cb->addBBCodeFromExample(
			'[googlevideo]{REGEXP=' . $regexp . ';REPLACE=$1}[/googlevideo]',
			'<object type="application/x-shockwave-flash" data="http://video.google.com/googleplayer.swf?docId={REGEXP}" width="400" height="326">
				<param name="movie" value="http://video.google.com/googleplayer.swf?docId={REGEXP}"/>
				<param name="allowScriptAcess" value="sameDomain"/>
				<param name="quality" value="best"/>
				<param name="scale" value="noScale"/>
				<param name="salign" value="TL"/>
				<param name="FlashVars" value="playerMode=embedded"/>
			</object>'
		);
	}

	/**
	* Accepts both URLs and identifiers:
	*
	* [YOUTUBE]-cEzsCAzTak[/YOUTUBE]
	* [YOUTUBE]http://www.youtube.com/watch?v=-cEzsCAzTak&feature=channel[/YOUTUBE]
	*/
	public function addYOUTUBE()
	{
		$this->cb->addBBCodeFromExample(
			'[youtube]{REGEXP=/^(?:http:\\/\\/[a-z]+\\.youtube\\.com\\/watch\\?v=)?([A-Za-z_0-9\\-]+)(&.*)?$/;REPLACE=$1}[/youtube]',
			'<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/{REGEXP}" width="425" height="350"><param name="movie" value="http://www.youtube.com/v/{REGEXP}" /><param name="wmode" value="transparent"/></object>'
		);
	}

	public function addALIGN()
	{
		$this->cb->addBBCodeFromExample(
			'[align={CHOICE=left,right,center,justify}]{TEXT}[/align]',
			'<div style="text-align:{CHOICE}">{TEXT}</div>'
		);
	}

	public function addLEFT()
	{
		$this->cb->addBBCodeFromExample(
			'[left]{TEXT}[/left]',
			'<div style="text-align:left">{TEXT}</div>'
		);
	}

	public function addRIGHT()
	{
		$this->cb->addBBCodeFromExample(
			'[right]{TEXT}[/right]',
			'<div style="text-align:right">{TEXT}</div>'
		);
	}

	public function addCENTER()
	{
		$this->cb->addBBCodeFromExample(
			'[center]{TEXT}[/center]',
			'<div style="text-align:center">{TEXT}</div>'
		);
	}

	public function addJUSTIFY()
	{
		$this->cb->addBBCodeFromExample(
			'[justify]{TEXT}[/justify]',
			'<div style="text-align:justify">{TEXT}</div>'
		);
	}

	public function addBACKGROUND()
	{
		$this->cb->addBBCodeFromExample(
			'[background={COLOR}]{TEXT}[/background]',
			'<span style="background-color:{COLOR}">{TEXT}</span>'
		);
	}

	public function addFONT()
	{
		$this->cb->addBBCodeFromExample(
			'[font={SIMPLETEXT}]{TEXT}[/font]',
			'<span style="font-family:{SIMPLETEXT}">{TEXT}</span>'
		);
	}

	public function addBLINK()
	{
		$this->cb->addBBCodeFromExample(
			'[blink]{TEXT}[/blink]',
			'<span style="text-decoration:blink">{TEXT}</span>'
		);
	}

	public function addSUB()
	{
		$this->cb->addBBCodeFromExample(
			'[sub]{TEXT}[/sub]',
			'<span style="vertical-align:sub">{TEXT}</span>'
		);
	}

	public function addSUPER()
	{
		$this->cb->addBBCodeFromExample(
			'[super]{TEXT}[/super]',
			'<span style="vertical-align:super">{TEXT}</span>'
		);
	}

	/**
	* Basic [TABLE], [TR], [TH] and [TD] tags.
	* [TD] accepts two optional arguments: colspan and rowspan.
	*
	* Misplaced text, e.g. [TR]xxx[TD][/TD][/TR], is parsed normally but doesn't appear in the
	* HTML ouput.
	*/
	public function addTABLE()
	{
		// limit table nesting to 2, which should be enough for everybody
		$this->cb->addBBCode('TABLE', array('nesting_limit' => 2));
		$this->cb->setBBCodeTemplate(
			'TABLE',
			'<table>
				<xsl:apply-templates select="COL" />
				<xsl:apply-templates select="TR" />
			</table>'
		);

		$this->cb->addBBCode('COL', array(
			'default_rule' => 'deny',
			'auto_close'   => true
		));
		$this->cb->addBBCodeRule('COL', 'require_parent', 'TABLE');
		$this->cb->addBBCodeParam('COL', 'align', 'regexp', array(
			'is_required' => false,
			'regexp'      => '/^(?:left|right|center|align)$/iD'
		));
		$this->cb->setBBCodeTemplate(
			'COL',
			'<col>
				<xsl:if test="@align">
					<xsl:attribute name="style">text-align:<xsl:value-of select="@align" /></xsl:attribute>
				</xsl:if>
			</col>'
		);

		$this->cb->addBBCode('TR');
		$this->cb->addBBCodeRule('TR', 'require_parent', 'TABLE');
		$this->cb->setBBCodeTemplate(
			'TR',
			'<tr>
				<xsl:apply-templates select="TD | TH" />
			</tr>'
		);

		$this->cb->addBBCode('TH');
		$this->cb->addBBCodeRule('TH', 'require_parent', 'TR');
		$this->cb->addBBCodeParam('TH', 'colspan', 'uint', array('is_required' => false));
		$this->cb->addBBCodeParam('TH', 'rowspan', 'uint', array('is_required' => false));
		$this->cb->setBBCodeTemplate(
			'TH',
			'<th>
				<xsl:if test="@colspan">
					<xsl:attribute name="colspan">
						<xsl:value-of select="@colspan" />
					</xsl:attribute>
				</xsl:if>

				<xsl:if test="@rowspan">
					<xsl:attribute name="rowspan">
						<xsl:value-of select="@rowspan" />
					</xsl:attribute>
				</xsl:if>

				<xsl:apply-templates />
			</th>'
		);

		$this->cb->addBBCode('TD');
		$this->cb->addBBCodeRule('TD', 'require_parent', 'TR');
		$this->cb->addBBCodeParam('TD', 'colspan', 'uint', array('is_required' => false));
		$this->cb->addBBCodeParam('TD', 'rowspan', 'uint', array('is_required' => false));
		$this->cb->setBBCodeTemplate(
			'TD',
			'<td>
				<xsl:if test="@colspan">
					<xsl:attribute name="colspan">
						<xsl:value-of select="@colspan" />
					</xsl:attribute>
				</xsl:if>

				<xsl:if test="@rowspan">
					<xsl:attribute name="rowspan">
						<xsl:value-of select="@rowspan" />
					</xsl:attribute>
				</xsl:if>

				<xsl:apply-templates />
			</td>'
		);
	}

	/**
	* A simple implementation of a [CODE] tag
	*
	* It has one default, optional parameter "stx" and it's designed to work with Alex Gorbatchev's
	* SyntaxHighlighter library. See getCODEstx() for an example of how to retrieve the list of
	* syntaxes used so that you can load the appropriate brushes.
	*
	* @see  getCODEstx
	* @link http://alexgorbatchev.com/SyntaxHighlighter/
	*/
	public function addCODE()
	{
		$this->cb->addBBCode('CODE', array(
			'default_rule'  => 'deny',
			'default_param' => 'stx'
		));

		$this->cb->addBBCodeParam('CODE', 'stx', 'identifier', array(
			'is_required' => false,
			'pre_filter'  => array('strtolower')
		));

		$this->cb->setBBCodeTemplate(
			'CODE',
			'<pre class="brush:{@stx}"><xsl:value-of select="text()" /></pre>'
		);
	}

	static public function getCODEstx($xml)
	{
		// array_values() will reset the keys so that there's no gap in numbering, just in case
		return array_values(array_unique(
			array_map(
				'strval',
				simplexml_load_string($xml)->xpath('//CODE/@stx')
			)
		));
	}

	public function addHR()
	{
		$this->cb->addBBCode('HR', array(
			'default_rule' => 'deny',
			'auto_close'   => true,
			'trim_before'  => true,
			'trim_after'   => true
		));

		$this->cb->setBBCodeTemplate('HR', '<hr/>');
	}

	/**
	* Classic [QUOTE] tag
	*
	* The author can be specified in the default param.
	* You can limit the nesting level (which is set to 3 by default) and you can localize the author
	* string.
	* The markup used is intentionally compatible with phpBB themes.
	*
	* @param integer $nestingLevel
	* @param string  $authorStr
	*/
	public function addQUOTE($nestingLevel = 3, $authorStr = '%s wrote:')
	{
		$this->cb->addBBCode('QUOTE', array(
			'nesting_limit' => $nestingLevel,
			'default_param' => 'author',
			'trim_before'   => true,
			'trim_after'    => true,
			'ltrim_content' => true,
			'rtrim_content' => true
		));

		$authorXml = str_replace(
			'%s',
			'<xsl:value-of select="@author" />',
			htmlspecialchars($authorStr)
		);

		$this->cb->addBBCodeParam('QUOTE', 'author', 'text', array('is_required' => false));
		$this->cb->setBBCodeTemplate(
			'QUOTE',
			'<xsl:choose>
				<xsl:when test="@author">

					<blockquote>
						<div>
							<cite>' . $authorXml . '</cite>
							<xsl:apply-templates />
						</div>
					</blockquote>

				</xsl:when>
				<xsl:otherwise>

					<blockquote class="uncited">
						<div>
							<xsl:apply-templates />
						</div>
					</blockquote>

				</xsl:otherwise>
			</xsl:choose>'
		);
	}

	/**
	* Basic [EMAIL] tag with an optional "subject" parameter
	*
	* The email address will be published in clear for all spambots to harvest, so you may want
	* to write your own solution instead.
	*/
	public function addEMAIL()
	{
		$this->cb->addBBCode('EMAIL', array(
			'default_param'    => 'email',
			'content_as_param' => true,
			'default_rule'     => 'deny'
		));

		$this->cb->addBBCodeParam('EMAIL', 'email', 'email', array(
			// this will encode the @ into %40, possibly messing up with the lamest of spambots
			'post_filter' => array('rawurlencode')
		));

		$this->cb->addBBCodeParam('EMAIL', 'subject', 'text', array(
			'is_required' => false,
			'post_filter' => array('rawurlencode')
		));

		$this->cb->setBBCodeTemplate(
			'EMAIL',
			'<a>
				<xsl:attribute name="href">mailto:<xsl:value-of select="@email" /><xsl:if test="@subject">?subject=<xsl:value-of select="@subject" /></xsl:if></xsl:attribute>
				<xsl:apply-templates />
			</a>'
		);
	}

	/**
	* Accepts both URLs and identifiers:
	*
	* [JUSTIN]justin[/JUSTIN]
	* [JUSTIN]http://www.justin.tv/justin[/JUSTIN]
	*/
	public function addJUSTIN()
	{
		$regexp = '/^(?:http:\\/\\/www\\.justin\\.tv\\/)?([A-Za-z_0-9]+)/';

		$this->cb->addBBCodeFromExample(
			'[JUSTIN]{REGEXP=' . $regexp . ';REPLACE=$1}[/JUSTIN]',
			'<object type="application/x-shockwave-flash" height="300" width="400"  data="http://www.justin.tv/widgets/live_embed_player.swf?channel={REGEXP}" bgcolor="#000000">
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="always" />
				<param name="allowNetworking" value="all" />
				<param name="movie" value="http://www.justin.tv/widgets/live_embed_player.swf" />
				<param name="flashvars" value="channel={REGEXP}&amp;auto_play=false" />
			</object>'
		);
	}

	/**
	* Display a date using browser's locale via Javascript
	*
	* e.g. [LOCALTIME]2005/09/17 12:55:09 PST[/LOCALTIME]
	*
	* The date is parsed in PHP with strtotime(), which is used as a pre-filter, then it is
	* validated as a number. strtotime() returns false on invalid date, so it invalid dates will be
	* automatically rejected.
	*
	* Using user-supplied data in <script> tags is disallowed by ConfigBuilder by default, and the
	* limitation has to be removed by using the third parameter. The template should still be
	* secure, though, as only numbers are allowed and it should be impossible to inject any
	* Javascript using the [LOCALTIME] BBCode.
	*
	* Finally, if Javascript is disabled, the original content is displayed via a <noscript> tag.
	*
	* Note the use of <xsl:apply-templates/> instead of the {NUMBER} placeholder. This is because
	* {NUMBER} will display the value returned by strtotime() whereas <xsl:apply-templates/> will
	* display the UNFILTERED value.
	*/
	public function addLOCALTIME()
	{
		$this->cb->addBBCodeFromExample(
			'[LOCALTIME]{NUMBER;PRE_FILTER=strtotime}[/LOCALTIME]',
			'<span class="localtime" title="{text()}">
				<script type="text/javascript">document.write(new Date({NUMBER}*1000).toLocaleString())</script>
				<noscript><xsl:apply-templates /></noscript>
			</span>',
			ConfigBuilder::ALLOW_INSECURE_TEMPLATES
		);
	}

	/**
	* Basic [SPOILER] tag
	*
	* It is unstyled, you have to style it yourself. Each section was given a nice class name for
	* that purpose.
	*
	* Note that because of XSL, curly braces { } inside of attribute values have to be escaped.
	* You can escape them by having two of them, e.g. "if (true) {{ dostuff(); }}"
	*/
	public function addSPOILER($spoilerStr = 'Spoiler:', $showStr = 'Show', $hideStr = 'Hide')
	{
		$this->cb->addBBCodeFromExample(
			'[SPOILER={TEXT1;IS_REQUIRED=0}]{TEXT2}[/SPOILER]',
			'<div class="spoiler">
				<div class="spoiler-header">
					<input type="button" value="' . $showStr . '" onclick="'
						. 'var s=this.parentNode.nextSibling.style;'
						. "if(s.display!=''){{s.display='';this.value='" . $hideStr . "'}}"
						. "else{{s.display='none';this.value='" . $showStr . "'}}"
					. '"/>
					<span class="spoiler-title">' . $spoilerStr . ' {TEXT1}</span>
				</div>
				<div class="spoiler-content" style="display:none">{TEXT2}</div>
			</div>'
		);
	}

	public function addCOLOR()
	{
		$this->cb->addBBCodeFromExample(
			'[COLOR={COLOR}]{TEXT}[/COLOR]',
			'<span style="color:{COLOR}">{TEXT}</span>'
		);
	}
}