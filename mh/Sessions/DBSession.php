<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 23.01.18
 * Time: 18:21
 */

namespace MH\Sessions;

use MH\DB\SimpleDB;

class DBSession extends SimpleDB implements \MH\Sessions\ISessions
{
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId;
    private $sessionData = array();

    /**
     * DBSession constructor.
     */
    public function __construct($dbconnection, $name, $tableName = 'session', $lifetime = 3600,
                                $path = null, $domain = null, $secure = false)
    {
        parent::__construct($dbconnection);
        $this->tableName = $tableName;
        $this->sessionName = $name;
        $this->lifetime = $lifetime;
        $this->path= $path;
        $this->domain =$domain;
        $this->secure = $secure;
        $this->sessionId = $_COOKIE[$name];

        if(strlen($this->sessionId) < 32)
        {
            $this->_startNewSession();
        }
        elseif (!$this->_validateSession())
        {
            $this->_startNewSession();
        }
    }

    /**
     *New session
     */
    private function _startNewSession()
    {
        $this->sessionId = md5(uniqid('mh',TRUE));
        $this->prepare(' INSERT INTO ' . $this->tableName . ' (sessid,valid_until) VALUES(?,?) ',
            array($this->sessionId, (time() + $this->lifetime)))->execute();
        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
    }

    private function _validateSession()
    {
        if($this->sessionId)
        {
            $d = $this->prepare(' SELECT * FROM '. $this->tableName . ' WHERE sessid=? AND valid_until<=? ',
                array($this->sessionId, (time() + $this->lifetime)))->execute()->fetchAllAssoc();
            if(is_array($d) && count($d) == 1 && $d[0])
            {
                $this->sessionData = unserialize($d[0]['sess_data']);
            }
            echo 'Validating session!<br>';
            return true;
        }
        return false;
    }

    public function __get($name)
    {
        return $this->sessionData[$name];
    }

    public function __set($name, $value)
    {
        $this->sessionData[$name] = $value;
    }

    public function destroySession()
    {
        // TODO: Implement destroySession() method.
    }

    public function getSessionId()
    {
        // TODO: Implement getSessionId() method.
    }

    public function saveSession()
    {
        if($this->sessionId) {
            $this->prepare(' UPDATE ' . $this->tableName . ' SET sess_data=? , valid_until=? WHERE sessid=? ',
                array(serialize($this->sessionData),(time() + $this->lifetime),$this->sessionId))->execute();
            setcookie($this->sessionName, $this->sessionId,(time() + $this->lifetime),$this->path, $this->domain, $this->secure,true);
        }
        echo "DataBase session online";
    }
}