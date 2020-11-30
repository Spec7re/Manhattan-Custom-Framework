<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 10.01.18
 * Time: 16:58
 */

namespace MH;


class FrontController
{
    private static $_instance = null;
    private $ns = null;
    private $controller = null;
    private $method = null;

    /*
     * @var \MH\Routers\IRouter
     *
     * */
    private $router = null;

    private function __construct()
    {

    }

    /**
     * @return null
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param null $router
     */
    public function setRouter(\MH\Routers\IRouter $router)
    {
        $this->router = $router;
    }


    /**
     * @throws \Exception
     */
    public function dispatch()
    {
        if($this->router== null)
        {
            throw new \Exception('No valid router found', 500);
        }
        $r = new namespace\Routers\DefaultRouter();
        $_uri = $r -> getURI();
        $routes = \MH\App::getInstance()->getConfig()->routes;
        $_rc =null;

        if(is_array($routes) && count($routes) > 0)
        {
            foreach ($routes as $k => $v)
            {
                if(strpos($_uri, $k) === 0 &&
                    ($_uri == $k || strpos($_uri, $k . '/') === 0  )
                    && $v['namespace'])
                {
                    $this-> ns = $v['namespace'];
                    $_uri = substr($_uri, strlen($k)+1);
                    $_rc = $v;
                    break;
                }
            }

        } else {

            throw new \Exception('Default Route Missing', 500);
        }


        if($this->ns == null && $routes['*']['namespace'])
        {
            $this->ns = $routes['*']['namespace'];
            $_rc = $routes['*'];
        }

        else if ($this->ns== null && !$routes['*']['namespace'])
        {
            throw new \Exception('Default route missing', 500);
        }

//        echo $this->ns.'<br>';

        $input = \MH\InputData::getInstance();

        $_params = explode('/', $_uri);

        if ($_params[0])
        {
            $this->controller = strtolower($_params[0]);

            if ($_params[1])
            {
                $this->method = strtolower($_params[1]);

                unset($_params[0],$_params[1]);

                $input->setGet(array_values($_params));
            }else
            {
                $this->method = $this->setDefaultMethod();
            }
        }else
        {
            $this->controller = $this->setDefaultController();
            $this->method = $this->setDefaultMethod();
        }


        if(is_array($_rc) && $_rc['controllers'])
        {
            if( $_rc['controllers'][$this->controller]['methods'][$this->method])
            {
                $this->method = strtolower($_rc['controllers'][$this->controller]['methods'][$this->method]);
            }

            if(isset($_rc['controllers'][$this->controller]['to']))
            {
                $this->controller = strtolower($_rc['controllers'][$this->controller]['to']);
            }

        }

//        $input->setPost($this->router->getPost());

        $ttl = $this->ns.'\\'.ucfirst($this->controller);
        $newController = new $ttl;
        $newController -> {$this->method}();
    }

    public function setDefaultController()
    {
        $controller = \MH\App::getInstance()->getConfig()->app['default_controller'];
        if($controller)
        {
            return strtolower($controller);
        }
        return 'index';
    }

    public function setDefaultMethod()
    {
        $method = \MH\App::getInstance()->getConfig()->app['default_method'];
        if($method)
        {
            return strtolower($method);
        }
        return 'index';
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