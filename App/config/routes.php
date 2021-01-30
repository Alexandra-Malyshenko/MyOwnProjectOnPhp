<?php

return [
    // category
    'category/([0-9]+)' => 'category/getCategory/$1', // actionGetCategory, CategoryController
    'catalog' => 'category/index', // actionIndex, CategoryController

     // product
    'product/([0-9]+)' => 'product/view/$1', // actionView, ProductController

    // user
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',

    // about site
    'contacts' => 'site/contact',
    'about' => 'site/about',

    // main page
//    'index.php' => 'site/index', // actionIndex, SiteController
    '' => 'site/index', // actionIndex, SiteController
];
