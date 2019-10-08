<?php namespace Hampel\SystemTest;

use Hampel\SystemTest\Commands\CacheTest;
use Hampel\SystemTest\Commands\FileTest;
use Hampel\SystemTest\Commands\LogTest;
use Hampel\SystemTest\Commands\MailTest;
use Hampel\SystemTest\Commands\NotificationTest;
use Hampel\SystemTest\Commands\ScheduleTest;
use Hampel\SystemTest\Commands\UploadTest;
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
	            CacheTest::class,
	            FileTest::class,
	            LogTest::class,
	            MailTest::class,
	            NotificationTest::class,
	            ScheduleTest::class,
	            UploadTest::class,
			]);
	    }
	}
}
