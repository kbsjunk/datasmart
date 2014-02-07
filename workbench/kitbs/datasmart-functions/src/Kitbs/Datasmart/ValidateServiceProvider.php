<?php namespace Kitbs\Datasmart;

use Illuminate\Support\ServiceProvider;

class ValidateServiceProvider extends ServiceProvider {

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
		$this->package('kitbs/datasmart');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// $this->app['validate'] = $this->app->share(function($app)
		// {
		// 	// return new \Kitbs\Datasmart\Validate\Validate;
		// });
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