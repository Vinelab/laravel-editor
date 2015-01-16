<?php namespace Vinelab\Editor\Content;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Facebook extends AbstractContent {

    /**
     * Get the embed data of the given line from html.
     *
     * @param  string $line * @param  string $html
     *
     * @return array
     */
    public function makeEmbed($line, $html)
    {
        // get trimmed lines
        $lines = $this->lines($html);

        return [
            'url'  => $this->url($line),
            'html' => $line,
            'line' => array_search(trim($line), $lines),
        ];
    }

    /**
     * Get the url from the given line.
     *
     * @param  string $line
     *
     * @return string
     */
    public function url($line)
    {
       return $this->getDivAttribute($line, 'data-href');
    }
}
