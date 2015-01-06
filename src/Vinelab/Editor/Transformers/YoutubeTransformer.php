<?php namespace Vinelab\Editor\Transformers;

use Vinelab\Editor\Content\Youtube;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class YoutubeTransformer extends AbstractTransformer {

    public static function make($html, $transformed)
    {
        $pattern = "/<iframe (.*) src=[\"|']\/\/(www\.)?youtube\.com(.*)[\"|'](.*)>(.*)<\/iframe>/i";
        preg_match_all($pattern, $html, $matches);

        $instance = new Youtube;
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
