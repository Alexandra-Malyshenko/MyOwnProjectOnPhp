<?php

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\MailService;
use App\Services\UserService;
use libs\Authentication;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;
use App\tools\Errors\UsersValidationException;
use Monolog\Logger;

class UserController
{
    private Authentication $authentication;
    private TemplateMaker $render;
    private array $categoryList;
    private Logger $logger;
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->userService = new UserService(new UserRepository($db));
        $this->authentication = new Authentication($session, $this->userService);
        $this->render = new TemplateMaker();
        $this->logger = LoggerService::getLogger();
        $this->categoryList = (new CategoryService(new CategoryRepository($db)))
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
            $params = $this->authentication
                ->register($name, $email, $password, $password_again, $city);
            (new MailService())
                ->sendMessage('register', $params);
            $this->authentication
                ->auth($params[0], $params[1]);
            header("Location: /");
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
