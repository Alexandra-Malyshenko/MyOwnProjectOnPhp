<?php

namespace php;

class TemplateMaker
{
    public $defaultLayout;
    public $header;
    public $footer;

    public function __construct(string $defaultLayout, array $config)
    {
        $this->defaultLayout = $defaultLayout;
        $this->header = $config['header'];
        $this->footer = $config['footer'];
    }

    public function render(string $templateName, string $layout, array $params)
    {

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

//        $layout = $layout || $this->defaultLayout;

        require_once($templatePath . $layout . ".php");
    }
}
