<?php namespace Vinelab\Editor\Transformers;

use Vinelab\Editor\Content\Instagram;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class InstagramTransformer extends AbstractTransformer {

    public static function make($html, $transformed)
    {
        $pattern = "/<blockquote class=[\"|']instagram-media[\"|'](.*)>(.*)<\/blockquote>?(\\n?)/i";
        preg_match_all($pattern, $html, $matches);

        $instance = new Instagram();
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
