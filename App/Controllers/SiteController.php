<?php

use App\Services\CategoryService;
use App\Services\LoggerService;
use libs\TemplateMaker;
use Monolog\Logger;

class SiteController
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = (new LoggerService())->getLogger();
    }

    public function index()
    {
        try {
            (new TemplateMaker())
                ->render(
                    'mainTemplate',
                    'mainPage',
                    (new CategoryService())
                        ->getAll()
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
