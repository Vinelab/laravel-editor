<?php namespace Vinelab\Editor\Transformers;

use Vinelab\Editor\Content\Twitter;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class TwitterTransformer extends AbstractTransformer {

    public static function make($html, $transformed)
    {
        $pattern = "/<blockquote class=[\"|']twitter-tweet[\"|'](.*)>(.*)<\/blockquote>/i";
        preg_match_all($pattern, $html, $matches);

        $instance = new Twitter();
        $matches = reset($matches);
        foreach ($matches as $line) {
            if (! empty($line)) {
                $instance->embed($line, $html);
            }
        }

        $instance->setTransformed(preg_replace($pattern, '', $transformed));

        return $instance;
    }
}
