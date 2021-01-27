<?php


namespace Errors;


class ConfigException extends \Exception
{
    public function errorMessage()
    {
        // error message
        $errMsg = 'Error! '.': <b>'.$this->getMessage().'</b> there is no configuration file';

        return $errMsg;
    }
}