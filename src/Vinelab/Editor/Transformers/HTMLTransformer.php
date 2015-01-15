<?php namespace Vinelab\Editor\Transformers;

class HTMLTransformer extends AbstractTransformer {

    public static function make($html, $transformed)
    {
        $transformed = strip_tags($transformed);

        return $transformed;
    }
}
