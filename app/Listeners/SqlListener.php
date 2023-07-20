<?php

namespace App\Listeners;


use App\Enums\LogChannelEnum;
use App\Support\Log\CustomLog;
use Illuminate\Database\Events\QueryExecuted;

class SqlListener
{

    /**
     * Handle the event.ß
     *
     * @param object $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if (!config('support.sql_log.enable')) {
            return;
        }

        $i = 0;
        $rawSql = preg_replace_callback('/\?/', function ($matches) use ($event, &$i) {
            $item = $event->bindings[$i] ?? $matches[0];
            $i++;
            return is_string($item) ? "'$item'" : $item;
        }, $event->sql);

        CustomLog::channel(LogChannelEnum::SQL)->info(sprintf('[%s][%sms] %s',$event->connectionName, $event->time, $rawSql));
    }
}
