<?php namespace Hampel\SystemTest\Commands;

use Illuminate\Console\Command;
use Illuminate\Cache\CacheManager;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CacheTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cache {--store=default}';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test access to cache using the specified store';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(CacheManager $cache)
	{
		try
		{
			$storeName = $this->option('store');
			$store = $storeName == 'default' ? null : $storeName;
			$key = Str::random();

			if (!$cache->store($store)->add($key, 1))
			{
				$this->error("Could not add cache key {$key}");
			}

			$cache->store($store)->increment($key);
			$val = intval($cache->store($store)->pull($key));
			if ($val !== 2)
			{
				$this->error("Expected cache value for {$key}: [2], received [{$val}]");
			}

			$this->info("Cache store {$storeName} successfully tested");
		}
		catch (\Exception $e)
		{
			$this->error($e->getMessage() . ($e->getCode() ? " [" . $e->getCode() . "]" : ""));
		}
	}
}
