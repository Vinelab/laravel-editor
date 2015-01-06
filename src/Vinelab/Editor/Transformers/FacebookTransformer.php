<?php namespace Vinelab\Editor\Transformers;

use Vinelab\Editor\Content\Facebook;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class FacebookTransformer extends AbstractTransformer {

    public static function make($html, $transformed)
    {
        $pattern = "/<div class=[\"|']fb-post[\"|'](.*)>(.*)<\/div>?/i";
        preg_match_all($pattern, $html, $matches);

        $instance = new Facebook();
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
