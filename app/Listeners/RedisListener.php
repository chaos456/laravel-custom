<?php

namespace App\Listeners;


use App\Constants\CustomLogChannel;
use App\Support\CustomLog;
use Illuminate\Redis\Events\CommandExecuted;

class RedisListener
{

    /**
     * Handle the event.ß
     *
     * @param object $event
     * @return void
     */
    public function handle(CommandExecuted $event)
    {
        if (!config('support.redis_log.enable')) {
            return;
        }

        CustomLog::channel(CustomLogChannel::REDIS)->info(sprintf('[%s][%sms] %s', $event->connectionName, $event->time, $event->command), $event->parameters);
    }
}
