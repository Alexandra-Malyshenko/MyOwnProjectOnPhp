<?php

use App\Tools\Authentication;
$auth = new Authentication(__DIR__ . '/../../storage/php-session/');

/**
 * @var $header string
 * @var $main string
 * @var $footer string
 * @var $params array
 */
$categoryList = $params;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lovely Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/mainPage.css">
</head>
<body>
    <?php include dirname(__DIR__) . '/templates/headerTemplate.php'; ?>

    <hr class="hr-shelf mt-3 mb-5">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3 class="pb-5">Привет, <?php echo $auth->getLogin(); ?></h3>
            <button type="button" class="btn btn-dark h-50 button-logout"><a class="" href="/logout" style="text-decoration: none;
    color: white;">Выйти из аккауна</a></button>
        </div>
        <div class="row mt-2 d-flex justify-content-center">
            <div class="col-lg-9 col-md-9 col-sm-12 ">
                <h5 class="pb-3">Ваша корзина: </h5>
                <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Торт шоколадный</td>
                        <td>1</td>
                        <td>490 грн/кг</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Хлеб бородинский</td>
                        <td>2</td>
                        <td>25 грн/шт</td>
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between pt-3">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Продолжить покупки</button>
                    <button type="button" class="btn btn-success">Оформить заказ</button>
                </div>
            </div>

        </div>
    </div>
    <?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
