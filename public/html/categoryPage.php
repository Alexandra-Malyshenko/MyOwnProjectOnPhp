<?php
/**
 * @var $cakes array
 * @var $header string
 * @var $main string
 * @var $footer string
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lovely Bakery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/categoryPage.css">
</head>
<body>

<?php
echo $header;
echo $main;

?>

    <div class="container pt-5">
        <div class="row">
            <?php foreach ($cakes as $cake): ?>
                <div class="col-lg-4 col-md-4 col-sm-12 pb-5">
                    <div class="card h-100">
                        <img src="<?php echo $cake['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class=""><?php echo $cake['name'] ?></h5>
                            <p class=""> <i><?php echo $cake['description'] ?></i></p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Заказать</button>
                            <button class="btn btn-info"><a href="#">Подробнее</a></button>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>


