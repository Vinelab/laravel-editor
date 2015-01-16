<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\FacebookTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait FacebookTransformerTrait {

    public function transformFacebook($html)
    {
        $facebook = $this->makeFacebookTransformation($html);
        $this->setFacebookContent($facebook);

        $transformed = $facebook->transformed();
        $this->setTransformedContent($transformed);

        return $transformed;
    }

    public function makeFacebookTransformation($html)
    {
        return FacebookTransformer::make($html, $this->transformed());
    }

    public function setFacebookContent($content)
    {
        $this->embed('facebook', $content);
    }

    public function facebook()
    {
        return $this->getEmbed('facebook');
    }
}
