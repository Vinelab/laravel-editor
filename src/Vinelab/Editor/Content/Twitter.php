<?php namespace Vinelab\Editor\Content;

class Twitter extends AbstractContent {

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
            'tweet' => $this->tweet($line),
            'lang' => $this->lang($line),
            'html' => $line,
            'line' => array_search($line, $lines),
        ];
    }

    public function tweet($line)
    {
        return $this->getElementContent($line, 'blockquote');
    }

    public function lang($line)
    {
        return $this->getBlockquoteAttribute($line, 'lang');
    }
}
