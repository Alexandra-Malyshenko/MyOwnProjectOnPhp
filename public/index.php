<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../vendor/autoload.php';
use Monolog\Logger;
use App\TelegramHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use libs\Router;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

$logger = new Logger("my-logger");
$logger->pushHandler(new StreamHandler(__DIR__ . '/../App/storage/log/error.log', Logger::WARNING));
$handler = new TelegramHandler(
    getenv('TELEGRAM_BOT_TOKEN'),
    (int) getenv('TELEGRAM_BOT_CHAT_ID'),
    Logger::WARNING
);
$handler->setFormatter(new LineFormatter("%message%", null, true));
//$logger->pushHandler($handler);

try {
    Router::add('^(?P<controller>[a-zA-Z]+)/?(?P<action>[a-zA-Z]+)?/?(?P<id>[0-9]+)?');
    Router::add('', ['controller' => 'Site', 'action' => 'index']);
    Router::dispatch();
} catch (\Throwable $e) {
    $logger->warning($e->getMessage());
    echo '<pre>';
    echo $e->getMessage();
    echo '</pre>';
}
