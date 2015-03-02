<?php namespace Vinelab\Editor;

use View;
use DOMDocument;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Editor {

    const INPUT = 'vinelab-editor-text';

    /**
     * Get the view of the editor.
     *
     * @param  string $form The form id in which the content of this editor should exist.
     * @param  string $content Existing content.
     *
     * @return \Illuminate\View\View
     */
    public function view($content = null)
    {
        return view('vendor/laravel-editor/editor')->with(compact('content'))->render();
    }

    /**
     * Get the content instance for the given html.
     *
     * @param  string $content
     *
     * @return \Vinelab\Editor\Content
     */
    public function content($content)
    {
        return Content::make($content);
    }

    /**
     * Get the JSON representation of the content.
     * Convenience method for calling toJson() on a Content instance.
     *
     * @param  string $content
     * @return StdClass
     */
    public function json($content)
    {
        return $this->content($content)->toJson();
    }

    public function input()
    {
        return self::INPUT;
    }
}
