<?php

namespace App\Providers;

use App\Listeners\RedisListener;
use App\Listeners\SqlListener;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Redis\Events\CommandExecuted;
use Illuminate\Support\Facades\Redis;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        QueryExecuted::class => [
            SqlListener::class
        ],
        CommandExecuted::class => [
            RedisListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (config('support.redis_log.enable')) {
            Redis::enableEvents();
        }
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
