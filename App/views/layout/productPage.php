<?php

use App\Tools\Authentication;

$auth = new Authentication(__DIR__ . '/../../storage/php-session/');

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
?>
<div class="container mt-5 d-flex justify-content-end">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item"><a href="/category/<?php echo $category->getId()?>"><?php echo $category->getTitle(); ?></a></li>
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
            <button class="btn btn-success">Заказать</button>
            <p class="pt-5 pb-5 "> <i><?php echo $product->getDescription(); ?></i></p>
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



