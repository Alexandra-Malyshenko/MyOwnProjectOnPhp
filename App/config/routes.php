
[
    // category
    'category/getCategory/([0-9]+)' => 'category/getCategory/$1', // getCategory, CategoryController
    'category' => 'category/index', // index, CategoryController

    // product
    'product/view/([0-9]+)' => 'product/view/$1', // view, ProductController

    // user
    'user/register' => 'user/register', // register, UserController
    'user/login' => 'user/login', // login, UserController
    'user/logout' => 'user/logout', // logout, UserController

    // cabinet
    'cabinet/getOrder/([0-9]+)' => 'cabinet/getOrder/$1', // getOrder, CabinetController
    'cabinet/addWish/([0-9]+)' => 'cabinet/addWish/$1', // addWishList, CabinetController
    'cabinet/deleteWish/([0-9]+)' => 'cabinet/deleteWish/$1', // addWishList, CabinetController
    'cabinet/viewWishList' => 'cabinet/viewWishList', // viewWishList, CabinetController
    'cabinet/getComment/([0-9]+)' => 'cabinet/getComment/$1', // getComment, CabinetController
    'cabinet/deleteComment/([0-9]+)' => 'cabinet/deleteComment/$1', // createComment, CabinetController
    'cabinet/viewComments' => 'cabinet/viewComments', // viewComments, CabinetController
    'cabinet' => 'cabinet/index', // index, CabinetController

    // cart
    'cart/add/([0-9]+)' => 'cart/add/$1', // add, CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // add, CartController
    'cart/checkout' => 'cart/checkout', // checkout, CartController
    'cart' => 'cart/index', // index, CartController


    // main page
    '' => 'site/index', // index, SiteController
];