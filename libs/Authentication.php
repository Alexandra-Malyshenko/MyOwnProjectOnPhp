<?php

namespace libs;

use App\models\User;
use libs\Session;
use App\tools\Errors\UsersValidationException;
use App\Services\UserService;

class Authentication
{
    private Session $sessionObject;
    private UserService $userService;
    private string $sessionKey;

    public function __construct(Session $session, UserService $userService)
    {
        $this->sessionObject = $session;
        $this->userService = $userService;
        $this->sessionKey = 'userID';
        $this->sessionObject->setSavePath(__DIR__ . '/../App/storage/php-session/');
    }

    public function isAuth(): bool
    {
        $this->sessionObject->start();
        if (
            $this->sessionObject
                ->sessionExists()
            &&
            $this->sessionObject
                ->contains($this->sessionKey)
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function auth(string $email, string $password): bool
    {
        $userID = $this->userService
            ->checkUserData($email, $password);
        $this->sessionObject->start();
        $this->sessionObject
            ->set($this->sessionKey, $userID);
        return true;
    }

    public function getLogin(): string
    {
        $this->sessionObject->start();
        $userID = (int) $this->sessionObject
            ->get($this->sessionKey);
        return $this->userService
            ->getLogin($userID);
    }

    public function logOut(): void
    {
        $this->sessionObject->start();
        if (
            $this->sessionObject
            ->cookieExists()
        ) {
            setcookie("PHPSESSID", 'false', time() - 1);
            $this->sessionObject->delete($this->sessionKey);
            $this->sessionObject->destroy();
        }
    }

    public function register(string $name, string $email, string $password, string $password_again, string $city): array
    {
        if (!$this->userService->validationPasswordMatch($password, $password_again)) {
            throw new UsersValidationException('Passwords does not match!');
        } elseif (!$this->userService->validationUserName($name)) {
            throw new UsersValidationException('Not valid user name!');
        } elseif (!!$this->userService->validationUserPassword($password)) {
            throw new UsersValidationException('Password must have more then 8 chars!');
        }
        if ($this->userService->checkUserName($name)) {
            throw new UsersValidationException('This name is already use!');
        } elseif ($this->userService->checkUserEmail($email)) {
            throw new UsersValidationException('This email is already use!');
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        if ($this->userService->register($name, $email, $hash, $city)) {
            return [$name, $password];
        }
    }

    public function getUser(): ?User
    {
        if ($this->isAuth()) {
            $id = $this->sessionObject
                ->get($this->sessionKey);
            return $this->userService
                ->getUser($id);
        } else {
            return null;
        }
    }
}
