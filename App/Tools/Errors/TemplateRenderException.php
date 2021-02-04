<?php

namespace App\tools\Errors;

class TemplateRenderException extends \Exception
{
    public function errorMessage(): string
    {
        return 'Error! ' . ': <b>' . $this->getMessage() . '</b> there is no here needed parametr';
    }
}