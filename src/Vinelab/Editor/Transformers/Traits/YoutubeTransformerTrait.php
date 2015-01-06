<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\YoutubeTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait YoutubeTransformerTrait {

    public function transformYoutube($html)
    {
        $youtube = $this->makeYoutubeTransformation($html);
        $this->setYoutubeContent($youtube);
        $this->setTransformedContent($youtube->transformed());

        return $youtube->transformed();
    }

    public function makeYoutubeTransformation($html)
    {
        return YoutubeTransformer::make($html, $this->transformed());
    }

    public function setYoutubeContent($content)
    {
        $this->embed('youtube', $content);
    }

    public function youtube()
    {
        return $this->getEmbed('youtube');
    }
}
