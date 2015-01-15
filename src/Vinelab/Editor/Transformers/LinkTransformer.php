<?php namespace Vinelab\Editor\Transformers;

use Vinelab\Editor\Content\Link;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class LinkTransformer extends AbstractTransformer {

    public static function make($markdown)
    {
        // $pattern = '/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU';

        $pattern = '/\[([^\]]+)\]\(([^)"]+)(?: \"([^\"]+)\")?\)/';

        preg_match_all($pattern, $markdown, $matches);
        $instance = new Link();

        list($lines, $texts, $urls, $tooltips) = $matches;
        $matches_count = sizeof($lines);

        // let's start by setting the default markdown text as transformed.
        $instance->setTransformed($markdown);

        if ($matches_count > 0) {
            // We will only update in case we find matches.
            $replace = [];
            for ($i = 0; $i < $matches_count; $i++) {
                $line = $lines[$i];
                $text = $texts[$i];
                $url  = $urls[$i];
                // replace the links with their corresponding texts
                if (! empty($line)) {
                    $position = strpos($markdown, $line);
                    $markdown = str_replace($line, $text, $markdown);
                    $instance->embed(compact('line', 'url', 'text', 'position'), $markdown);
                    $instance->setTransformed($markdown);
                }
            }
        }

        return $instance;
    }
}
