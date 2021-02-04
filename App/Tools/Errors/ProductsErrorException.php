<?php

namespace App\tools\Errors;

class ProductsErrorException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error!' . ': <b>' . $this->getMessage() . '</b> ';
    }
}