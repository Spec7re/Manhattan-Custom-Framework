<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 17.01.18
 * Time: 18:24
 */

/**
 * Created by PhpStorm.
 * User: specter
 * Date: 04.01.18
 * Time: 15:47
 */
error_reporting(E_ALL ^ E_NOTICE);

include '../../mh/App.php';

$app = \MH\App::getInstance();

$app -> run();

//echo $app->getConfig()->app;


//$config = \MH\Config::getInstance();
//$config -> setConfigFolder('../config');

//echo $config -> app['Test2'];





