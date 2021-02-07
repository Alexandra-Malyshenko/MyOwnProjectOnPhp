<?php

namespace App\tools\Errors;

class PathException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error! Your path must be wrong! ' . '<b>' . $this->getMessage() . '</b> ';
    }
}