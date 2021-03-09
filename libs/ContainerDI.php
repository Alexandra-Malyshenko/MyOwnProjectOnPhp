<?php

namespace libs;

use DI\Container;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use function DI\factory;

class ContainerDI
{
    public function getContainer()
    {
//        $container = new ContainerBuilder();
//        $container->useAutowiring(false);
//        $container->useAnnotations(false);
//        $container->addDefinitions($this->getDefinitions());
//        return $container->build();
        $container = new Container();
        return $container;
    }

    public function getDefinitions()
    {
        return require(__DIR__ . '/../App/config/DIconfig.php');
    }
}