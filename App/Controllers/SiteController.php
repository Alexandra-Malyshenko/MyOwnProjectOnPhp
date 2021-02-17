<?php

use App\Services\CategoryService;
use App\tools\TemplateMaker;

class SiteController
{
    public function index()
    {
        $render = new TemplateMaker();
        $render->render('mainTemplate', 'mainPage', (new CategoryService())->getAll());
    }
}
