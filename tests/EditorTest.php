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
}
