<?php

use App\Services\CartService;
use App\Services\WishListService;
use libs\Authentication;

$auth = new Authentication();
$cart = new CartService(__DIR__ . '/../../storage/php-session/');
$wish = new WishListService();

/**
 * @var $params array of Product object and Category object
 * @var $header string
 * @var $main string
 * @var $footer string
 */
/** @var \App\Repository\CategoryRepository $categoryList */
$categoryList = $params[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lovely Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/productPage.css">
    <link rel="icon" href="data:,">
</head>
<body>
<div class="container-fluid">
<?php
include dirname(__DIR__) . '/templates/headerTemplate.php';
/** @var \App\models\Category $category */
$category = $params[1];
/** @var \App\models\Product $product */
$product = $params[2];
$comments = $params[3];
$users = $params[4];
?>
<div class="container mt-5 d-flex justify-content-end">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item"><a href="/category/getCategory/<?php echo $category->getId()?>"><?php echo $category->getTitle(); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $product->getTitle(); ?></li>
            </ol>
        </nav>
    </div>
</div>

<hr class="hr-shelf mb-5">
<div class="container pt-5 d-flex justify-content-center">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12"><img src="<?php echo $product->getImage(); ?>" class="card-img-top" alt="..."></div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <h2 class=" pb-3"><?php echo $product->getTitle(); ?></h2>
            <p class="price"><?php echo $product->getPrice(); ?> грн/кг</p>
            <a class="add-to-cart" data-id="<?php echo $product->getId(); ?>" href="/cart/add/<?php echo $product->getId(); ?>" style="text-decoration: none; color: white">
                <button class="btn btn-success">Заказать</button>
            </a>
            <?php if($auth->isAuth()): ?>
            <a class="add-to-cart" data-id="<?php echo $product->getId(); ?>" href="/cabinet/viewWishList/<?php echo $product->getId(); ?>">
                <img src="/images/logo/wish-list.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            </a>
            <?php endif; ?>
            <p class="pt-5 pb-5 "> <i><?php echo $product->getDescription(); ?></i></p>
        </div>
    </div>
</div>
    <hr class="hr-shelf mt-5 mb-5">
    <h4 align="center">Комментарии</h4>
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php if ($comments):?>
            <table class="table table-borderless" >
                <thead>
                <tr>
                    <th scope="col">Комментарий от пользователя </th>
                    <th scope="col">Дата публикации</th>
                    <th scope="col">Текст комментария</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($comments as $comment): ?>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user->getId() == $comment->getUserId()): ?>
                        <tr>
                            <td><?php echo $user->getName()?></td>
                            <td><?php echo $comment->getDate()?></td>
                            <td><?php echo $comment->getText()?></td>
                        </tr>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endforeach;?>
                </tbody>
            </table>
            <?php else: ?>
            <p align="center">Для этого продукта пока нет комметариев</p>
            <?php endif;?>
            <hr class="hr-shelf mt-5 mb-5">
                <?php if($auth->isAuth()): ?>
                <h6 align="center">Написать комментарий</h6>
                <form method="post">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault01">Имя пользователя</label>
                            <input type="text" class="form-control" id="validationDefault01" name="name" value="<?php echo $auth->getLogin(); ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault01">О продукте</label>
                            <input class="form-control" id="validationDefault01" name="productComment" value="<?php echo $product->getTitle(); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault02">Текст комментария</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="text" value="" required></textarea>
                        </div>
                    </div>
                    <button class="btn btn-info" type="submit">Создать</button>
                </form>
                <?php else: ?>
                <p>Для того, что бы написать комментарий сначала нужно авторизоваться</p>
                <a href="/user/login"><button class="btn btn-info">Войти</button></a>
                <?php endif;?>
        </div>
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



