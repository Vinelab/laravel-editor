<?php namespace Vinelab\Editor\Transformers\Traits;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait TransformerTrait {

    public function setTransformedContent($content)
    {
        $this->content['text'] = $content;
    }

    public function transformed()
    {
        return $this->content['text'];
    }

    public function embed($embed, $content)
    {
        $this->content['embeds'][$embed] = $content;
    }

    public function getEmbed($embed)
    {
        return (isset($this->content['embeds'][$embed])) ? $this->content['embeds'][$embed] : null;
    }
}
