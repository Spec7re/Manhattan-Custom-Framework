<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 16.01.18
 * Time: 15:17
 */

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

    private function __construct()
    {

        \MH\Loader::registerNamespace('MH',dirname(__FILE__).DIRECTORY_SEPARATOR);
        \MH\Loader::registerAutoLoad();

//        //Config instance
//        $this->_config = \MH\Config::getInstance();

//        //Setting default config folder
//        if($this->_config->getConfigFolder() == null)
//        {
//            $this->setConfigFolder('../config');
//        }

    }


    public function  run(){

        echo 'All systems functional!<br>';

        //Config instance
        $this->_config = \MH\Config::getInstance();

        //Setting default config folder
        if($this->_config->getConfigFolder() == null)
        {
            $this->setConfigFolder('../config');
        }
        //FrontController instance
        $this->_frontController = \MH\FrontController::getInstance();
        $this->_frontController ->dispatch();


    }

    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder()
    {
        return $this->_configFolder;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    /*
     *
     * @return \MH\App
     * */
    public static function  getInstance(){

        if (self::$_instance == null){
            self::$_instance = new namespace\App();
        }

        return self::$_instance;
    }
}