<?php

use App\Services\CartService;
use App\Services\WishListService;
use App\Tools\Authentication;

$auth = new Authentication(__DIR__ . '/../../storage/php-session/');
$cart = new CartService(__DIR__ . '/../../storage/php-session/');
$wish = new WishListService();

/**
 * @var $header string
 * @var $main string
 * @var $footer string
 * @var $params array
 */
$categoryList = $params[0];
$order = $params[1];
$products = $params[2];
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

    <hr class="hr-shelf mt-3 mb-5">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3 class="pb-5">Привет, <?php echo $auth->getLogin(); ?></h3>
            <button type="button" class="btn btn-dark h-50 button-logout"><a class="" href="/user/logout" style="text-decoration: none;
    color: white;">Выйти из аккауна</a></button>
        </div>
        <div class="row mt-2">
            <div class="col-lg-6 ">
                <h5 class="pb-5">Детали заказа номер <?php echo $order->getId();?></h5>
                <p>Адрес доставки : <i><b><?php echo $order->getAddress();?></b></i></p>
                <p>Указанный номер телефона : <i><b><?php echo $order->getContactPhone();?></b></i></p>
                <p>Сумма заказа : <i><b><?php echo $order->getPriceTotal();?> грн.</b></i></p>
                <p>Комментарии : <i><b><?php echo $order->getComments();?></b></i></p>
                <p>Дата покупки : <i><b><?php echo $order->getDate(); ?></b></i></p>
            </div>
            <div class="col-lg-6">
                <h5 class="pb-3" align="center">Заказанные продукты: </h5>
                <table class="table table-hover table-danger">
                    <thead>
                    <tr>
                        <th scope="col">Номер товара</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <th scope="row"><?php echo $product->getId();?></th>
                            <td><?php echo $product->getTitle();?></td>
                            <td><?php echo $product->getPrice();?> грн.</td>
                            <td><?php echo $product->getQuantity();?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                </div>
            <div class="col-lg-12 d-flex justify-content-between pt-3">
                <a href="/cabinet" style="text-decoration: none; color: white"><button type="button" class="btn btn-success" data-dismiss="modal">Вернуться в кабинет</button></a>
                <a href="/" style="text-decoration: none; color: white"><button type="button" class="btn btn-info">Вернуться к покупкам</button></a>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>

