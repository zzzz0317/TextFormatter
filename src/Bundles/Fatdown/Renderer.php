<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2017 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Bundles\Fatdown;

class Renderer extends \s9e\TextFormatter\Renderer
{
	protected $params=[];
	protected static $tagBranches=['BANDCAMP'=>0,'C'=>1,'html:code'=>1,'CODE'=>2,'DAILYMOTION'=>3,'DEL'=>4,'html:del'=>4,'EM'=>5,'EMAIL'=>6,'ESC'=>7,'FACEBOOK'=>8,'FP'=>9,'HE'=>9,'H1'=>10,'H2'=>11,'H3'=>12,'H4'=>13,'H5'=>14,'H6'=>15,'HC'=>16,'HR'=>17,'IMG'=>18,'LI'=>19,'html:li'=>19,'LIST'=>20,'LIVELEAK'=>21,'QUOTE'=>22,'SOUNDCLOUD'=>23,'SPOTIFY'=>24,'STRONG'=>25,'html:strong'=>25,'SUP'=>26,'html:sup'=>26,'TABLE'=>27,'html:table'=>27,'TBODY'=>28,'html:tbody'=>28,'TD'=>29,'TH'=>30,'THEAD'=>31,'html:thead'=>31,'TR'=>32,'html:tr'=>32,'TWITCH'=>33,'URL'=>34,'VIMEO'=>35,'VINE'=>36,'YOUTUBE'=>37,'br'=>38,'e'=>39,'i'=>39,'s'=>39,'html:abbr'=>40,'html:b'=>41,'html:br'=>42,'html:dd'=>43,'html:div'=>44,'html:dl'=>45,'html:dt'=>46,'html:i'=>47,'html:img'=>48,'html:ins'=>49,'html:ol'=>50,'html:pre'=>51,'html:rb'=>52,'html:rp'=>53,'html:rt'=>54,'html:rtc'=>55,'html:ruby'=>56,'html:span'=>57,'html:sub'=>58,'html:td'=>59,'html:tfoot'=>60,'html:th'=>61,'html:u'=>62,'html:ul'=>63,'p'=>64];
	public function __sleep()
	{
		$props = get_object_vars($this);
		unset($props['out'], $props['proc'], $props['source']);
		return array_keys($props);
	}
	public function renderRichText($xml)
	{
		if (!isset($this->quickRenderingTest) || !preg_match($this->quickRenderingTest, $xml))
			try
			{
				return $this->renderQuick($xml);
			}
			catch (\Exception $e)
			{
			}
		$dom = $this->loadXML($xml);
		$this->out = '';
		$this->at($dom->documentElement);
		return $this->out;
	}
	protected function at(\DOMNode $root)
	{
		if ($root->nodeType === 3)
			$this->out .= htmlspecialchars($root->textContent,0);
		else
			foreach ($root->childNodes as $node)
				if (!isset(self::$tagBranches[$node->nodeName]))
					$this->at($node);
				else
				{
					$tb = self::$tagBranches[$node->nodeName];
					if($tb<33)if($tb<17)if($tb<9)if($tb<5)if($tb<3){if($tb===0){$this->out.='<span data-s9e-mediaembed="bandcamp" style="display:inline-block;width:100%;max-width:400px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:100%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//bandcamp.com/EmbeddedPlayer/size=large/minimal=true/';if($node->hasAttribute('album_id')){$this->out.='album='.htmlspecialchars($node->getAttribute('album_id'),2);if($node->hasAttribute('track_num'))$this->out.='/t='.htmlspecialchars($node->getAttribute('track_num'),2);}else$this->out.='track='.htmlspecialchars($node->getAttribute('track_id'),2);$this->out.='"></iframe></span></span>';}elseif($tb===1){$this->out.='<code>';$this->at($node);$this->out.='</code>';}else{$this->out.='<pre><code';if($node->hasAttribute('lang'))$this->out.=' class="language-'.htmlspecialchars($node->getAttribute('lang'),2).'"';$this->out.='>';$this->at($node);$this->out.='</code></pre>';}}elseif($tb===3)$this->out.='<span data-s9e-mediaembed="dailymotion" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//www.dailymotion.com/embed/video/'.htmlspecialchars($node->getAttribute('id'),2).'" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>';else{$this->out.='<del>';$this->at($node);$this->out.='</del>';}elseif($tb===5){$this->out.='<em>';$this->at($node);$this->out.='</em>';}elseif($tb===6){$this->out.='<a href="mailto:'.htmlspecialchars($node->getAttribute('email'),2).'">';$this->at($node);$this->out.='</a>';}elseif($tb===7)$this->at($node);else$this->out.='<iframe data-s9e-mediaembed="facebook" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" scrolling="no" src="https://s9e.github.io/iframe/facebook.min.html#'.htmlspecialchars($node->getAttribute('type').$node->getAttribute('id'),2).'" style="border:0;height:360px;max-width:640px;width:100%"></iframe>';elseif($tb<13)if($tb===9)$this->out.=htmlspecialchars($node->getAttribute('char'),0);elseif($tb===10){$this->out.='<h1>';$this->at($node);$this->out.='</h1>';}elseif($tb===11){$this->out.='<h2>';$this->at($node);$this->out.='</h2>';}else{$this->out.='<h3>';$this->at($node);$this->out.='</h3>';}elseif($tb===13){$this->out.='<h4>';$this->at($node);$this->out.='</h4>';}elseif($tb===14){$this->out.='<h5>';$this->at($node);$this->out.='</h5>';}elseif($tb===15){$this->out.='<h6>';$this->at($node);$this->out.='</h6>';}else$this->out.='<!--'.htmlspecialchars($node->getAttribute('content'),0).'-->';elseif($tb<25)if($tb<21){if($tb===17)$this->out.='<hr>';elseif($tb===18){$this->out.='<img src="'.htmlspecialchars($node->getAttribute('src'),2).'"';if($node->hasAttribute('alt'))$this->out.=' alt="'.htmlspecialchars($node->getAttribute('alt'),2).'"';if($node->hasAttribute('title'))$this->out.=' title="'.htmlspecialchars($node->getAttribute('title'),2).'"';$this->out.='>';}elseif($tb===19){$this->out.='<li>';$this->at($node);$this->out.='</li>';}elseif(!$node->hasAttribute('type')){$this->out.='<ul>';$this->at($node);$this->out.='</ul>';}else{$this->out.='<ol';if($node->hasAttribute('start'))$this->out.=' start="'.htmlspecialchars($node->getAttribute('start'),2).'"';$this->out.='>';$this->at($node);$this->out.='</ol>';}}elseif($tb===21)$this->out.='<span data-s9e-mediaembed="liveleak" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//www.liveleak.com/ll_embed?i='.htmlspecialchars($node->getAttribute('id'),2).'" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>';elseif($tb===22){$this->out.='<blockquote>';$this->at($node);$this->out.='</blockquote>';}elseif($tb===23){$this->out.='<iframe data-s9e-mediaembed="soundcloud" allowfullscreen="" scrolling="no" src="https://w.soundcloud.com/player/?url=';if($node->hasAttribute('playlist_id'))$this->out.='https%3A//api.soundcloud.com/playlists/'.htmlspecialchars($node->getAttribute('playlist_id'),2);elseif($node->hasAttribute('track_id'))$this->out.='https%3A//api.soundcloud.com/tracks/'.htmlspecialchars($node->getAttribute('track_id'),2).'&amp;secret_token='.htmlspecialchars($node->getAttribute('secret_token'),2);else{if((strpos($node->getAttribute('id'),'://')===false))$this->out.='https%3A//soundcloud.com/';$this->out.=htmlspecialchars($node->getAttribute('id'),2);}$this->out.='" style="border:0;height:';if($node->hasAttribute('playlist_id')||(strpos($node->getAttribute('id'),'/sets/')!==false))$this->out.='450';else$this->out.='166';$this->out.='px;max-width:900px;width:100%"></iframe>';}else{$this->out.='<span data-s9e-mediaembed="spotify" style="display:inline-block;width:100%;max-width:400px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:120%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="https://embed.spotify.com/?view=coverart&amp;uri=';if($node->hasAttribute('uri'))$this->out.=htmlspecialchars($node->getAttribute('uri'),2);else$this->out.='spotify:'.htmlspecialchars(strtr($node->getAttribute('path'),'/',':'),2);$this->out.='"></iframe></span></span>';}elseif($tb<29)if($tb===25){$this->out.='<strong>';$this->at($node);$this->out.='</strong>';}elseif($tb===26){$this->out.='<sup>';$this->at($node);$this->out.='</sup>';}elseif($tb===27){$this->out.='<table>';$this->at($node);$this->out.='</table>';}else{$this->out.='<tbody>';$this->at($node);$this->out.='</tbody>';}elseif($tb===29){$this->out.='<td';if($node->hasAttribute('align'))$this->out.=' style="text-align:'.htmlspecialchars($node->getAttribute('align'),2).'"';$this->out.='>';$this->at($node);$this->out.='</td>';}elseif($tb===30){$this->out.='<th';if($node->hasAttribute('align'))$this->out.=' style="text-align:'.htmlspecialchars($node->getAttribute('align'),2).'"';$this->out.='>';$this->at($node);$this->out.='</th>';}elseif($tb===31){$this->out.='<thead>';$this->at($node);$this->out.='</thead>';}else{$this->out.='<tr>';$this->at($node);$this->out.='</tr>';}elseif($tb<49){if($tb<41){if($tb<37)if($tb===33){$this->out.='<span data-s9e-mediaembed="twitch" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="';if($node->hasAttribute('clip_id')){$this->out.='//clips.twitch.tv/embed?autoplay=false&amp;clip=';if($node->hasAttribute('channel'))$this->out.=htmlspecialchars($node->getAttribute('channel'),2).'/';$this->out.=htmlspecialchars($node->getAttribute('clip_id'),2);}else{$this->out.='//player.twitch.tv/?autoplay=false&amp;';if($node->hasAttribute('video_id'))$this->out.='video=v'.htmlspecialchars($node->getAttribute('video_id'),2);else$this->out.='channel='.htmlspecialchars($node->getAttribute('channel'),2);if($node->hasAttribute('t'))$this->out.='&amp;time='.htmlspecialchars($node->getAttribute('t'),2);}$this->out.='"></iframe></span></span>';}elseif($tb===34){$this->out.='<a href="'.htmlspecialchars($node->getAttribute('url'),2).'"';if($node->hasAttribute('title'))$this->out.=' title="'.htmlspecialchars($node->getAttribute('title'),2).'"';$this->out.='>';$this->at($node);$this->out.='</a>';}elseif($tb===35)$this->out.='<span data-s9e-mediaembed="vimeo" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//player.vimeo.com/video/'.htmlspecialchars($node->getAttribute('id'),2).'" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>';else$this->out.='<span data-s9e-mediaembed="vine" style="display:inline-block;width:100%;max-width:480px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:100%"><iframe allowfullscreen="" scrolling="no" src="https://vine.co/v/'.htmlspecialchars($node->getAttribute('id'),2).'/embed/simple?audio=1" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>';elseif($tb===37){$this->out.='<span data-s9e-mediaembed="youtube" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="background:url(https://i.ytimg.com/vi/'.htmlspecialchars($node->getAttribute('id'),2).'/hqdefault.jpg) 50% 50% / cover;border:0;height:100%;left:0;position:absolute;width:100%" src="https://www.youtube.com/embed/'.htmlspecialchars($node->getAttribute('id'),2).'?controls=2';if($node->hasAttribute('list'))$this->out.='&amp;list='.htmlspecialchars($node->getAttribute('list'),2);if($node->hasAttribute('t')||$node->hasAttribute('m')){$this->out.='&amp;start=';if($node->hasAttribute('t'))$this->out.=htmlspecialchars($node->getAttribute('t'),2);elseif($node->hasAttribute('h'))$this->out.=htmlspecialchars($node->getAttribute('h')*3600+$node->getAttribute('m')*60+$node->getAttribute('s'),2);else$this->out.=htmlspecialchars($node->getAttribute('m')*60+$node->getAttribute('s'),2);}$this->out.='"></iframe></span></span>';}elseif($tb===38)$this->out.='<br>';elseif($tb===39);else{$this->out.='<abbr';if($node->hasAttribute('title'))$this->out.=' title="'.htmlspecialchars($node->getAttribute('title'),2).'"';$this->out.='>';$this->at($node);$this->out.='</abbr>';}}elseif($tb<45){if($tb===41){$this->out.='<b>';$this->at($node);$this->out.='</b>';}elseif($tb===42)$this->out.='<br>';elseif($tb===43){$this->out.='<dd>';$this->at($node);$this->out.='</dd>';}else{$this->out.='<div';if($node->hasAttribute('class'))$this->out.=' class="'.htmlspecialchars($node->getAttribute('class'),2).'"';$this->out.='>';$this->at($node);$this->out.='</div>';}}elseif($tb===45){$this->out.='<dl>';$this->at($node);$this->out.='</dl>';}elseif($tb===46){$this->out.='<dt>';$this->at($node);$this->out.='</dt>';}elseif($tb===47){$this->out.='<i>';$this->at($node);$this->out.='</i>';}else{$this->out.='<img';if($node->hasAttribute('alt'))$this->out.=' alt="'.htmlspecialchars($node->getAttribute('alt'),2).'"';if($node->hasAttribute('height'))$this->out.=' height="'.htmlspecialchars($node->getAttribute('height'),2).'"';if($node->hasAttribute('src'))$this->out.=' src="'.htmlspecialchars($node->getAttribute('src'),2).'"';if($node->hasAttribute('title'))$this->out.=' title="'.htmlspecialchars($node->getAttribute('title'),2).'"';if($node->hasAttribute('width'))$this->out.=' width="'.htmlspecialchars($node->getAttribute('width'),2).'"';$this->out.='>';}}elseif($tb<57)if($tb<53)if($tb===49){$this->out.='<ins>';$this->at($node);$this->out.='</ins>';}elseif($tb===50){$this->out.='<ol>';$this->at($node);$this->out.='</ol>';}elseif($tb===51){$this->out.='<pre>';$this->at($node);$this->out.='</pre>';}else{$this->out.='<rb>';$this->at($node);$this->out.='</rb>';}elseif($tb===53){$this->out.='<rp>';$this->at($node);$this->out.='</rp>';}elseif($tb===54){$this->out.='<rt>';$this->at($node);$this->out.='</rt>';}elseif($tb===55){$this->out.='<rtc>';$this->at($node);$this->out.='</rtc>';}else{$this->out.='<ruby>';$this->at($node);$this->out.='</ruby>';}elseif($tb<61)if($tb===57){$this->out.='<span';if($node->hasAttribute('class'))$this->out.=' class="'.htmlspecialchars($node->getAttribute('class'),2).'"';$this->out.='>';$this->at($node);$this->out.='</span>';}elseif($tb===58){$this->out.='<sub>';$this->at($node);$this->out.='</sub>';}elseif($tb===59){$this->out.='<td';if($node->hasAttribute('colspan'))$this->out.=' colspan="'.htmlspecialchars($node->getAttribute('colspan'),2).'"';if($node->hasAttribute('rowspan'))$this->out.=' rowspan="'.htmlspecialchars($node->getAttribute('rowspan'),2).'"';$this->out.='>';$this->at($node);$this->out.='</td>';}else{$this->out.='<tfoot>';$this->at($node);$this->out.='</tfoot>';}elseif($tb===61){$this->out.='<th';if($node->hasAttribute('colspan'))$this->out.=' colspan="'.htmlspecialchars($node->getAttribute('colspan'),2).'"';if($node->hasAttribute('rowspan'))$this->out.=' rowspan="'.htmlspecialchars($node->getAttribute('rowspan'),2).'"';if($node->hasAttribute('scope'))$this->out.=' scope="'.htmlspecialchars($node->getAttribute('scope'),2).'"';$this->out.='>';$this->at($node);$this->out.='</th>';}elseif($tb===62){$this->out.='<u>';$this->at($node);$this->out.='</u>';}elseif($tb===63){$this->out.='<ul>';$this->at($node);$this->out.='</ul>';}else{$this->out.='<p>';$this->at($node);$this->out.='</p>';}
				}
	}
	private static $static=['/C'=>'</code>','/CODE'=>'</code></pre>','/DEL'=>'</del>','/EM'=>'</em>','/EMAIL'=>'</a>','/ESC'=>'','/H1'=>'</h1>','/H2'=>'</h2>','/H3'=>'</h3>','/H4'=>'</h4>','/H5'=>'</h5>','/H6'=>'</h6>','/LI'=>'</li>','/QUOTE'=>'</blockquote>','/STRONG'=>'</strong>','/SUP'=>'</sup>','/TABLE'=>'</table>','/TBODY'=>'</tbody>','/TD'=>'</td>','/TH'=>'</th>','/THEAD'=>'</thead>','/TR'=>'</tr>','/URL'=>'</a>','/html:abbr'=>'</abbr>','/html:b'=>'</b>','/html:code'=>'</code>','/html:dd'=>'</dd>','/html:del'=>'</del>','/html:div'=>'</div>','/html:dl'=>'</dl>','/html:dt'=>'</dt>','/html:i'=>'</i>','/html:ins'=>'</ins>','/html:li'=>'</li>','/html:ol'=>'</ol>','/html:pre'=>'</pre>','/html:rb'=>'</rb>','/html:rp'=>'</rp>','/html:rt'=>'</rt>','/html:rtc'=>'</rtc>','/html:ruby'=>'</ruby>','/html:span'=>'</span>','/html:strong'=>'</strong>','/html:sub'=>'</sub>','/html:sup'=>'</sup>','/html:table'=>'</table>','/html:tbody'=>'</tbody>','/html:td'=>'</td>','/html:tfoot'=>'</tfoot>','/html:th'=>'</th>','/html:thead'=>'</thead>','/html:tr'=>'</tr>','/html:u'=>'</u>','/html:ul'=>'</ul>','C'=>'<code>','DEL'=>'<del>','EM'=>'<em>','ESC'=>'','H1'=>'<h1>','H2'=>'<h2>','H3'=>'<h3>','H4'=>'<h4>','H5'=>'<h5>','H6'=>'<h6>','HR'=>'<hr>','LI'=>'<li>','QUOTE'=>'<blockquote>','STRONG'=>'<strong>','SUP'=>'<sup>','TABLE'=>'<table>','TBODY'=>'<tbody>','THEAD'=>'<thead>','TR'=>'<tr>','html:b'=>'<b>','html:br'=>'<br>','html:code'=>'<code>','html:dd'=>'<dd>','html:del'=>'<del>','html:dl'=>'<dl>','html:dt'=>'<dt>','html:i'=>'<i>','html:ins'=>'<ins>','html:li'=>'<li>','html:ol'=>'<ol>','html:pre'=>'<pre>','html:rb'=>'<rb>','html:rp'=>'<rp>','html:rt'=>'<rt>','html:rtc'=>'<rtc>','html:ruby'=>'<ruby>','html:strong'=>'<strong>','html:sub'=>'<sub>','html:sup'=>'<sup>','html:table'=>'<table>','html:tbody'=>'<tbody>','html:tfoot'=>'<tfoot>','html:thead'=>'<thead>','html:tr'=>'<tr>','html:u'=>'<u>','html:ul'=>'<ul>'];
	private static $dynamic=['DAILYMOTION'=>['(^[^ ]+(?> (?!id=)[^=]+="[^"]*")*(?> id="([^"]*)")?.*)s','<span data-s9e-mediaembed="dailymotion" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//www.dailymotion.com/embed/video/$1" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>'],'EMAIL'=>['(^[^ ]+(?> (?!email=)[^=]+="[^"]*")*(?> email="([^"]*)")?.*)s','<a href="mailto:$1">'],'IMG'=>['(^[^ ]+(?> (?!(?>alt|src|title)=)[^=]+="[^"]*")*( alt="[^"]*")?(?> (?!(?>src|title)=)[^=]+="[^"]*")*(?> src="([^"]*)")?(?> (?!title=)[^=]+="[^"]*")*( title="[^"]*")?.*)s','<img src="$2"$1$3>'],'LIVELEAK'=>['(^[^ ]+(?> (?!id=)[^=]+="[^"]*")*(?> id="([^"]*)")?.*)s','<span data-s9e-mediaembed="liveleak" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//www.liveleak.com/ll_embed?i=$1" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>'],'URL'=>['(^[^ ]+(?> (?!(?>title|url)=)[^=]+="[^"]*")*( title="[^"]*")?(?> (?!url=)[^=]+="[^"]*")*(?> url="([^"]*)")?.*)s','<a href="$2"$1>'],'VIMEO'=>['(^[^ ]+(?> (?!id=)[^=]+="[^"]*")*(?> id="([^"]*)")?.*)s','<span data-s9e-mediaembed="vimeo" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="//player.vimeo.com/video/$1" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>'],'VINE'=>['(^[^ ]+(?> (?!id=)[^=]+="[^"]*")*(?> id="([^"]*)")?.*)s','<span data-s9e-mediaembed="vine" style="display:inline-block;width:100%;max-width:480px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:100%"><iframe allowfullscreen="" scrolling="no" src="https://vine.co/v/$1/embed/simple?audio=1" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>'],'html:abbr'=>['(^[^ ]+(?> (?!title=)[^=]+="[^"]*")*( title="[^"]*")?.*)s','<abbr$1>'],'html:div'=>['(^[^ ]+(?> (?!class=)[^=]+="[^"]*")*( class="[^"]*")?.*)s','<div$1>'],'html:img'=>['(^[^ ]+(?> (?!(?>alt|height|src|title|width)=)[^=]+="[^"]*")*( alt="[^"]*")?(?> (?!(?>height|src|title|width)=)[^=]+="[^"]*")*( height="[^"]*")?(?> (?!(?>src|title|width)=)[^=]+="[^"]*")*( src="[^"]*")?(?> (?!(?>title|width)=)[^=]+="[^"]*")*( title="[^"]*")?(?> (?!width=)[^=]+="[^"]*")*( width="[^"]*")?.*)s','<img$1$2$3$4$5>'],'html:span'=>['(^[^ ]+(?> (?!class=)[^=]+="[^"]*")*( class="[^"]*")?.*)s','<span$1>'],'html:td'=>['(^[^ ]+(?> (?!(?>col|row)span=)[^=]+="[^"]*")*( colspan="[^"]*")?(?> (?!rowspan=)[^=]+="[^"]*")*( rowspan="[^"]*")?.*)s','<td$1$2>'],'html:th'=>['(^[^ ]+(?> (?!(?>colspan|rowspan|scope)=)[^=]+="[^"]*")*( colspan="[^"]*")?(?> (?!(?>rowspan|scope)=)[^=]+="[^"]*")*( rowspan="[^"]*")?(?> (?!scope=)[^=]+="[^"]*")*( scope="[^"]*")?.*)s','<th$1$2$3>']];
	private static $attributes;
	private static $quickBranches=['/LIST'=>0,'BANDCAMP'=>1,'CODE'=>2,'FACEBOOK'=>3,'FP'=>4,'HC'=>5,'HE'=>4,'LIST'=>6,'SOUNDCLOUD'=>7,'SPOTIFY'=>8,'TD'=>9,'TH'=>10,'TWITCH'=>11,'YOUTUBE'=>12];

	protected function renderQuick($xml)
	{
		$xml = $this->decodeSMP($xml);
		self::$attributes = [];
		$html = preg_replace_callback(
			'(<(?:(?!/)((?>BANDCAMP|DAILYMOTION|F(?>P|ACEBOOK)|H[CER]|IMG|LIVELEAK|S(?>OUNDCLOUD|POTIFY)|TWITCH|VI(?>MEO|NE)|YOUTUBE|html:(?>br|img)))(?: [^>]*)?>.*?</\\1|(/?(?!br/|p>)[^ />]+)[^>]*?(/)?)>)s',
			[$this, 'quick'],
			preg_replace(
				'(<[eis]>[^<]*</[eis]>)',
				'',
				substr($xml, 1 + strpos($xml, '>'), -4)
			)
		);

		return str_replace('<br/>', '<br>', $html);
	}

	protected function quick($m)
	{
		if (isset($m[2]))
		{
			$id = $m[2];

			if (isset($m[3]))
			{
				unset($m[3]);

				$m[0] = substr($m[0], 0, -2) . '>';
				$html = $this->quick($m);

				$m[0] = '</' . $id . '>';
				$m[2] = '/' . $id;
				$html .= $this->quick($m);

				return $html;
			}
		}
		else
		{
			$id = $m[1];

			$lpos = 1 + strpos($m[0], '>');
			$rpos = strrpos($m[0], '<');
			$textContent = substr($m[0], $lpos, $rpos - $lpos);

			if (strpos($textContent, '<') !== false)
				throw new \RuntimeException;

			$textContent = htmlspecialchars_decode($textContent);
		}

		if (isset(self::$static[$id]))
			return self::$static[$id];

		if (isset(self::$dynamic[$id]))
		{
			list($match, $replace) = self::$dynamic[$id];
			return preg_replace($match, $replace, $m[0], 1);
		}

		if (!isset(self::$quickBranches[$id]))
		{
			if ($id[0] === '!' || $id[0] === '?')
				throw new \RuntimeException;
			return '';
		}

		$attributes = [];
		if (strpos($m[0], '="') !== false)
		{
			preg_match_all('(([^ =]++)="([^"]*))S', substr($m[0], 0, strpos($m[0], '>')), $matches);
			foreach ($matches[1] as $i => $attrName)
				$attributes[$attrName] = $matches[2][$i];
		}

		$qb = self::$quickBranches[$id];
		if($qb<7){if($qb<4)if($qb===0){$attributes=array_pop(self::$attributes);$html='';if(!isset($attributes['type']))$html.='</ul>';else$html.='</ol>';}elseif($qb===1){$attributes+=['track_num'=>null,'track_id'=>null];$html='<span data-s9e-mediaembed="bandcamp" style="display:inline-block;width:100%;max-width:400px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:100%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="//bandcamp.com/EmbeddedPlayer/size=large/minimal=true/';if(isset($attributes['album_id'])){$html.='album='.$attributes['album_id'];if(isset($attributes['track_num']))$html.='/t='.$attributes['track_num'];}else$html.='track='.$attributes['track_id'];$html.='"></iframe></span></span>';}elseif($qb===2){$html='<pre><code';if(isset($attributes['lang']))$html.=' class="language-'.$attributes['lang'].'"';$html.='>';}else{$attributes+=['type'=>null,'id'=>null];$html='<iframe data-s9e-mediaembed="facebook" allowfullscreen="" onload="var a=Math.random();window.addEventListener(\'message\',function(b){if(b.data.id==a)style.height=b.data.height+\'px\'});contentWindow.postMessage(\'s9e:\'+a,\'https://s9e.github.io\')" scrolling="no" src="https://s9e.github.io/iframe/facebook.min.html#'.htmlspecialchars(htmlspecialchars_decode($attributes['type']).htmlspecialchars_decode($attributes['id']),2).'" style="border:0;height:360px;max-width:640px;width:100%"></iframe>';}elseif($qb===4){$attributes+=['char'=>null];$html=str_replace('&quot;','"',$attributes['char']);}elseif($qb===5){$attributes+=['content'=>null];$html='<!--'.str_replace('&quot;','"',$attributes['content']).'-->';}else{$html='';if(!isset($attributes['type']))$html.='<ul>';else{$html.='<ol';if(isset($attributes['start']))$html.=' start="'.$attributes['start'].'"';$html.='>';}self::$attributes[]=$attributes;}}elseif($qb<10){if($qb===7){$attributes+=['secret_token'=>null,'id'=>null];$html='<iframe data-s9e-mediaembed="soundcloud" allowfullscreen="" scrolling="no" src="https://w.soundcloud.com/player/?url=';if(isset($attributes['playlist_id']))$html.='https%3A//api.soundcloud.com/playlists/'.$attributes['playlist_id'];elseif(isset($attributes['track_id']))$html.='https%3A//api.soundcloud.com/tracks/'.$attributes['track_id'].'&amp;secret_token='.$attributes['secret_token'];else{if((strpos($attributes['id'],'://')===false))$html.='https%3A//soundcloud.com/';$html.=$attributes['id'];}$html.='" style="border:0;height:';if(isset($attributes['playlist_id'])||(strpos($attributes['id'],'/sets/')!==false))$html.='450';else$html.='166';$html.='px;max-width:900px;width:100%"></iframe>';}elseif($qb===8){$attributes+=['path'=>null];$html='<span data-s9e-mediaembed="spotify" style="display:inline-block;width:100%;max-width:400px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:120%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="https://embed.spotify.com/?view=coverart&amp;uri=';if(isset($attributes['uri']))$html.=$attributes['uri'];else$html.='spotify:'.strtr($attributes['path'],'/',':');$html.='"></iframe></span></span>';}else{$html='<td';if(isset($attributes['align']))$html.=' style="text-align:'.$attributes['align'].'"';$html.='>';}}elseif($qb===10){$html='<th';if(isset($attributes['align']))$html.=' style="text-align:'.$attributes['align'].'"';$html.='>';}elseif($qb===11){$attributes+=['channel'=>null,'clip_id'=>null];$html='<span data-s9e-mediaembed="twitch" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="border:0;height:100%;left:0;position:absolute;width:100%" src="';if(isset($attributes['clip_id'])){$html.='//clips.twitch.tv/embed?autoplay=false&amp;clip=';if(isset($attributes['channel']))$html.=$attributes['channel'].'/';$html.=$attributes['clip_id'];}else{$html.='//player.twitch.tv/?autoplay=false&amp;';if(isset($attributes['video_id']))$html.='video=v'.$attributes['video_id'];else$html.='channel='.$attributes['channel'];if(isset($attributes['t']))$html.='&amp;time='.$attributes['t'];}$html.='"></iframe></span></span>';}else{$attributes+=['id'=>null,'m'=>null,'s'=>null];$html='<span data-s9e-mediaembed="youtube" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="background:url(https://i.ytimg.com/vi/'.$attributes['id'].'/hqdefault.jpg) 50% 50% / cover;border:0;height:100%;left:0;position:absolute;width:100%" src="https://www.youtube.com/embed/'.$attributes['id'].'?controls=2';if(isset($attributes['list']))$html.='&amp;list='.$attributes['list'];if(isset($attributes['t'])||isset($attributes['m'])){$html.='&amp;start=';if(isset($attributes['t']))$html.=$attributes['t'];elseif(isset($attributes['h']))$html.=htmlspecialchars($attributes['h']*3600+$attributes['m']*60+$attributes['s'],2);else$html.=htmlspecialchars($attributes['m']*60+$attributes['s'],2);}$html.='"></iframe></span></span>';}

		return $html;
	}

	protected static function hasNonNullValues($array)
	{
		foreach ($array as $v)
			if (isset($v))
				return true;
		
		return false;
	}
}