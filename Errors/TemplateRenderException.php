<?php


namespace Errors;


class TemplateRenderException extends \Exception
{
    public function errorMessage()
    {
        // error message
        $errMsg = 'Error! '.': <b>'.$this->getMessage().'</b> there is no here needed parametr';

        return $errMsg;
    }
}