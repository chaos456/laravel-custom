<?php

namespace App\Support;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Carbon\Carbon;

/**
 * 自定义日志类
 */
class CustomLog
{
    protected static array $logChannel;

    protected static bool $withRequestId = false;

    public static function channel(string $name): Logger
    {
        if (!isset(self::$logChannel[$name])) {
            self::$logChannel[$name] = self::createCustomLogger($name);
        }

        return self::$logChannel[$name];
    }

    public static function setWithRequestId(bool $bool)
    {
        self::$withRequestId = $bool;
    }

    protected static function createCustomLogger(string $name): Logger
    {
        $logFilePath = sprintf('%s/%s.log', storage_path('logs'), $name);
        $handler = new RotatingFileHandler($logFilePath, config('logging.channels.daily.days'));

        $handler->setFormatter(new LineFormatter(null, Carbon::DEFAULT_TO_STRING_FORMAT, true, true));

        $logger = new Logger($name);
        $logger->pushHandler($handler);
        if (self::$withRequestId) {
            $logger->pushProcessor(function ($record) {
                $record['extra']['request_id'] = Context::singleton()->getRequestId();
                return $record;
            });
        }

        return $logger;
    }
}
