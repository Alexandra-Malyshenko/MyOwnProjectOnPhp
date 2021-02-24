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
                        <a class="dropdown-item" href="/category">Вся продукция</a>
                        <?php foreach ($categoryList as $category):?>
                            <a class="dropdown-item" href=<?php echo "/category/getCategory/" . $category->getID(); ?> ><?php echo $category->getTitle(); ?></a>
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
                            <a class="dropdown-item" href="/user/logout">Выйти</a>
                        </div>
                    <?php else: ?>
                        <a class="nav-link" href="/user/login">Войти</a>
                    <?php endif ?>
                </li>
                <?php if($auth->isAuth()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/cabinet/viewWishList">
                        <img src="/images/logo/wish-list.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                        <span id="cart-count">(<?php echo $wish->count($auth->getUser()->getId()); ?>)</span>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">
                        Корзина
                        <span id="cart-count">(<?php echo $cart->countItems(); ?>)</span>
                        <img src="/images/logo/shopping-cart.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/search">
                        <img src="/images/logo/lupa.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    </a>
                </li>
            </ul>

        </div>
    </nav>
</header>
<!-- End header-->