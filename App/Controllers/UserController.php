<?php

use App\Services\CategoryService;
use App\Services\MailService;
use libs\Authentication;
use libs\TemplateMaker;
use App\tools\Errors\UsersValidationException;

class UserController
{
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    public function __construct()
    {
        $this->authentication = new Authentication();
    }

    public function register()
    {
        if (!empty($_POST)) {
            $this->postRegister();
        }
        $render = new TemplateMaker();
        $render->render('registerTemplate', 'mainPage', (new CategoryService())->getAll());
    }

    public function login()
    {
        if (!empty($_POST)) {
            $this->post();
        }
        $render = new TemplateMaker();
        $render->render('loginTemplate', 'mainPage', (new CategoryService())->getAll());
    }

    public function logout()
    {
        $this->authentication->logOut();
        header("Location: /");
    }

    public function post()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        if (!empty($name) && !empty($password)) {
            $this->authentication->auth($name, $password);
            header("Location: /");
        }
    }
    public function postRegister()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_again = $_POST['password_again'];
        $city = $_POST['city'];
        if ($password == $password_again) {
            $authentication = new Authentication();
            $params = $authentication->register($name, $email, $password, $city);
            (new MailService())->sendMessage('register', $params);
            $authentication->auth($params[0], $params[1]);
            header("Location: /");
        } else {
            throw new UsersValidationException('Your password does not match');
        }
    }
}
