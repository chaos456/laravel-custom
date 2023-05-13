<?php

namespace App\Console\Commands;

use App\Constants\CustomLogChannel;
use App\Models\User;
use App\Support\CustomLog;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
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
        CustomLog::channel(CustomLogChannel::SQL)->info('1');
//        User::factory(10)->create();

        return self::SUCCESS;
    }
}
