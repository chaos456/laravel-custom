<?php

namespace App\Console\Commands;

use App\Constants\RedisKey;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.a
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $key = sprintf(RedisKey::SERIAL, 'a', 1, 'c');

        Redis::connection()->set($key, '123');
        Redis::connection()->get($key);

        return self::SUCCESS;
    }
}
