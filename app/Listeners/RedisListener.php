<?php

namespace App\Listeners;


use App\Enums\LogChannelEnum;
use App\Support\Log\CustomLog;
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

        CustomLog::channel(LogChannelEnum::REDIS)->info(sprintf('[%s][%sms] %s', $event->connectionName, $event->time, $event->command), $event->parameters);
    }
}
