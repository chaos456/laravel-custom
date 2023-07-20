<?php

namespace App\Support\Log;

use Carbon\Carbon;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * 自定义日志类
 */
class CustomLog
{
    protected static array $logChannel;

    protected static string $format = "[%datetime%] %channel% %level_name%: %message% %context% %extra%\n";

    public static function channel(string $name = 'lumen'): Logger
    {
        if (!isset(self::$logChannel[$name])) {
            self::$logChannel[$name] = self::createCustomLogger($name);
        }

        return self::$logChannel[$name];
    }

    protected static function createCustomLogger(string $name): Logger
    {
        $logFilePath = sprintf('%s/%s.log', storage_path('logs'), $name);
        $handler = new RotatingFileHandler($logFilePath, config('logging.channels.daily.days'));

        $handler->setFormatter(new LineFormatter(self::$format, Carbon::DEFAULT_TO_STRING_FORMAT, true, true));

        $logger = new Logger($name);
        $logger->pushHandler($handler);

        $logger->pushProcessor(function ($record) {
            if (LogContext::instance()->getLogId()) {
                $record['extra']['log_id'] = LogContext::instance()->getLogId();
            }

            return $record;
        });

        return $logger;
    }
}
