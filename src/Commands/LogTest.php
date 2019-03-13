<?php namespace Hampel\SystemTest\Commands;

use Illuminate\Log\LogManager;
use Illuminate\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LogTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:log {--channel=default}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Write test logs to the specified channel';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(LogManager $log)
	{
		try
		{
			$channel = $this->option('channel');

			$levels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];
			foreach ($levels as $level)
			{
				$log->channel($channel == 'default' ? null : $channel)
				    ->log(
				        $level,
				        "This is a test log message",
				        ['channel' => $channel]
				    );
			}

			$this->info("Log messages written - please check your logs for the {$channel} channel");
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
		}
	}
}
