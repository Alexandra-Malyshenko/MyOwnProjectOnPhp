<?php

use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\MailService;
use libs\Authentication;
use libs\TemplateMaker;
use App\tools\Errors\UsersValidationException;
use Monolog\Logger;

class UserController
{
    private Authentication $authentication;
    private TemplateMaker $render;
    private array $categoryList;
    private Logger $logger;

    public function __construct()
    {
        $this->authentication = new Authentication();
        $this->render = new TemplateMaker();
        $this->logger = LoggerService::getLogger();
        $this->categoryList = (new CategoryService())
            ->getAll();
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
                    $this->categoryList
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
                    $this->categoryList
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
            if ($password == $password_again) {
                $params = $this->authentication
                    ->register($name, $email, $password, $city);
                (new MailService())
                    ->sendMessage('register', $params);
                $this->authentication
                    ->auth($params[0], $params[1]);
                header("Location: /");
            } else {
                throw new UsersValidationException('Your password does not match');
            }
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
