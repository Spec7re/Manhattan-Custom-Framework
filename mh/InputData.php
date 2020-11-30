<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 18.01.18
 * Time: 14:54
 */

namespace MH;


class InputData
{
    private static $_instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();

    /**
     * InputData constructor.
     * @param array $_cookies
     */
    public function __construct()
    {
        $this->_cookies = $_COOKIE;
    }

    /**
     * @param array $ar
     */
    public function setPost($ar)
    {
        if (is_array($ar))
        {
            $this->_post = $ar;
        }
    }

    /**
     * @param array $ar
     */
    public function setGet($ar)
    {
        if (is_array($ar))
        {
            $this->_get = $ar;
        }
    }

    /**
     * @return array
     */
    public function hasGet($id)
    {
        return array_key_exists($id, $this->_get);
    }

    /**
     * @return array
     */
    public function hasPost($name)
    {
        return array_key_exists($name,$this->_post);
    }

    public function hasCookies($name)
    {
        return array_key_exists($name,$this->_cookies);
    }

    public function get($id, $normalize = null, $default =null)
    {
        if($this->hasGet($id))
        {
            if($normalize != null)
            {
                \MH\Common::normalize($this->_get[$id], $normalize);
            }

            return $this->_get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default =null)
    {
        if($this->hasPost($name))
        {
            if($normalize != null)
            {
                \MH\Common::normalize($this->_post[$name], $normalize);
            }

            return $this->_post[$name];
        }
        return $default;
    }

    public function cookie($name, $normalize = null, $default =null)
    {
        if($this->hasCookies($name))
        {
            if($normalize != null)
            {
                \MH\Common::normalize($this->_cookies[$name], $normalize);
            }

            return $this->_cookies[$name];
        }
        return $default;
    }

    public static function getInstance()
    {
        if(self::$_instance == null)
        {
            self::$_instance == new namespace\InputData();
        }

        return self::$_instance;
    }
}