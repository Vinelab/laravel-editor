# Markdown Editor

A sophisticated markdown editor supporting different kinds of embeds (Facebook, Twitter, Youtube, Images, Links)
and transforms content into a clean JSON to be delivered to mobile devices or custom front-end UI.

## Installation

- Add the package to your `composer.json` and run `composer update`.

```json
{
    "require": {
        "vinelab/laravel-editor": "*"
    }
}
```

- Add the service provider to the `providers` array in `app/config/app.php`

```php
'Vinelab\Editor\EditorServiceProvider',
```

- Publish the assets by running `php artisan asset:publish vinelab/laravel-editor` at the root of your project.

- Access the editor with the `Editor` facade

## Dependencies

- [jQuery](http://jquery.com)
    - `<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>`
- [Bootstrap](http://getbootstrap.com)
    - `<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>`
    - `<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">`

- [Mr.Uploader](http://github.com/vinelab/mr-uploader): To have the photo cropping and upload working you need to add

### Social Media Embeds
To have all the embeds working in the preview you will need to add the social media scripts to your HTML.

#### Facebook

```html
<script>
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '[YOU APP ID HERE]',
          xfbml      : true,
          version    : 'v2.1'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
```

#### Twitter

```html
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
```

#### Instagram

```html
<script async src="//platform.instagram.com/en_US/embeds.js"></script>
```

## Usage

### Displaying the Editor

To display the editor you simply need to call `Editor::view()`

#### Example with a Form

```php
{{ Form::open(['url' => 'handle', 'method' => 'POST']) }}
    {{ Editor::view() }}
    {{ Form::submit() }}
{{ Form::close() }}
```

### Retrieving Content

To get the content from the input use `Editor::input()` to get the editor's input name and use it with `Input`
as such

```php
$input = Input::get(Editor::input());
```

Then pass it to `Editor::content($input)` for the raw content or `Editor::json($input)` for the *JSON* representation
of the output.

### Raw Content

```php
$content = Editor::content($input);
// $content is an instance of Vinelab\Editor\Content

```

The text used in the editor for this example is the following:

```
[Oxford Town](http://dylan.town)
<div class="fb-post" data-href="https://www.facebook.com/FacebookDevelopers/posts/10151471074398553" data-width="500"></div>

<div class='fb-post' data-href='https://www.facebook.com/FacebookDevelopers/posts/212625821854109664' data-width='500'></div>

<blockquote class="twitter-tweet" lang="en"><p>Sunsets don&#39;t get much better than this one over <a href="https://twitter.com/GrandTetonNPS">@GrandTetonNPS</a>. <a href="https://twitter.com/hashtag/nature?src=hash">#nature</a> <a href="https://twitter.com/hashtag/sunset?src=hash">#sunset</a> <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Dept of Interior (@Interior) <a href="https://twitter.com/Interior/status/463440424141459456">May 5, 2014</a></blockquote>

<iframe width="560" height="315" src="//www.youtube.com/embed/sOOebk_dKFo" frameborder="0" allowfullscreen></iframe>
```

#### JSON

> Lines are all 0 indexed

```php
$json = $content->toJson();
```

```json
{
    "text": "The text in here",
    "html": "<p>The text in here</p>",
    "embeds": {
        "facebook": [
            {
                "url": "https://www.facebook.com/FacebookDevelopers/posts/10151471074398553",
                "html": "<div class=\"fb-post\" data-href=\"https://www.facebook.com/FacebookDevelopers/posts/10151471074398553\" data-width=\"500\"></div>",
                "line": 1
            },
            {
                "url": "https://www.facebook.com/FacebookDevelopers/posts/212625821854109664",
                "html": "<div class='fb-post' data-href='https://www.facebook.com/FacebookDevelopers/posts/212625821854109664' data-width='500'></div>",
                "line": 3
            }
        ],
        "twitter": [
            {
                "tweet": "<p>Sunsets don't get much better than this one over <a href=\"https://twitter.com/GrandTetonNPS\">@GrandTetonNPS</a>. <a href=\"https://twitter.com/hashtag/nature?src=hash\">#nature</a> <a href=\"https://twitter.com/hashtag/sunset?src=hash\">#sunset</a> <a href=\"http://t.co/YuKy2rcjyU\">pic.twitter.com/YuKy2rcjyU</a></p>— US Dept of Interior (@Interior) <a href=\"https://twitter.com/Interior/status/463440424141459456\">May 5, 2014</a>",
                "lang": "en",
                "html": "<blockquote class=\"twitter-tweet\" lang=\"en\"><p>Sunsets don&#39;t get much better than this one over <a href=\"https://twitter.com/GrandTetonNPS\">@GrandTetonNPS</a>. <a href=\"https://twitter.com/hashtag/nature?src=hash\">#nature</a> <a href=\"https://twitter.com/hashtag/sunset?src=hash\">#sunset</a> <a href=\"http://t.co/YuKy2rcjyU\">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Dept of Interior (@Interior) <a href=\"https://twitter.com/Interior/status/463440424141459456\">May 5, 2014</a></blockquote>",
                "line": 5
            }
        ],
        "youtube": [
            {
                "id": "sOOebk_dKFo",
                "url": "https://www.youtube.com/embed/sOOebk_dKFo",
                "html": "<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/sOOebk_dKFo\" frameborder=\"0\" allowfullscreen></iframe>",
                "line": 7
            }
        ],
        "links": [
            {
                "url": "http://dylan.town",
                "text": "Oxford Town",
                "html": "<a href=\"http://dylan.town\">Oxford Town</a>",
                "indices": [0, 11]
            }
        ]
    }
}
```
