
<?php

use App\Services\CartService;
use App\Services\WishListService;
use libs\Authentication;

$auth = new Authentication();
$cart = new CartService(__DIR__ . '/../../storage/php-session/');
$wish = new WishListService();
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
$user = $params[3];
$result = $params[4];
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
                    <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr class="hr-shelf mb-5">
    <?php if ($result):?>
    <div class="mt-5 pt-5 pb-5 mb-5">
        <h3 align="center">Поздравляем! Вы успешно оформили заказ!</h3>
    </div>
    <?php else: ?>
    <div class="container mb-5 pb-5 mt-5 pt-5">
        <div class="row mt-2 d-flex justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 ">
                <h5 class="pb-3">Ваша корзина: </h5>
                <table class="table table-info table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Наименование</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><a style="text-decoration: none; color: black;" href="/product/view/<?php echo $product->getId(); ?>" ><?php echo $product->getTitle();?></a></td>
                            <td><?php echo $productsFromSession[$product->getId()]?></td>
                            <td><?php echo $product->getPrice();?> грн.</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">Итоговая сумма: </td>
                        <td><?php echo $totalPrice?> грн.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 ">
                <h5 class="pb-3"> Данные о заказе: </h5>
                <form method="post" name="checkout">
                    <?php if (!empty($user)): ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault01">Имя</label>
                            <input type="text" class="form-control" id="validationDefault01" name="name" value="<?php echo $user->getName();?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault02">Электронный адрес</label>
                            <input type="email" class="form-control" id="validationDefault02" name="email" value="<?php echo $user->getEmail();?>" required>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault01">Имя</label>
                            <input type="text" class="form-control" id="validationDefault01" name="name" value="" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault02">Электронный адрес</label>
                            <input type="email" class="form-control" id="validationDefault02" name="email" value="" required>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault03">Контактный номер телефона</label>
                            <input type="tel" class="form-control" id="validationDefault03" name="phone" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault05">Адрес доставки</label>
                            <input type="text" class="form-control" id="validationDefault05" name="address" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault03">Комментрарии к заказу</label>
                            <input type="text" class="form-control" id="validationDefault05" name="comments">
                        </div>
                    </div>
                    <div class="pt-3">
                        <button type="submit" class="btn btn-success" data-dismiss="modal">Оформить заказ</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php endif; ?>
    <?php echo $footer; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>