<?php namespace Hampel\SystemTest\Commands;

use Illuminate\Mail\Mailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail {email}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send a test email using the configured mail transport';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(Mailer $mailer, Config $config)
	{
		try
		{
			$name = $config['app.name'];
			$email = $this->argument('email');

			$mailer->raw("This is a test email from {$name} sent to {$email}", function ($message) use ($name, $email) {
				$message->subject("Test from {$name}")->to($email);
			});

			$this->info("Message sent to {$email}");
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
		}
	}
}
