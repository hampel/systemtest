<?php namespace Hampel\SystemTest\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\FilesystemManager;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class UploadTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:upload {--disk=default} {file}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test write/upload speed to the specified disk';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(FilesystemManager $filesystem, Filesystem $files, Config $config)
	{
		$file = $this->argument('file');

		$diskName = $this->option('disk');
		$disk = ($diskName == 'default') ? null : $diskName;
		$diskName = ($diskName == 'default') ? $config->get('filesystems.default') : $diskName;

		try
		{
			$start = microtime(true);
			$path = $filesystem->disk($disk)->putFile('', new \Illuminate\Http\File($file));
			$time = microtime(true) - $start;
			$size = $files->size($file);
			$size_human = $this->human_filesize($size);
			$destination = "{$diskName}::[{$path}]";

			$speed_human = '';
			if ($time > 0)
			{
				$speed = intval(round($size / $time));
				$speed_human = " (" . $this->human_filesize($speed) . "/s)";
			}
			$this->info("Successfully stored {$size_human} file to disk {$destination} in " . number_format($time, 2) . " seconds{$speed_human}");
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
			return;
		}

		try
		{
			if (!$filesystem->disk($disk)->delete($path))
			{
				$this->info("Uploaded file could not be removed from disk {$destination} - please remove manually");
				return;
			}

			$this->info("Uploaded file has been removed");
		}
		catch (\Exception $e)
		{
			$this->info("Uploaded file could not be removed - please remove manually: {$destination}");
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""), OutputInterface::VERBOSITY_VERBOSE);
			return;
		}
	}

	function human_filesize($bytes, $dec = 2)
	{
	    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	    $factor = floor((strlen($bytes) - 1) / 3);

	    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

}
