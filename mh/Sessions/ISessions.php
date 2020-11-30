<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 22.01.18
 * Time: 20:00
 */
namespace MH\Sessions;

interface ISessions
{

    public function getSessionId();

    public function saveSession();

    public function destroySession();

    public function __get($name);

    public function __set($name, $value);

}