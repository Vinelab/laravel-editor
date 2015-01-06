<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\HTMLTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait HTMLTransformerTrait {

    public function transformHTML($html)
    {
        $html = $this->makeHTMLTransformation($html);
        $this->setTransformedContent($html);

        return $html;
    }

    public function makeHTMLTransformation($html)
    {
        return HTMLTransformer::make($html, $this->transformed());
    }

    public function setHTMLContent($html)
    {
        $this->content['html'] = $html;
    }

    public function html()
    {
        return $this->content['html'];
    }
}
