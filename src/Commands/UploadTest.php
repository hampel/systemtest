<?php namespace Hampel\SystemTest\Commands;

use File;
use Storage;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
	public function handle(FilesystemManager $filesystem)
	{
		$file = $this->argument('file');

		try
		{
			$diskName = $this->option('disk');
			$disk = ($diskName == 'default') ? null : $diskName;

			$start = microtime(true);
			$path = Storage::disk($disk)->putFile('', new \Illuminate\Http\File($file));
			$time = microtime(true) - $start;
			$size = File::size($file);
			$size_human = $this->human_filesize($size);

			$speed_human = '';
			if ($time > 0)
			{
				$speed = intval(round($size / $time));
				$speed_human = " (" . $this->human_filesize($speed) . "/s)";
			}
			$this->info("Successfully stored {$size_human} file to [{$diskName}] in " . number_format($time, 2) . " seconds{$speed_human}");

			Storage::disk($disk)->delete($path);
			$this->info("Uploaded file has been removed");
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
		}
	}

	function human_filesize($bytes, $dec = 2)
	{
	    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	    $factor = floor((strlen($bytes) - 1) / 3);

	    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

}
