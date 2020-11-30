<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 04.01.18
 * Time: 17:07
 */
namespace MH;
include 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;
    private $router = null;
    private $_dbConnections = array();
    private $_session = null;

    /**
     * App constructor.
     */
    private function __construct()
    {
        \MH\Loader::registerNamespace('MH',dirname(__FILE__).DIRECTORY_SEPARATOR);
        \MH\Loader::registerAutoLoad();
    }

    /**
     * @throws \Exception
     */
    public function  run(){

        echo 'All systems engaged!<br>';
        set_exception_handler(array($this,'_exceptionHandler'));
        //Config instance
        $this->_config = \MH\Config::getInstance();

        //Setting default config folder
        if($this->_config->getConfigFolder() == null)
        {
            $this->setConfigFolder('../config');
        }
        //FrontController instance
        $this->_frontController = \MH\FrontController::getInstance();
        if($this->router instanceof \MH\Routers\IRouter)
        {
            $this->_frontController->setRouter($this->router);
        }
        elseif($this->router == 'JsonRPCRouter')
        {   //TODO RPC Router for implement;
            $this->_frontController->setRouter(new namespace\Routers\DefaultRouter());
        }
        elseif ($this->router == 'CLIRouter')
        {   //TODO CLI Router for implement;
            $this->_frontController->setRouter(new namespace\Routers\DefaultRouter());
        }
        else
        {
            $this->_frontController->setRouter(new namespace\Routers\DefaultRouter());
        }

        $_sess = $this->_config->app['session'];

        if($_sess['autostart'])
        {
            if($_sess['type']=='native')
            {
                $_s = new \MH\Sessions\NativeSession($_sess['name'],$_sess['lifetime'],
                    $_sess['path'],$_sess['domain'],$_sess['secure']);
            }
            elseif($_sess['type']=='database')
            {
                $_s = new \MH\Sessions\DBSession($_sess['dbConnection'],
                    $_sess['name'], $_sess['dbTable'],$_sess['lifetime'],
                    $_sess['path'], $_sess['domain'],$_sess['secure']);
            }
            else
            {
                throw new \Exception('No valid session!', 500);
            }
            $this->setSession($_s);
        }

        $this->_frontController->dispatch();

    }

    /**
     * @param null $session
     */
    public function setSession($session)
    {
        $this->_session = $session;
    }

    /**
     * @return null
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @param string $connection
     * @return mixed
     * @throws \Exception
     */
    public function getDBConnection($connection='default')
    {
        if(!$connection)
        {
            throw new \Exception('No connection identifier provided', 500);
        }

        if($this->_dbConnections[$connection])
        {
            return $this->_dbConnections[$connection];
        }

        $_cnf = $this->getConfig()->database;

        if(!$_cnf[$connection])
        {
            throw new \Exception('No valid connection identificator is provided', 500);
        }

        $dbh = new \PDO($_cnf[$connection]['connection_uri'],$_cnf[$connection]['username'],
            $_cnf[$connection]['password'],$_cnf[$connection]['options']);
        $this->_dbConnections[$connection] = $dbh;
        return $dbh;
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
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @param $path
     */
    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    /**
     * @return mixed
     */
    public function getConfigFolder()
    {
        return $this->_configFolder;
    }

    /**
     * @return null
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /*
     *
     * @return \MH\App
     * */
    public static function  getInstance(){

        if (self::$_instance == null)
        {
            self::$_instance = new namespace\App();
        }

        return self::$_instance;
    }

    public function _exceptionHandler(\Exception $ex)
    {
        if($this->_config && $this->_config->app['displayExceptions'] == true)
        {
            echo '<pre>'.print_r($ex, true).'<pre>';
        }
        else
        {
            $this->displayError($ex->getCode());
        }
    }

    public function displayError($error)
    {
        try
        {
            $view = \MH\View::getInstance();
            $view->display('errors.', $error);
        }
        catch (\Exception $exc)
        {
            \MH\Common::headerStatus($error);
            echo '<h1>' . $error . '<h1>';
            exit;
        }
    }

    public function __destruct()
    {
        if($this->_session != null)
        {
            $this->_session->saveSession();
        }
    }

}