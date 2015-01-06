<?php namespace Vinelab\Editor\Content;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Link extends AbstractContent {

    public function makeEmbed($embed, $markdown)
    {
        $position = $embed['position'];
        $url = $embed['url'];
        $text = $embed['text'];
        $line = $embed['line'];

        return [
            'url' => $url,
            'text' => $text,
            'html' => $line,
            'indices' => [$position, ($position+strlen($text))],
        ];
    }

    public function url($line)
    {
        preg_match($this->pattern, $line, $match);

        if (isset($match[2])) {

            return $match[2];
        }
    }

    public function text($line)
    {
        preg_match($this->pattern, $line, $match);

        if (isset($match[3])) {

            return $match[3];
        }
    }
}
