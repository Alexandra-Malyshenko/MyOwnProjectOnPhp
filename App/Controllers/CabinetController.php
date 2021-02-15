<?php

use App\tools\TemplateMaker;
use App\Repository\CategoryRepository;

class CabinetController
{
    public function index()
    {
        $render = new TemplateMaker();
        $categoryRepository = new CategoryRepository();
        $render->render('cabinetTemplate', 'cabinetPage', $categoryRepository->getAll());
    }
}