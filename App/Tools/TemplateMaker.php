<?php

namespace App\tools;

use App\tools\Errors\ConfigException;
use App\tools\Errors\ProductsErrorException;
use App\tools\Errors\TemplateRenderException;
use App\tools\logger\Logger;

class TemplateMaker
{
    public $header;
    public $footer;

    public function __construct()
    {
        $this->config = require '../App/config/config.php';
        if (empty($this->config)) {
            throw new ConfigException('There is no configuration in this path');
        }
        $this->header = $this->config['header'];
        $this->footer = $this->config['footer'];
        $this->logger = new Logger();
    }

    public function render(string $templateName, string $layout, array $params)
    {
        if (empty($layout) || empty($params)) {
            throw new TemplateRenderException('You should pass three parametrs in TemplateMaker function
             render(string templateName, string nameLayout, array products )');
        } elseif (empty($params)) {
            $this->logger->warning('There is no array! You should pass array of products');
            throw new ProductsErrorException('There is no array! You should pass array of products');
    }

        $templatePath = dirname(__DIR__) . '/views/templates/';
        $layoutPath = dirname(__DIR__) . '/views/layout/';

        ob_start();
        $header = file_get_contents(dirname(__DIR__) . $this->header);
        $footer = file_get_contents(dirname(__DIR__) . $this->footer);
        if ($templateName == 'mainTemplate'){
            $main = file_get_contents($templatePath . $templateName . '.html');
        }
        ob_end_clean();

        require_once($layoutPath . $layout . ".php");
    }
}
