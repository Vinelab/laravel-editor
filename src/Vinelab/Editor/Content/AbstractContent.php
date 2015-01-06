<?php namespace Vinelab\Editor\Content;

use DOMDocument;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
abstract class AbstractContent {

    protected $embeds = [];

    protected $transformed;

    public function embed($line, $html)
    {
        $this->embeds[] = $this->makeEmbed($line, $html);
    }

    /**
     * Get the embed data of the given line from html.
     *
     * @param  string $line
     * @param  string $html
     *
     * @return array
     */
    abstract public function makeEmbed($line, $html);

    public function getDivAttribute($html, $attribute)
    {
        return $this->getElementAttribute($html, 'div', $attribute);
    }

    public function getBlockquoteAttribute($html, $attribute)
    {
        return $this->getElementAttribute($html, 'blockquote', $attribute);
    }

    public function getIFrameAttribute($html, $attribute)
    {
        return $this->getElementAttribute($html, 'iframe', $attribute);
    }

    public function getElementAttribute($html, $element, $attribute)
    {
        $dom = $this->dom($html);
        $elements = $dom->getElementsByTagName($element);
        foreach ($elements as $element) {
            return $element->getAttribute($attribute);
        }
    }

    public function getElementContent($html, $element)
    {
        $dom = $this->dom($html);
        $tags = $dom->getElementsByTagName($element);
        $innerHTMl = '';
        foreach ($tags as $tag) {
            foreach ($tag->childNodes as $node) {
                $innerHTMl .= $node->ownerDocument->saveHTML($node);
            }

            return $innerHTMl;
        }
    }

    public function setTransformed($transformed)
    {
        $this->transformed = $transformed;
    }

    public function transformed()
    {
        return $this->transformed;
    }

    /**
     * Get a DOMDocument instance out of the given html.
     *
     * @param  string $html
     *
     * @return DOMDocument
     */
    public function dom($html)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($html);

        return $dom;
    }

    public function lines($html)
    {
       return array_map('trim', explode("\n", $html));
   }

    /**
     * Get the array representation of this class.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->embeds;
    }

    /**
     * Get the JSON representation of this class.
     *
     * @return StdClass
     */
    public function toJson()
    {
        return (object) $this->embeds;
    }
}
