<?php

use App\Services\LoggerService;
use libs\Database;
use Psr\Container\ContainerInterface;

use function DI\factory;

return [
    'Database' => \DI\factory(function () {
        return Database::getInstance()->getConnection();
    }),
    'Session' => \DI\factory(function () {
        return new \libs\Session();
    }),
    'Logger' => \DI\factory(function () {
        return LoggerService::getLogger();
    }),
    'Render' => \DI\factory(function () {
        return new \libs\TemplateMaker();
    }),
    'Authentication' => \DI\factory(function (ContainerInterface $c) {
        return new \libs\Authentication($c->get('Session'), $c->get('UserService'));
    }),
    'UserService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\UserService($c->get('UserRepository'));
    }),
    'ProductService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\ProductService($c->get('ProductRepository'));
    }),
    'CartService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\CartService($c->get('Session'), $c->get('ProductService'));
    }),
    'CategoryService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\CategoryService($c->get('CategoryRepository'));
    }),
    'CommentService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\CommentService($c->get('CommentRepository'), $c->get('ProductService'));
    }),
    'MailService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\MailService($c->get('OrderService'));
    }),
    'OrderService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\OrderService($c->get('OrderRepository'), $c->get('UserService'));
    }),
    'SearchService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\SearchService($c->get('ProductService'));
    }),
    'WishListService' => \DI\factory(function (ContainerInterface $c) {
        return new \App\Services\WishListService($c->get('WishListRepository'), $c->get('ProductService'));
    }),
    'UserRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\UserRepository($c->get('Database'));
    }),
    'CategoryRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\CategoryRepository($c->get('Database'));
    }),
    'CommentRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\CommentRepository($c->get('Database'));
    }),
    'OrderRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\OrderRepository($c->get('Database'));
    }),
    'ProductRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\ProductRepository($c->get('Database'));
    }),
    'WishListRepository' => DI\factory(function (ContainerInterface $c) {
        return new \App\Repository\WishListRepository($c->get('Database'));
    }),

];
