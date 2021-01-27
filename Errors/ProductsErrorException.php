<?php


namespace Errors;


use Throwable;

class ProductsErrorException extends \Exception
{
    public $id;

    public function __construct(int $id = null, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    public function errorMessage()
    {
        // error message
        $errMsg = 'Error!' . ': <b>'.$this->getMessage(). $this->id . '</b> ';

        return $errMsg;
    }

    public function getId()
    {
        return $this->id;
    }
}