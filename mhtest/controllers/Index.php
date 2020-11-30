<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 15.01.18
 * Time: 15:52
 */
namespace Controllers;

use MH\DefaultController;

class Index extends DefaultController
{
    public function default_method()
    {
        echo 'Controller/Index/Default Method Reporting.<br>';

        $this->app->displayError(400);

        $val = new \MH\Validation();
        $val ->setRule('url','http://az.c')->setRule('matches', 'http://az.c', 50);
        var_dump($val ->validate());


//        $view = \MH\View::getInstance();
//        $view -> username = 'Spectre Status Recognized';
//        $view ->appendToLayout('body','admin.index');
//        $view ->display('layouts.default', array('c'=> array(1,2,3,5,7)), false);
    }
}