<?php


namespace Errors;


class ProductsErrorException extends \Exception
{
    public function errorMessage()
    {
        // error message
        $errMsg = 'Error!' . ': <b>'.$this->getMessage().'</b> ';

        return $errMsg;
    }
}