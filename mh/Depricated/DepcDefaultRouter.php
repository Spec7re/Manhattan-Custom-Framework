<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 12.01.18
 * Time: 17:19
 */
namespace MH;


class FrontController
{
    private static $_instance = null;

    private function __construct()
    {

    }

    public function dispatch()
    {
        $route = new namespace\Routers\DefaultRouter();
        $route -> parse();

        $controller = $route ->getController();
        $method     = $route ->getMethod();

        if($controller == null)
        {
            $controller = $this->setDefaultController();
        }
        if($method == null)
        {
            $method = $this->setDefaultMethod();
        }

        echo $controller.'<br>'. $method . '<br>';
    }

    public function setDefaultController()
    {
        $controller = \MH\App::getInstance()->getConfig()->app['default_controller'];
        if($controller)
        {
            return $controller;
        }
        return 'Index';
    }

    public function setDefaultMethod()
    {
        $method = \MH\App::getInstance()->getConfig()->app['default_method'];
        if($method)
        {
            return $method;
        }
        return 'Index';
    }


    /*
     * return \MH\FrontController
     * */
    public static function getInstance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new namespace\FrontController();
        }

        return self::$_instance;
    }
}