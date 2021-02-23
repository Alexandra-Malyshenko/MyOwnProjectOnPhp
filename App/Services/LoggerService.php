<?php

namespace App\Services;

use Monolog\Logger;
use App\TelegramHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class LoggerService
{
    public Logger $logger;

    public static function getLogger(): Logger
    {
        $logger = new Logger("my-logger");
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../storage/log/error.log', Logger::WARNING));
        $handler = new TelegramHandler(
            getenv('TELEGRAM_BOT_TOKEN'),
            (int) getenv('TELEGRAM_BOT_CHAT_ID'),
            Logger::WARNING
        );
        $handler->setFormatter(new LineFormatter("%message%", null, true));
        $logger->pushHandler($handler);
        return $logger;
    }
}