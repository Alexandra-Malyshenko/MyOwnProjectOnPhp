<?php

use App\Repository\CartRepository;
use App\Tools\Authentication;

$auth = new Authentication(__DIR__ . '/../../storage/php-session/');
$cart = new CartRepository(__DIR__ . '/../../storage/php-session/');
$productsFromSession = $cart->getProductsFromSession();
/**
 * @var $header string
 * @var $main string
 * @var $footer string
 * @var $params array
 */
$categoryList = $params[0];
$products = $params[1];
$totalPrice = $params[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lovely Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/mainPage.css">
    <link rel="icon" href="data:,">
</head>
<body>
<div class="container-fluid">
    <?php include dirname(__DIR__) . '/templates/headerTemplate.php'; ?>

    <div class="container mt-5 d-flex justify-content-end">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Корзина</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr class="hr-shelf mb-5">
    <div class="container mb-5 pb-5 mt-5 pt-5">
        <?php if (empty($products)):?>
        <div class="row mb-5 pb-4 mt-5 pt-4" >
            <div class="col-lg-12 col-md-12 col-sm-12" align="center">
                <h5 class="pb-3">Ваша корзина пуста</h5>
                <button type="btn button" class="btn btn-info"><a href="/" style="text-decoration: none; color: white">Начать покупки</a></button>
            </div>
        </div>
        <?php else: ?>
        <div class="row mt-2 d-flex justify-content-center">
            <div class="col-lg-9 col-md-9 col-sm-12 ">
                <h5 class="pb-3">Ваша корзина: </h5>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Номер товара</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <th scope="row"><?php echo $product->getId();?></th>
                        <td><a style="text-decoration: none; color: black;" href="/product/<?php echo $product->getId(); ?>" ><?php echo $product->getTitle();?></a></td>
                        <td><?php echo $productsFromSession[$product->getId()]?></td>
                        <td><?php echo $product->getPrice();?> грн.</td>
                        <td><a style="text-decoration: none; color: black;" href="/cart/delete/<?php echo $product->getId(); ?>"> Удалить </a></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3">Итоговая сумма: </td>
                        <td><?php echo $totalPrice?> грн.</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between pt-3">
                    <button type="button" class="btn btn-info"><a href="/" style="text-decoration: none; color: white">Продолжить покупки</a></button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Оформить заказ</button>

                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <?php echo $footer; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>