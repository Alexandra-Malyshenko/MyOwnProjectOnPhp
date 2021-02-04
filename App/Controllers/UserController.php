<?php

use App\Tools\Authentication;
use App\tools\TemplateMaker;
use App\Repository\CategoryRepository;
use App\tools\Errors\UsersValidationException;

class UserController
{
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    public function __construct()
    {
        $this->authentication = new Authentication('');
    }

    public function actionRegister()
    {
        if (!empty($_POST)) {
            $this->actionPostRegister();
        }
        $render = new TemplateMaker();
        $categoryRepository = new CategoryRepository();
        $render->render('registerTemplate', 'mainPage', $categoryRepository->getCategoryList());
    }

    public function actionLogin($params)
    {
        if (!empty($_POST)) {
            $this->actionPost();
        }
        $categoryRepository = new CategoryRepository();
        $render = new TemplateMaker();
        $render->render('loginTemplate', 'mainPage', $categoryRepository->getCategoryList());
    }

    public function actionLogout()
    {
        $this->authentication->logOut();
        header("Location: /");
    }

    public function actionPost()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        if (!empty($name) && !empty($password)) {
            $this->authentication->auth($name, $password);
            header("Location: /");
        }
    }
    public function actionPostRegister()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_again = $_POST['password_again'];
        if ($password == $password_again) {
            $authentication = new Authentication('');
            $param = $authentication->register($name, $email, $password);
            $authentication->auth($param[0], $param[1]);
            header("Location: /");
        } else {
            throw new UsersValidationException('Your password does not match');
        }
    }
}
