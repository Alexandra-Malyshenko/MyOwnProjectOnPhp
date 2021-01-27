<?php


namespace Errors;


class PathException extends \Exception
{
    public function errorMessage()
    {
        // error message
        $errMsg = 'Error! Your path should be wrong! On line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> ';

        return $errMsg;
    }
}