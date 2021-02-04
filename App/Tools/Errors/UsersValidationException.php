<?php

namespace App\tools\Errors;

class UsersValidationException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error!!! ' . '<b>' . $this->getMessage() . '</b> ';
    }
}
