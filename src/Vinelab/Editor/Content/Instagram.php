<?php namespace Vinelab\Editor\Content;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Instagram extends AbstractContent {

    public function makeEmbed($line, $html)
    {
        $lines = $this->lines($html);

        return [
            'html' => $line,
            'line' => array_search(trim($line), $lines)
        ];
    }
}
