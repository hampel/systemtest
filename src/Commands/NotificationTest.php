<?php namespace Hampel\SystemTest\Commands;

use Hampel\SystemTest\Notifications\TestNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\Channels\NexmoSmsChannel;
use Illuminate\Notifications\Channels\SlackWebhookChannel;
use Notification;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotificationTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {channel} {destination}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send a test notification';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$channel = $this->argument('channel');

		if ($channel == 'slack' && !class_exists(SlackWebhookChannel::class))
		{
			$this->error("Please install laravel/slack-notification-channel package before using Slack notifications");
			return 1;
		}

		if ($channel == 'nexmo' && !class_exists(NexmoSmsChannel::class))
		{
			$this->error("Please install laravel/nexmo-notification-channel package before using Nexmo SMS notifications");
			return 1;
		}

		$destination = $this->argument('destination');

		try
		{
			Notification::route($channel, $destination)->notifyNow(new TestNotification());
			$this->info("Notification sent via {$channel} to {$destination}");
			return 0;
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
			return 1;
		}
	}
}
