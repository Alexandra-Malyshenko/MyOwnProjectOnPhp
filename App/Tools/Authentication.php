<?php

namespace App\Tools;

use App\Tools\Session;
use App\tools\Errors\UsersValidationException;
use App\Services\UserService;

class Authentication
{
    /**
     * @var Session
     */
    private Session $sessionObject;
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(string $path)
    {
        $this->sessionObject = new Session();
        $this->userService = new UserService();
        if ($path == null) {
            $this->sessionObject->setSavePath(__DIR__ . '/../storage/php-session/');
        } else {
            $this->sessionObject->setSavePath($path);
        }
    }

    public function isAuth(): bool
    {
        $this->sessionObject->start();
        return $this->sessionObject->sessionExists();
    }

    public function auth(string $email, string $password): bool
    {
        $userID = $this->userService->checkUserData($email, $password);
        $this->sessionObject->start();
        $this->sessionObject->set('userID', $userID);
        return true;
    }

    public function getLogin(): string
    {
        $this->sessionObject->start();
        $userID = (int) $this->sessionObject->get('userID');
        return $this->userService->getLogin($userID);
    }

    public function logOut(): void
    {
        $this->sessionObject->start();
        if ($this->sessionObject->cookieExists()) {
            setcookie("PHPSESSID", 'false', time() - 1);
            $this->sessionObject->delete('userID');
            $this->sessionObject->destroy();
        }
    }

    public function register(string $name, string $email, string $password, string $city): array
    {
        if ($this->userService->checkUserName($name)) {
            throw new UsersValidationException('This name is already use!');
        } elseif ($this->userService->checkUserEmail($email)) {
            throw new UsersValidationException('This email is already use!');
        }
        if ($this->userService->register($name, $email, $password, $city)) {
            return [$name, $password];
        }
    }
}
