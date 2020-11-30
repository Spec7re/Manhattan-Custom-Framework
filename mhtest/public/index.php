<?php
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

$app ->getSession()->counter +=1;
echo $app->getSession()->counter.'<br>';


//var_dump($app->getDBConnection('default'));
//$db = new \MH\DB\SimpleDB();
//$test = $db->prepare('SELECT * FROM users WHERE id=?', array(1))->execute()->fetchAllAssoc();
//print_r($test);






