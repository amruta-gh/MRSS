<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Parse\ParseClient;
use Config;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//session_start();
		ParseClient::initialize(Config::get('app.Parse.ApplicationID'), Config::get('app.Parse.RESTAPIKEy'), Config::get('app.Parse.MasterKey'));
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
