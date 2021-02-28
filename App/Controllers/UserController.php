<?php

use App\Controllers\BaseController;
use App\Services\MailService;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        try {
            if (!empty($_POST)) {
                $this->postRegister();
            }
            $this->render
                ->render(
                    'registerTemplate',
                    'mainPage',
                    $this->categoryService->getAll()
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function login()
    {
        try {
            if (!empty($_POST)) {
                $this->post();
            }
            $this->render
                ->render(
                    'loginTemplate',
                    'mainPage',
                    $this->categoryService->getAll()
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function logout()
    {
        $this->authentication->logOut();
        header("Location: /");
    }

    public function post()
    {
        try {
            $name = $_POST['name'];
            $password = $_POST['password'];
            if (!empty($name) && !empty($password)) {
                $this->authentication
                    ->auth($name, $password);
                header("Location: /");
            }
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
    public function postRegister()
    {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_again = $_POST['password_again'];
            $city = $_POST['city'];
            $params = $this->authentication
                ->register($name, $email, $password, $password_again, $city);
            (new MailService($this->orderService))
                ->sendMessage('register', $params);
            $this->authentication
                ->auth($params[0], $params[1]);
            header("Location: /");
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
