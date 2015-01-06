<?php namespace Vinelab\Editor;

use Michelf\Markdown;
use Vinelab\Editor\Transformers\Traits\TransformerTrait;
use Vinelab\Editor\Transformers\Traits\LinkTransformerTrait;
use Vinelab\Editor\Transformers\Traits\HTMLTransformerTrait;
use Vinelab\Editor\Transformers\Traits\TwitterTransformerTrait;
use Vinelab\Editor\Transformers\Traits\YoutubeTransformerTrait;
use Vinelab\Editor\Transformers\Traits\FacebookTransformerTrait;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Content {

    use TransformerTrait;
    use HTMLTransformerTrait;
    use LinkTransformerTrait;
    use TwitterTransformerTrait;
    use YoutubeTransformerTrait;
    use FacebookTransformerTrait;

    /**
     * Hold the content text and embeds.
     *
     * @var array
     */
    protected $content = [];

    public function __construct($html)
    {
        $this->transform($html);
    }

    public static function make($html)
    {
        return new static($html);
    }

    public function transform($markdown)
    {
        // Get the HTML representation of content
        $html = Markdown::defaultTransform($markdown);

        // Set the original content as HTML and Transformed initially.
        $this->setHTMLContent($html);
        $this->setTransformedContent($markdown);

        // Perform transformations
        $transformed = $this->transformFacebook($markdown);
        $transformed = $this->transformTwitter($markdown);
        $transformed = $this->transformYoutube($markdown);
        $transformed = $this->transformLinks($transformed);
        // N.B. Keep HTML transformation till last in case the previous
        // transformations deal with html since all the tags will be stripped at this point.
        $this->transformHTML($transformed);
    }

    public function text()
    {
        return $this->transformed();
    }

    public function __toString()
    {
        return $this->text();
    }

    public function toJson()
    {
        return json_decode(json_encode($this->toArray()));
    }

    public function toArray()
    {
        return [
            'text' => $this->text(),
            'html' => $this->html(),
            'embeds' => [
                'facebook' => $this->facebook()->toArray(),
                'twitter'  => $this->twitter()->toArray(),
                'youtube'  => $this->youtube()->toArray(),
                'links'    => $this->links()->toArray(),
            ]
        ];
        return (array) $this->content;
    }
}
