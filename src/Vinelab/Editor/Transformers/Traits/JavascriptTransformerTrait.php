<?php namespace Vinelab\Editor\Transformers\Traits;

use Vinelab\Editor\Transformers\JavascriptTransformer;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */

trait JavascriptTransformerTrait {

    public function transformJavascript($html)
    {
        return JavascriptTransformer::make($html);
    }
}
