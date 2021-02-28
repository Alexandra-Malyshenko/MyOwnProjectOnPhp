<?php

use App\Repository\UserRepository;
use App\Services\UserService;

class ValidationFormsCest
{
    private UserService $userService;

    public function _before(UnitTester $I)
    {
        $host = 'localhost';
        $db_name = "proj_test";
        $userDB = 'proj_user';
        $passwordDB = 'Password1!';
        $this->db = new PDO("mysql:host={$host};dbname={$db_name}", $userDB, $passwordDB);
        $this->userService = new UserService(new UserRepository($this->db));
    }

    public function tryToTestUserName(UnitTester $I)
    {
        $name = 'Piter12';
        $result = $this->userService->validationUserName($name);

        $I->assertFalse($result);
    }

    public function tryToTestUserPassword(UnitTester $I)
    {
        $password = 'test test test';
        $result = $this->userService->validationUserPassword($password);

        $I->assertTrue($result);
    }

    public function tryToTestUserPasswordsMatch(UnitTester $I)
    {
        $password = 'test';
        $password2 = 'Test';
        $result = $this->userService->validationPasswordMatch($password, $password2);

        $I->assertFalse($result);
    }
}
