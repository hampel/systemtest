<?php namespace Hampel\SystemTest;

use Illuminate\Support\ServiceProvider;
use Hampel\SystemTest\Commands\LogTest;
use Hampel\SystemTest\Commands\MailTest;

class SystemTestServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	public function boot()
	{
	    if ($this->app->runningInConsole()) {
	        $this->commands([
	            MailTest::class,
	            LogTest::class,
	        ]);
	    }
	}
}
