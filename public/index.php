<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../vendor/autoload.php';
use libs\Router;

$envName = getenv('APP_ENV') === 'testing' ? '.env.testing' : '.env';
var_dump($envName);
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__), $envName);
$dotenv->load();
var_dump(getenv('APP_ENV'));
var_dump(getenv('DB_NAME'));

try {
    Router::add('^(?P<controller>[a-zA-Z]+)/?(?P<action>[a-zA-Z]+)?/?(?P<id>[0-9]+)?');
    Router::add('', ['controller' => 'Site', 'action' => 'index']);
    Router::run();
} catch (\Throwable $e) {
    echo '<pre>';
    echo $e->getMessage();
    echo '</pre>';
}
