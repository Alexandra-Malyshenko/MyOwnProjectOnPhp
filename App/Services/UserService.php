<?php

namespace App\Services;

use App\models\User;
use App\Repository\UserRepository;
use App\tools\Errors\ProductsErrorException;
use App\tools\Errors\UsersValidationException;

class UserService
{

    private UserRepository $userRepos;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepos = $userRepository;
    }

    public function checkUserData(string $name, string $password): ?int
    {
        $user = $this->userRepos
            ->getByName($name);
        if (!$user) {
            throw new UsersValidationException('Wrong name or password! Try again');
        } elseif (!password_verify($password, $user->getPassword())) {
            throw new UsersValidationException('Wrong name or password! Try again');
        }
        return $user->getId();
    }

    public function checkUserName(string $name): bool
    {
        return $this->userRepos
            ->getByName($name) ? true : false;
    }

    public function validationUserName(string $name): bool
    {
        return preg_match('~^[a-zA-z]+$~', $name) ? true : false;
    }

    public function validationUserPassword(string $password): bool
    {
        return strlen($password) >= 8;
    }

    public function validationPasswordMatch(string $password, string $passwordAgain): bool
    {
        return $password == $passwordAgain;
    }

    public function checkUserEmail(string $email): bool
    {
        return $this->userRepos
            ->getByEmail($email) ? true : false;
    }

    public function getLogin(int $id): string
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id user');
        }
        $user = $this->userRepos
            ->getById($id);
        return $user->getName();
    }

    public function getUser(int $id): User
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id user');
        }
        return $this->userRepos
            ->getById($id);
    }

    public function register(string $name, string $email, string $passwordHash, string $city): bool
    {
        return ($this->userRepos->create($name, $email, $passwordHash, $city));
    }

    public function update(int $id, string $name, string $email, string $password, string $city): bool
    {
        return $this->userRepos
            ->update($id, $name, $email, $password, $city);
    }

    public function delete(int $id): string
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id user');
        }
        return $this->userRepos
            ->delete($id);
    }

    public function getUserByComments(array $comments): array
    {
        $users = [];
        foreach ($comments as $comment) {
            array_push($users, $this->getUser($comment->getUserId()));
        }
        return $users;
    }
}