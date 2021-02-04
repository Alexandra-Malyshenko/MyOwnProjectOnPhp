<?php

namespace App\tools\Errors;

class PathException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error! Your path should be wrong! On line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b> ';
    }
}