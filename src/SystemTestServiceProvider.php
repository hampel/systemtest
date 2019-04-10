<?php namespace Hampel\SystemTest;

use Illuminate\Support\ServiceProvider;
use Hampel\SystemTest\Commands\LogTest;
use Hampel\SystemTest\Commands\FileTest;
use Hampel\SystemTest\Commands\MailTest;
use Hampel\SystemTest\Commands\CacheTest;
use Hampel\SystemTest\Commands\ScheduleTest;

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
	            LogTest::class,
	            MailTest::class,
	            FileTest::class,
	            CacheTest::class,
	            ScheduleTest::class
			]);
	    }
	}
}
