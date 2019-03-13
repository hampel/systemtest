<?php namespace Hampel\SystemTest\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FileTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:file {--disk=default}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Lists files available on the specified disk';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(FilesystemManager $file)
	{
		try
		{
			$disk = $this->option('disk');

			$this->info("All files on {$disk} disk:");

			collect($file->disk($disk == 'default' ? null : $disk)->allFiles())->each(function($file) {
				$this->line($file);
			});
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
		}
	}
}
