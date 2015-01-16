<?php namespace Vinelab\Editor\Transformers;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
 class JavascriptTransformer extends AbstractTransformer {

    public static function make($content)
    {
        $pattern = '/<script\b[^>]*>(.*?)<\/script>(\\n?)/is';

        return preg_replace($pattern, '', $content);
    }
 }
