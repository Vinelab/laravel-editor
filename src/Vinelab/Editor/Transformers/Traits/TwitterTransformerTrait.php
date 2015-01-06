<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\TwitterTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait TwitterTransformerTrait {

    public function transformTwitter($html)
    {
        $twitter = $this->makeTwitterTransformation($html);
        $this->setTwitterContent($twitter);
        $this->setTransformedContent($twitter->transformed());

        return $twitter->transformed();
    }

    public function makeTwitterTransformation($html)
    {
        return TwitterTransformer::make($html, $this->transformed());
    }

    public function setTwitterContent($content)
    {
        $this->embed('twitter', $content);
    }

    public function twitter()
    {
        return $this->getEmbed('twitter');
    }
}
