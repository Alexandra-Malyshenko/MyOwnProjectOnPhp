<?php

namespace App\Tools;

use App\models\User;
use App\Tools\Session;
use App\tools\Errors\ProductsErrorException;

class Authentication
{
    private \App\Tools\Session $sessionObject;
    public function __construct(string $path)
    {
        $this->sessionObject = new Session();
        if ($path == null) {
            $this->sessionObject->setSavePath(__DIR__ . '/../storage/php-session/');
        } else {
            $this->sessionObject->setSavePath($path);
        }
    }
    public function getConnection()
    {
        $list =  json_decode(file_get_contents('../App/Models/userList.json'));
        if (!empty($list)) {
            return $list;
        } else {
            $this->logger->warning('There is no data! Try check if there is right path to file');
            throw new ProductsErrorException('There is no data! Try check if there is right path to file');
        }
    }

    public function isAuth(): bool
    {
        $this->sessionObject->start();
        return $this->sessionObject->sessionExists();
    }

    public function auth(string $email, string $password): bool
    {
        $userID = $this->checkUserData($email, $password);
        if ($userID) {
            $this->sessionObject->start();
            $this->sessionObject->set('userID', $userID);
            return true;
        } else {
            return false;
        }
    }

    public function getLogin(): string
    {
        $this->sessionObject->start();
        $userID = (int) $this->sessionObject->get('userID');
        $userList = $this->getConnection();
        foreach ($userList as $user) {
            if ($user->id == $userID) {
                return $user->name;
            }
        }
    }

    public function logOut(): void
    {
        $this->sessionObject->start();
        $this->sessionObject->delete('userID');
        $this->sessionObject->destroy();
    }

    public function register($name, $email, $password): array
    {
        $userList = $this->getConnection();
        $str = '[';
        if ($this->checkName($name)) {
            throw new \Exception('This name is already use!');
        } elseif ($this->checkEmail($email)) {
            throw new \Exception('This email is already use!');
        }
        // register user by creating instance User
        $userRegister = new User();
        $userRegister->setName($name);
        $userRegister->setId(count($userList) + 1);
        $userRegister->setEmail($email);
        $userRegister->setPassword($password);
        // to write in file we need get all object and create them like object User
        if (!empty($userList)) {
            foreach ($userList as $item) {
                $userItem = new User();
                $userItem->setName($item->name);
                $userItem->setId($item->id);
                $userItem->setEmail($item->email);
                $userItem->setPassword($item->password);
                // then write them like string
                $str = $str . $userItem->__toString() . ',';
            }
            // then add our registered user
            $str = $str . $userRegister->__toString() . ']';
        } else {
            $str = $str . $userRegister->__toString() . ']';
        }
        // write in file
        $fl = fopen(__DIR__ . '/../Models/userList.json', 'w+');
        fwrite($fl, $str);
        fclose($fl);
        return [$name, $password];
    }

    public function checkUserData($name, $password): bool
    {
        $userList = $this->getConnection();
        foreach ($userList as $user) {
            if ($user->name == $name && $user->password == $password) {
                return $user->id;
            }
        }
        return false;
    }

    public function checkName($name): bool
    {
        $userList = $this->getConnection();
        foreach ($userList as $user) {
            if ($user->name == $name) {
                return true;
            }
        }
        return false;
    }
    public function checkEmail($email): bool
    {
        $userList = $this->getConnection();
        foreach ($userList as $user) {
            if ($user->email == $email) {
                return true;
            }
        }
        return false;
    }
}
