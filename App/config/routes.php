<?php

return [
    // category
    'category/([0-9]+)' => 'category/getCategory/$1', // getCategory, CategoryController
    'catalog' => 'category/index', // index, CategoryController

     // product
    'product/([0-9]+)' => 'product/view/$1', // view, ProductController

    // user
    'register' => 'user/register', // register, UserController
    'login' => 'user/login', // login, UserController
    'logout' => 'user/logout', // logout, UserController
    'cabinet' => 'cabinet/index',

    // cart
    'cart/add/([0-9]+)' => 'cart/add/$1', // add, CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // add, CartController
    'cart' => 'cart/index', // index, CartController

    // main page
    '' => 'site/index', // index, SiteController
];
