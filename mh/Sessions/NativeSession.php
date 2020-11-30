<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 22.01.18
 * Time: 20:09
 */

namespace MH\Sessions;

class NativeSession implements \MH\Sessions\ISessions
{
    /**
     * NativeSession constructor.
     */
    public function __construct($name, $lifetime=3600, $path = null, $domain = null, $secure = false)
    {
        if(strlen($name)<1)
        {
            $name = '__sess';
        }

        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure,true);
        session_start();
    }

    public function __get($name)
    {
        return $_SESSION['name'];
    }

    public function __set($name, $value)
    {
        $_SESSION['name'] = $value;
    }

    public function saveSession()
    {
        session_write_close();
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function destroySession()
    {
        session_destroy();
    }
}