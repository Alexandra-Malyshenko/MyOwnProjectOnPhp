<?php

use App\tools\TemplateMaker;
use App\Repository\CategoryRepository;

class SiteController
{
    public function actionIndex()
    {
        $render = new TemplateMaker();
        $categoryRepository = new CategoryRepository();

        $render->render('mainTemplate', 'mainPage', $categoryRepository->getCategoryList());
    }
}
