<?php

/**
 * @var $params array
 * @var $header string
 * @var $main string
 * @var $footer string
 */

$categoryList = $params[0];
$category = $params[1];
$pagination = $params[2];
$sort = $params[3];
$auth = $params[4];
$cart = $params[5];
$wish = $params[6];
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
header('Access-Control-Allow-Origin: *');
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

    <div class="container pt-3">
        <div class="row pb-5">
            <div class="col-lg-12 d-flex justify-content-end">
                <div class="dropdown">
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownSort' aria-haspopup='true' data-bs-toggle='dropdown' aria-expanded='false'>
                        Сортировать
                    </button>
                    <?php echo $sort;?>
                </div>
            </div>
        </div>
        <div class="row" id="productContainer"></div>
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <?php echo $pagination;?>
                </nav>
            </div>
        </div>
    </div>
    <hr class="hr-shelf mt-5 mb-5">

    </div>
    <?php
    echo $footer;
    ?>
</div>
<script src="/js/renderCategoryPage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>


