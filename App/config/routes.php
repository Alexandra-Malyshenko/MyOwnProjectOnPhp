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

    // cabinet
    'cabinet/order/([0-9]+)' => 'cabinet/getOrder/$1', // getOrder, CabinetController
    'cabinet/wishList/([0-9]+)' => 'cabinet/addWish/$1', // addWishList, CabinetController
    'cabinet/wishList/delete/([0-9]+)' => 'cabinet/deleteWish/$1', // addWishList, CabinetController
    'cabinet/wishList' => 'cabinet/viewWishList', // viewWishList, CabinetController
    'cabinet/comments/([0-9]+)' => 'cabinet/getComment/$1', // getComment, CabinetController
    'cabinet/comments/delete/([0-9]+)' => 'cabinet/deleteComment/$1', // createComment, CabinetController
    'cabinet/comments' => 'cabinet/viewComments', // viewComments, CabinetController
    'cabinet' => 'cabinet/index', // index, CabinetController

    // cart
    'cart/add/([0-9]+)' => 'cart/add/$1', // add, CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // add, CartController
    'cart/checkout' => 'cart/checkout', // checkout, CartController
    'cart' => 'cart/index', // index, CartController


    // main page
    '' => 'site/index', // index, SiteController
];
