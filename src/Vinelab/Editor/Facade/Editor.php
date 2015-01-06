<?php namespace Vinelab\Editor\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Editor extends Facade {

    const INPUT = 'vinelab-editor-wysiwyg-value';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vinelab.editor';
    }
}
