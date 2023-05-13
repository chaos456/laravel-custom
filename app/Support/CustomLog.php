<?php

namespace App\Support;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Carbon\Carbon;

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
        $requestId = Context::singleton()->getUuid();

        $handler = new RotatingFileHandler($logFilePath, 30, Logger::DEBUG);

        if (self::$withRequestId) {
            $format = "[%datetime%] {$requestId} %level_name%: %message% %context% %extra%\n";
        } else {
            $format = "[%datetime%] %level_name%: %message% %context% %extra%\n";
        }

        $handler->setFormatter(new LineFormatter($format, Carbon::DEFAULT_TO_STRING_FORMAT, true, true));

        $logger = new Logger($name);
        $logger->pushHandler($handler);

        return $logger;
    }
}
