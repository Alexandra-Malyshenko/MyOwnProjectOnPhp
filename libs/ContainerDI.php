<?php

namespace libs;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use function DI\factory;

class ContainerDI
{
    public function getContainer()
    {
        $container = new ContainerBuilder();
        $container->useAutowiring(false);
        $container->useAnnotations(false);
        $container->addDefinitions($this->getDefinitions());
        return $container->build();
    }

    public function getDefinitions()
    {
        return require(__DIR__ . '/../App/config/DIconfig.php');
    }
}