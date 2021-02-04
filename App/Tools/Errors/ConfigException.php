<?php

namespace App\tools\Errors;

class ConfigException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error! ' . ': <b>' . $this->getMessage() . '</b> there is no configuration file';
    }
}