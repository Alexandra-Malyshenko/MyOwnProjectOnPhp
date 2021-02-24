<?php

use App\Services\CartService;
use App\Services\WishListService;
use libs\Authentication;

$auth = new Authentication();
$cart = new CartService(__DIR__ . '/../../storage/php-session/');
$wish = new WishListService();
/**
 * @var $params array
 * @var $header string
 * @var $main string
 * @var $footer string
 */

$categoryList = $params[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lovely Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/categoryPage.css">
    <link rel="icon" href="data:,">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <?php
    include dirname(__DIR__) . '/templates/headerTemplate.php';
    header('Access-Control-Allow-Origin: *');
    /** @var \App\models\Category $category */
    $category = $params[1];

    /** @var array $products */
    $products = $params[2];
    ?>

    <div class="container mt-5 d-flex justify-content-end">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <?php if(empty($category)):?>
                        <li class="breadcrumb-item active" aria-current="page">Вся продукция</li>
                    <?php else: ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $category->getTitle(); ?></li>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>
    </div>
    <hr class="hr-shelf mb-5">

    <div class="container pb-5 pt-4 mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <form method="post" class="d-flex">
                    <input class="form-control form-control-lg" type="search" placeholder="Поиск" name="searchMe" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Поиск</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row" id="productContainer">
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-4 col-sm-12 pb-5">
                    <div class="card h-100">
                        <img src="<?php echo $product->getImage(); ?>" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class=""><?php echo $product->getTitle(); ?></h5>
                            <p>Цена : <b><?php echo $product->getPrice(); ?> грн. / кг</b> </p>
                            <p class=""> <i><?php echo $product->getDescription(); ?></i></p>
                        </div>
                        <div class="card-footer text-center">
                            <a class="add-to-cart" data-id="<?php echo $product->getId(); ?>" href="/cart/add/<?php echo $product->getId(); ?>" style="text-decoration: none">
                                <button class="btn btn-success">Заказать</button>
                            </a>
                            <a href="/product/view/<?php echo $product->getId(); ?>" style="text-decoration: none">
                                <button class="btn btn-info">Подробнее</button>
                            </a>
                            <?php if($auth->isAuth()): ?>
                                <a class="add-to-cart" data-id="<?php echo $product->getId(); ?>" href="/cabinet/viewWishList<?php echo $product->getId(); ?>">
                                    <img src="/images/logo/wish-list.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                                </a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <h5 align="center" style="margin: auto"> Нет результатов :( </h5>
            <?php endif;?>
        </div>
    </div>
    <hr class="hr-shelf mt-5 mb-5">

</div>
<?php
echo $footer;
?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>



