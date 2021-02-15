<?php

use App\tools\TemplateMaker;
use App\Repository\CategoryRepository;

class SiteController
{
    public function index()
    {
        $render = new TemplateMaker();
        $categoryList = new CategoryRepository();
        $categoryList = $categoryList->getAll();
//        var_dump($categoryList); die();
        $render->render('mainTemplate', 'mainPage', $categoryList);
    }
}
