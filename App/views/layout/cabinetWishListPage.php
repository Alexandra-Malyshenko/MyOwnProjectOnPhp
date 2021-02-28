<?php

/**
 * @var $header string
 * @var $main string
 * @var $footer string
 * @var $params array
 */
$categoryList = $params[0];
$wishList = $params[1];
$auth = $params[2];
$cart = $params[3];
$wish = $params[4];
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
            <div class="col-lg-3 col-md-4 col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item disabled" aria-disabled="true">Мой кабинет</li>
                    <li class="list-group-item"><a href="/cabinet" style="text-decoration: none; color: black">История заказов</a></li>
                    <li class="list-group-item active"><a href="/cabinet/viewWishList" style="text-decoration: none; color: white">Список моих хотелок</a></li>
                    <li class="list-group-item"><a href="/cabinet/viewComments" style="text-decoration: none; color:black;">Мои комментарии</a></li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12">
                <?php if ($wishList): ?>
                <h5 class="pb-3" align="center">Список ваших хотелок</h5>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Номер товара</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($wishList as $item => $product): ?>
                        <tr>
                            <th scope="row"><?php echo $wishList[$item]->getId();?></th>
                            <td><a style="text-decoration: none; color: black;" href="/product/view/<?php echo $wishList[$item]->getId(); ?>" ><?php echo $wishList[$item]->getTitle();?></a></td>
                            <td><?php echo $wishList[$item]->getPrice();?> грн.</td>
                            <td scope="col">
                                <a href="/cart/add/<?php echo $wishList[$item]->getId();?>" style="text-decoration: none; color: black">
                                    <img src="/images/logo/shopping-cart.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
<!--                                    <button class="btn btn-warning">Добавить в корзину</button>-->
                                </a>
                            </td>
                            <td scope="col">
                                <a href="/cabinet/deleteWish/<?php echo $item; ?>" style="text-decoration: none; color: black">
                                    <img src="/images/logo/delete.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
<!--                                    <button class="btn btn-danger">Удалить</button>-->
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <h5 class="pb-3" align="center">У вас пока нет хотелок :) </h5>
                <?php endif;?>
            </div>

        </div>
    </div>
    <?php echo $footer; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
