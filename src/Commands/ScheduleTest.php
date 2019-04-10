<?php namespace Hampel\SystemTest\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScheduleTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:schedule';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show a list of all scheduled tasks';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(Schedule $schedule)
	{
		$events = $schedule->events();

		if (!empty($events))
		{
			$this->line('');
			$format = 'd-M-Y h:i A T';
			$this->comment("The time is now: " . Carbon::now(config('app.timezone'))->format($format));
			$this->line('');

			$this->line('Scheduled Tasks:');
			$this->line('');

			$table = [];
			foreach ($events as $event)
			{
				$name = is_string($event->description) ? $event->description : 'Closure';
				$date = $event->nextRunDate()->format($format);
				$table[] = compact('name', 'date');
			}

			$this->table(['Description', 'Next Run Time'], $table);
			$this->line('');
		}
		else
		{
			$this->info('No scheduled tasks found');
		}
	}
}
