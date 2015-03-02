<?php namespace Vinelab\Editor;

use Blade;
use Illuminate\Support\ServiceProvider;

class EditorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->loadViewsFrom(__DIR__.'/../../views/', 'laravel-editor');

        $this->publishes([
            __DIR__.'/../../views/' => base_path('resources/views/vendor/laravel-editor'),
        ]);

        $this->publishes([
            __DIR__.'/../../../public/' => public_path('vendor/laravel-editor'),
        ], 'public');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Setup the facade alias
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Editor', 'Vinelab\Editor\Facade\Editor');
        });

        $this->app->singleton('vinelab.editor', 'Vinelab\Editor\Editor');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
