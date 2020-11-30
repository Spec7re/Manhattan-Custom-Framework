<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 25.01.18
 * Time: 15:11
 */

namespace MH;

class View
{
        private static $_instance = null;
        private $___viewPath = null;
        private $___data = array();
        private $___viewDir =null;
        private $___extension = '.php';
        private $___layoutParts = array();
        private $___layoutData = array();

    /**
     * View constructor.
     */
    private function __construct()
    {
        $this->___viewPath = \MH\App::getInstance()->getConfig()->app['viewDirectory'];
        if($this->___viewPath==null)
        {
            $this->___viewPath =realpath('../views');
        }
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if($path)
        {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if(is_dir($path) && is_readable($path))
            {
                $this->___viewDir = $path;
            }else
            {
                throw new \Exception('No valid path', 500);
            }
        }else
            {
                throw new \Exception('No valid path', 500);
            }

    }

    public function display($name, $data = array(),$returnAsString = false)
    {
        if (is_array($data))
        {
            $this->___data = array_merge($this->___data, $data);
        }

        if(count($this->___layoutParts) > 0)
        {
            foreach ($this->___layoutParts as $k => $v)
            {
                $r = $this->_includeFile($v);
                if($r)
                {
                    $this->___layoutData[$k] = $r;
                }
            }
        }

        if($returnAsString)
        {
            return $this->_includeFile($name);
        }
        else
        {
            echo $this->_includeFile($name);
        }
    }

    public function getLayoutData($data)
    {
        return $this->___layoutData[$data];
    }

    public function appendToLayout($key, $layout)
    {
        if($key && $layout)
        {
            $this->___layoutParts[$key] = $layout;
        }
        else
        {
            throw  new  \Exception('Layout require valid key and template', 500);
        }

    }

    public function _includeFile($file)
    {
        if($this->___viewDir == null)
        {
            $this->setViewDirectory($this->___viewPath);
        }

        $___fl = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if(file_exists($___fl) && is_readable($___fl))
        {
            ob_start();
            include $___fl;
            return ob_get_clean();
        }
        else
        {
            throw new \Exception('View'. $file . 'file connot be include', 500);
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->___data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->___data[$name];
    }

    /**
     *  @return View|null
     */
    public static function getInstance()
    {
        if(self::$_instance == null)
        {
           self::$_instance = new namespace\View();
        }
        return self::$_instance;
    }

}