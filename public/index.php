<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../vendor/autoload.php';
use libs\Router;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

try {
    Router::add('^(?P<controller>[a-zA-Z]+)/?(?P<action>[a-zA-Z]+)?/?(?P<id>[0-9]+)?');
    Router::add('', ['controller' => 'Site', 'action' => 'index']);
    Router::run();
} catch (\Throwable $e) {
    echo '<pre>';
    echo $e->getMessage();
    echo '</pre>';
}
