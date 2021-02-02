<!-- Header html code-->
<header>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/images/logo/logo2.jpg" width="50" height="50" class="d-inline-block align-top" alt="" loading="lazy">
            Lovely Bakery
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#about">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#question">Вопросы</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Каталог
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/catalog">Вся продукция</a>
                        <?php foreach ($categoryList as $category):?>
                            <a class="dropdown-item" href=<?php echo "/category/" . $category->getID(); ?> ><?php echo $category->getName(); ?></a>
                        <?php endforeach;?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <?php if($auth->isAuth()): ?>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Привет, <?php echo $auth->getLogin(); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/cabinet">Перейти в кабинет</a>
                            <a class="dropdown-item" href="/logout">Выйти</a>
                        </div>
                    <?php else: ?>
                        <a class="nav-link" href="/login">Войти</a>
                    <?php endif ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" type="button" data-toggle="modal" data-target="#exampleModal" href="#">
                        Корзина
                        <img src="/images/logo/shopping-cart.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    </a>
                    <div class="fade modal-castom" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ваша корзина</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Продолжить покупки</button>
                                    <button type="button" class="btn btn-info"><a href="/cabinet" style="text-decoration: none; color: white">Оформить заказ</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- End header-->