<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 26.01.18
 * Time: 18:33
 */

namespace MH;


class Validation
{

    private $_rules = array();
    private $_errors = array();

    public function setRule($rule, $value, $params = null, $name = null)
    {
        $this->_rules[] = array('rule' => $rule, 'val' => $value, 'par' => $params, 'name' => $name);
        return $this;
    }

    public function validate()
    {
        $this->_errors = array();
        if(count($this->_rules) > 0 )
        {
            foreach ($this->_rules as $v)
            {
//                if(!$this -> $v['rule'] ($v['val'], $v['par']))
                {
                    if ($v['name'])
                    {
                        $this->_errors[] = $v['name'];
                    }
                    else
                    {
                        $this->_errors[] = $v['rule'];
                    }
                }
            }
        }
        return (bool) count($this->_errors);
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function __call($a , $b)
    {
        throw new \Exception('Valid rule is not defined', 500);
    }

    public static function required($val)
    {
        if(is_array($val))
        {
            return !empty($val);
        }
        else
        {
            return $val !='';
        }
    }

    public static function url($val)
    {
        return filter_var($val, FILTER_VALIDATE_URL)!== false;
    }

    public static function matches($val1 , $val2)
    {
        return $val1 == $val2;
    }

    public static function minLength($val1 , $val2)
    {
        return (mb_strlen($val1) >= $val2);
    }
}