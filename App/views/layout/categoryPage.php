<?php

use App\Services\CartService;
use App\Services\WishListService;
use App\Tools\Authentication;

$auth = new Authentication(__DIR__ . '/../../storage/php-session/');
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
</head>
<body>
<div class="container-fluid">
<?php
include dirname(__DIR__) . '/templates/headerTemplate.php';

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

    <div class="container pt-5">
        <div class="row">
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
        </div>
    </div>
    <hr class="hr-shelf mt-5 mb-5">
    <?php
    echo $footer;
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>


