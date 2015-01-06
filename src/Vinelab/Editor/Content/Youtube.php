<?php namespace Vinelab\Editor\Content;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Youtube extends AbstractContent {

    /**
     * Get the embed data of the given line from html.
     *
     * @param  string $line
     * @param  string $html
     *
     * @return array
     */
    public function makeEmbed($line, $html)
    {
        $lines = $this->lines($html);

        return [
            'url' => $this->url($line),
            'id' => $this->id($line),
            'html' => $line,
            'line' => array_search($line, $lines),
        ];
    }

    /**
     * Get the embed url.
     *
     * @param  string $line
     *
     * @return string
     */
    public function url($line)
    {
        $url = $this->getIFrameAttribute($line, 'src');

        // if the url has no scheme, add https.
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (! isset($scheme)) {
            $url = 'https:'.$url;
        }

        return $url;
    }

    /**
     * Get the video id.
     *
     * @param  string $line
     *
     * @return string
     */
    public function id($line)
    {
        $path = parse_url($this->url($line), PHP_URL_PATH);
        $components = explode('/', $path);

        return last($components);
    }
}
