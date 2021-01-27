<?php

namespace php;

use Errors\ConfigException;
use Errors\TemplateRenderException;

class TemplateMaker
{
    public $header;
    public $footer;

    public function __construct(array $config)
    {
        if (empty($config)){
            throw new ConfigException('Configuration file should be array, and have two path for HEADER and FOOTER Templates !');
        } else {
            $this->header = $config['header'];
            $this->footer = $config['footer'];
        }

    }

    public function render(string $templateName, string $layout, array $params)
    {
        if (empty($templateName) or empty($layout) or empty($params)) {
            throw new TemplateRenderException('You should pass three parametrs in TemplateMaker function
             render(string templateName, string nameLayout, array products )');
        }

        foreach ($params as $key => $value)
        {
            switch ($key) {
                case "cakes" : $cakes = $params[$key]; break;
                case "cupcakes" : $cupcakes = $params[$key]; break;
                case "cookies" : $cookies = $params[$key]; break;
                case "bread" : $bread = $params[$key]; break;
                default : $product = $params;
            }
        }

        $templatePath = dirname(__DIR__) . '/public/html/';

        ob_start();
        $header = file_get_contents($this->header);
        $main = file_get_contents($templatePath . $templateName . '.html');
        $footer = file_get_contents($this->footer);
        ob_end_clean();

        require_once($templatePath . $layout . ".php");
    }
}
