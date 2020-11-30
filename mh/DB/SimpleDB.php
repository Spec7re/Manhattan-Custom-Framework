<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 19.01.18
 * Time: 17:22
 */

namespace MH\DB;


class SimpleDB
{
    protected $connection = 'default';
    private $db = null;
    private $stmt = null;
    private $params = array();
    private $sql;

    /**
     * SimpleDB constructor.
     */
    public function __construct($connection = null)
    {
        if($connection instanceof \PDO)
        {
            $this->db->$connection;
        }

        elseif ($connection != null)
        {
            $this->db = \MH\App::getInstance()->getDBConnection($connection);
            $this->connection = $connection;
        }
        else
        {
            $this->db = \MH\App::getInstance()->getDBConnection($this->connection);
        }
    }


    /**
     * @param $sql
     * @param array $params
     * @param array $pdoOptions
     * @return $this
     */
    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function  execute($params = array())
    {
        if($params)
        {
            $this->params = $params;
        }
        $this->stmt->execute($this->params);
        return $this;
    }

    /**
     * @return mixed
     */
    public function fetchAllAssoc()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function fetchRowAssoc()
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function fetchAllNum()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }

    /**
     * @return mixed
     */
    public function fetchRowNum()
    {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    /**
     * @return mixed
     */
    public function fetchAllObj()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function fetchRowObj()
    {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $column
     * @return mixed
     */
    public function fetchAllColumn($column)
    {
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }

    /**
     * @param $column
     * @return mixed
     */
    public function fetchRowColumn($column)
    {
        return $this->stmt->fetch(\PDO::FETCH_COLUMN, $column);
    }

    /**
     * @param $class
     * @return mixed
     */
    public function fetchAllClass($class)
    {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    /**
     * @param $class
     * @return mixed
     */
    public function fetchRowClass($class)
    {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $class);
    }

    /**
     * @return mixed
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId;
    }

    /**
     * @return mixed
     */
    public function getAffectedRows()
    {
        return $this->stmt->rowCount();
    }

    /**
     * @return null
     */
    public function getSTMT()
    {
        return $this->stmt;
    }
}