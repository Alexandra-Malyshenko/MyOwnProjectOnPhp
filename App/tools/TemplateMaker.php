<?php

namespace App\tools;

use App\tools\Errors\ConfigException;
use App\tools\Errors\TemplateRenderException;

class TemplateMaker
{
    public $header;
    public $footer;

    public function __construct()
    {
        $this->config = require '../App/config/config.php';
        $this->header = $this->config['header'];
        $this->footer = $this->config['footer'];


    }

    public function render(string $templateName, string $layout, array $params)
    {
        if (empty($templateName) or empty($layout) or empty($params)) {
            throw new TemplateRenderException('You should pass three parametrs in TemplateMaker function
             render(string templateName, string nameLayout, array products )');
        }

        $templatePath = dirname(__DIR__) . '/views/templates/';
        $layoutPath = dirname(__DIR__) . '/views/layout/';

        ob_start();
        $header = file_get_contents(dirname(__DIR__) . $this->header);
        $main = file_get_contents($templatePath . $templateName . '.html');
        $footer = file_get_contents(dirname(__DIR__) . $this->footer);
        ob_end_clean();

        require_once($layoutPath . $layout . ".php");
    }
}
