<?php

namespace App\tools\Errors;

use Throwable;

class ProductsErrorException extends \Exception
{
    public $id;

    public function __construct(int $id = null, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    public function errorMessage(): string
    {
        return 'Error!' . ': <b>' . $this->getMessage() . $this->id . '</b> ';
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}