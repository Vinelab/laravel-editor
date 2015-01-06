<?php namespace Vinelab\Editor\Transformers;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
abstract class AbstractTransformer {

    /**
     * Get the JSON representation of the current content class.
     *
     * @return StdClass
     */
    public function toJson()
    {
        return (object) $this->embeds;
    }

    /**
     * Get the array representation of the current content class.
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this->embeds;
    }
}
