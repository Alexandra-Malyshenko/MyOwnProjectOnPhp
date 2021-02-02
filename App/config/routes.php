<?php

return [
    // category
    'category/([0-9]+)' => 'category/getCategory/$1', // actionGetCategory, CategoryController
    'catalog' => 'category/index', // actionIndex, CategoryController

     // product
    'product/([0-9]+)' => 'product/view/$1', // actionView, ProductController

    // user
    'register' => 'user/register', // actionRegister, UserController
    'login' => 'user/login', // actionLogin, UserController
    'logout' => 'user/logout', // actionLogout, UserController
    'cabinet' => 'cabinet/index',

    // main page
//    'index.php' => 'site/index', // actionIndex, SiteController
    '' => 'site/index', // actionIndex, SiteController
];
