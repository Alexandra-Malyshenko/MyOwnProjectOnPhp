<?php

namespace libs;

use App\tools\Errors\ConfigException;
use App\tools\Errors\ProductsErrorException;
use App\tools\Errors\TemplateRenderException;
use App\tools\logger\Logger;

class TemplateMaker
{
    public $footer;
    private $config;
    private Logger $logger;

    public function __construct()
    {
        $this->config = require '../App/config/config.php';
        if (empty($this->config)) {
            throw new ConfigException('There is no configuration in this path');
        }
        $this->footer = $this->config['footer'];
        $this->logger = new Logger();
    }

    public function render(string $templateName, string $layout, array $params)
    {
        if (empty($layout) || empty($params)) {
            throw new TemplateRenderException('You should pass three parametrs in TemplateMaker function
             render(string templateName, string nameLayout, array products )');
        } elseif (empty($params)) {
            $this->logger
                ->warning('There is no array! You should pass array of products');
            throw new ProductsErrorException('There is no array! You should pass array of products');
        }
        $templatePath = dirname(__DIR__) . '/App/views/templates/';
        $layoutPath = dirname(__DIR__) . '/App/views/layout/';
        ob_start();
        $footer = file_get_contents(dirname(__DIR__) . $this->footer);
        if ($templateName !== '') {
            $main = file_get_contents($templatePath . $templateName . '.html');
        }
        ob_end_clean();
        require_once($layoutPath . $layout . ".php");
    }
}
