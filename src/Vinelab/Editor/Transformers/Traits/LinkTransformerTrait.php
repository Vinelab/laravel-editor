<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\LinkTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait LinkTransformerTrait {

    public function transformLinks($html)
    {
        $link = $this->makeLinksTransformation($html);
        $this->setLinkContent($link);
        $this->setTransformedContent($link->transformed());

        return $link->transformed();
    }

    public function makeLinksTransformation($html)
    {
        return LinkTransformer::make($html);
    }

    public function setLinkContent($content)
    {
        $this->embed('links', $content);
    }

    public function links()
    {
        return $this->getEmbed('links');
    }
}
