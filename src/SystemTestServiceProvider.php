<?php namespace Hampel\SystemTest;

use Hampel\SystemTest\Commands\CacheTest;
use Hampel\SystemTest\Commands\FileTest;
use Hampel\SystemTest\Commands\LogTest;
use Hampel\SystemTest\Commands\MailTest;
use Hampel\SystemTest\Commands\NotificationTest;
use Hampel\SystemTest\Commands\ScheduleTest;
use Hampel\SystemTest\Commands\UploadTest;
use Illuminate\Foundation\Console\AboutCommand;
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

            // About command was added in Laravel 9.21.0, so only invoke it if we're running a later version
            if (version_compare($this->app->version(), '9.21.0', '>='))
            {
                AboutCommand::add('SystemTest', fn() => ['Active' => 'true']);
            }
	    }
	}
}
