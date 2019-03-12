<?php namespace Hampel\MailTest;

use Hampel\MailTest\Commands\MailTest;
use Illuminate\Support\ServiceProvider;

class MailTestServiceProvider extends ServiceProvider {

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
