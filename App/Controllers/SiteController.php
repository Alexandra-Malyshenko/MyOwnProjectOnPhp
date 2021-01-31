<?php

use App\tools\TemplateMaker;

class SiteController
{
    public function actionIndex()
    {
        $render = new TemplateMaker();
        $render->render( 'mainTemplate','mainPage', ['1','2']);
    }
}