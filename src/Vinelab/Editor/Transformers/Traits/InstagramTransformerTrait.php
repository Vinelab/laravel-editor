<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\InstagramTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait InstagramTransformerTrait {

    public function transformInstagram($html)
    {
        $instagram = $this->makeInstagramTransformation($html);
        $this->setInstagramContent($instagram);

        $transformed = $instagram->transformed();
        $this->setTransformedContent($transformed);

        return $transformed;
    }

    public function makeInstagramTransformation($html)
    {
        return InstagramTransformer::make($html, $this->transformed());
    }

    public function setInstagramContent($content)
    {
        $this->embed('instagram', $content);
    }

    public function instagram()
    {
        return $this->getEmbed('instagram');
    }
}
