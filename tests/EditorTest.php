<?php

use Vinelab\Editor\Editor;
use Illuminate\Support\Facades\Input;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class EditorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->editor = new Editor();
    }

    public function test_generating_embeds()
    {
        $text = <<<HTML

[Oxford Town](http://dylan.town)
<div class="fb-post" data-href="https://www.facebook.com/FacebookDevelopers/posts/10151471074398553" data-width="500"></div>

<div class='fb-post' data-href='https://www.facebook.com/FacebookDevelopers/posts/212625821854109664' data-width='500'></div>

<blockquote class="twitter-tweet" lang="en"><p>Sunsets don&#39;t get much better than this one over <a href="https://twitter.com/GrandTetonNPS">@GrandTetonNPS</a>. <a href="https://twitter.com/hashtag/nature?src=hash">#nature</a> <a href="https://twitter.com/hashtag/sunset?src=hash">#sunset</a> <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Dept of Interior (@Interior) <a href="https://twitter.com/Interior/status/463440424141459456">May 5, 2014</a></blockquote>

<iframe width="560" height="315" src="//www.youtube.com/embed/sOOebk_dKFo" frameborder="0" allowfullscreen></iframe>
HTML;

        $content = $this->editor->content($text);
        $json = $content->toJson();

        $this->assertNotEmpty($json->embeds->facebook);
        $this->assertCount(2, $json->embeds->facebook);

        $this->assertNotEmpty($json->embeds->twitter);
        $this->assertCount(1, $json->embeds->twitter);

        $this->assertNotEmpty($json->embeds->youtube);
        $this->assertCount(1, $json->embeds->youtube);

        $this->assertNotEmpty($json->embeds->links);
        $this->assertCount(1, $json->embeds->links);
    }

    public function test_just_text_transformation()
    {
        $input = <<<INPUT
Just Text Here.
INPUT;

        $json = $this->editor->content($input)->toJson();

        $this->assertEquals($input, $json->text);

    }

    public function test_text_tranformation_with_embeds()
    {
        $input = <<<HTML
Rain and wind.
[Oxford Town](http://dylan.town)
<div class="fb-post" data-href="https://www.facebook.com/FacebookDevelopers/posts/10151471074398553" data-width="500"></div>

<div class='fb-post' data-href='https://www.facebook.com/FacebookDevelopers/posts/212625821854109664' data-width='500'></div>

<blockquote class="twitter-tweet" lang="en"><p>Sunsets don&#39;t get much better than this one over <a href="https://twitter.com/GrandTetonNPS">@GrandTetonNPS</a>. <a href="https://twitter.com/hashtag/nature?src=hash">#nature</a> <a href="https://twitter.com/hashtag/sunset?src=hash">#sunset</a> <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Dept of Interior (@Interior) <a href="https://twitter.com/Interior/status/463440424141459456">May 5, 2014</a></blockquote>

<iframe width="560" height="315" src="//www.youtube.com/embed/sOOebk_dKFo" frameborder="0" allowfullscreen></iframe>
HTML;
        $content = $this->editor->content($input);
        $json = $content->toJson();

        $expected = <<<EXPECTED
Rain and wind.
Oxford Town







EXPECTED;

        $this->assertEquals($expected, $json->text);
    }

    public function test_links()
    {
        $input = <<<LINKS
[Holy Gun](http://holy-g.un)

Another Text

[Turn](http://to.the.rain)
LINKS;

        $expected = <<<EXPECTED
Holy Gun

Another Text

Turn
EXPECTED;

        $json = $this->editor->content($input)->toJson();

        $this->assertEquals($expected, $json->text);

        $link = $json->embeds->links[0];
        $this->assertEquals('Holy Gun', $link->text);
        $this->assertEquals('http://holy-g.un', $link->url);
        $this->assertEquals('[Holy Gun](http://holy-g.un)', $link->markdown);
        $this->assertEquals('<a href="http://holy-g.un">Holy Gun</a>', $link->html);

        $link_2 = $json->embeds->links[1];
        $this->assertEquals('Turn', $link_2->text);
        $this->assertEquals('http://to.the.rain', $link_2->url);
        $this->assertEquals('[Turn](http://to.the.rain)', $link_2->markdown);
        $this->assertEquals('<a href="http://to.the.rain">Turn</a>', $link_2->html);
    }

    public function test_instagram_embed()
    {
        $input = <<<INSTAAA

<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="4" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://instagram.com/p/x6FQ5slARB/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_top">#lebanese Square #Bread do exist; rye or oat flour bread, Wheat free.</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A photo posted by NoGarlicNoOnions (@nogarlicnoonions) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2015-01-16T08:07:17+00:00">Jan 16, 2015 at 12:07am PST</time></p></div></blockquote>
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>

<blockquote class="instagram-media" data-instgrm-version="4" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://instagram.com/p/x6WfpJmCKR/" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_top">A photo posted by BACH Music Institute (@bachmusicinstitute)</a> on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2015-01-16T10:37:51+00:00">Jan 16, 2015 at 2:37am PST</time></p></div></blockquote> <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
INSTAAA;

        $json = $this->editor->content($input)->toJson();

        $text = <<<TEXT




TEXT;

        $lines = explode("\n", $json->text);
        $this->assertCount(3, $lines);

        foreach ($lines as $line) {
            $this->assertEmpty(trim($line));
        }

        $embed = $json->embeds->instagram[0];

        $expected = <<<EXPECTED
<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="4" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://instagram.com/p/x6FQ5slARB/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_top">#lebanese Square #Bread do exist; rye or oat flour bread, Wheat free.</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A photo posted by NoGarlicNoOnions (@nogarlicnoonions) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2015-01-16T08:07:17+00:00">Jan 16, 2015 at 12:07am PST</time></p></div></blockquote>

EXPECTED;

        $this->assertEquals($expected, $embed->html);
        $this->assertEquals(1, $embed->line);

        $nocaption = $json->embeds->instagram[1];

        $second = <<<SEC
<blockquote class="instagram-media" data-instgrm-version="4" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://instagram.com/p/x6WfpJmCKR/" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_top">A photo posted by BACH Music Institute (@bachmusicinstitute)</a> on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2015-01-16T10:37:51+00:00">Jan 16, 2015 at 2:37am PST</time></p></div></blockquote>
SEC;

        $this->assertEquals($second, $nocaption->html);
        $this->assertEquals(3, $nocaption->line);
    }
}
