<?php namespace Hampel\SystemTest;

use Hampel\SystemTest\Commands\MailTest;
use Illuminate\Support\ServiceProvider;

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
	        ]);
	    }
	}
}
