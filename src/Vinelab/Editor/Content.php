<?php namespace Vinelab\Editor;

use Michelf\Markdown;
use Vinelab\Editor\Transformers\Traits\TransformerTrait;
use Vinelab\Editor\Transformers\Traits\LinkTransformerTrait;
use Vinelab\Editor\Transformers\Traits\HTMLTransformerTrait;
use Vinelab\Editor\Transformers\Traits\TwitterTransformerTrait;
use Vinelab\Editor\Transformers\Traits\YoutubeTransformerTrait;
use Vinelab\Editor\Transformers\Traits\FacebookTransformerTrait;
use Vinelab\Editor\Transformers\Traits\InstagramTransformerTrait;
use Vinelab\Editor\Transformers\Traits\JavascriptTransformerTrait;

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
    use InstagramTransformerTrait;
    use JavascriptTransformerTrait;

    /**
     * Hold the content text and embeds.
     *
     * @var array
     */
    protected $content = [];

    /**
     * The original content as entered in the editor,
     * passed through a bit of filtering.
     *
     * @var string
     */
    protected $original = '';

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
        $html = Markdown::defaultTransform($this->stripUnwanted($markdown));

        // Javascript is a BIG NO! We start by stripping them bcz they're not allowed.
        $html = $this->transformJavascript($html);
        $markdown = $this->transformJavascript($this->stripUnwanted($markdown));

        $this->setOriginalContent($markdown);

        // Set the original content as HTML and Transformed initially.
        $this->setHTMLContent($html);
        $this->setTransformedContent($markdown);

        // Perform transformations
        $transformed = $this->transformFacebook($markdown);
        $transformed = $this->transformTwitter($markdown);
        $transformed = $this->transformYoutube($markdown);
        $transformed = $this->transformInstagram($markdown);
        $transformed = $this->transformLinks($transformed);
        // N.B. Keep HTML transformation till last in case the previous
        // transformations deal with html since all the tags will be stripped at this point.
        $this->transformHTML($transformed);
    }

    public function text()
    {
        return $this->transformed();
    }

    /**
     * Remove all unwanted tags and content. This is not related to any specific
     * service and better be done at the beginnig before performing any transformations
     * on the text since it will make destructive changes to indices and line numbers.
     *
     * @param  string $content
     *
     * @return string
     */
    public function stripUnwanted($content)
    {
        $content = preg_replace('/<div id="fb-root">(.*?)<\/div>/is', '', $content);

        return $content;
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
                'instagram' => $this->instagram()->toArray(),
                'youtube'  => $this->youtube()->toArray(),
                'links'    => $this->links()->toArray(),
            ]
        ];
        return (array) $this->content;
    }

    /**
     * Get the original markdown representation
     * of the content.
     *
     * @return string
     */
    public function markdown()
    {
        return $this->original;
    }

    /**
     * Set the original content.
     *
     * @param string $content
     */
    protected function setOriginalContent($content)
    {
        $this->original = $content;
    }
}
