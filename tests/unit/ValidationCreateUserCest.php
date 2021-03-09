<?php

use App\Repository\UserRepository;
use App\Services\UserService;

class ValidationCreateUserCest
{
    private UserService $userService;

    public function _before(UnitTester $I, libs\Database $database)
    {
        $this->db = new $database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->userService = new UserService(new UserRepository($this->db));
    }

    public function tryToTestUserCreation(UnitTester $I)
    {
        $name = 'Emily';
        $email = 'emily@email.com';
        $password = 'Testmeonce';
        $city = 'Lviv';
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->userService->register($name, $email, $hash, $city);

        $I->seeInDataBase('users', ['name' => $name, 'email' => $email, 'password' => $hash, 'city' => $city]);
    }

    public function tryToTestDeleteUser(UnitTester $I)
    {
        $this->userService->delete(10);
        $I->dontSeeInDatabase('users', ['id' => 10]);
    }
}
