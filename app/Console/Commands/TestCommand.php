<?php

namespace App\Console\Commands;

use App\Exceptions\ServiceException;
use App\Models\Test;
use App\Models\User;
use App\Services\HolidayApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

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
        $r = HolidayApiService::singleton()->dayInfo('20220501');
        dump($r);
        die;
        User::query()->whereLike('name', 'a')->get();
        die;
        $key = 'abcd';
        $attempt = RateLimiter::attempt($key, 1, function () {

        }, 86400);
        if (!$attempt) {
            throw new ServiceException('too many attempts');
        }
        return self::SUCCESS;
    }
}
