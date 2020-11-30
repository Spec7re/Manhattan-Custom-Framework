<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 09.01.18
 * Time: 16:46
 */

$cnf['default_controller'] = 'Index' ;
$cnf['default_method']     = 'default_method' ;
$cnf['namespaces']['Controllers'] = '/var/www/manhattan.local/mhtest/controllers';


$cnf['session']['autostart'] = true ;
$cnf['session']['type'] = 'database' ;
$cnf['session']['name'] = '__sess' ;
$cnf['session']['lifetime'] = 3600 ;
$cnf['session']['path'] = '/' ;
$cnf['session']['domain'] = '' ;
$cnf['session']['secure'] = false ;
$cnf['session']['dbConnection'] = 'default' ;
$cnf['session']['dbTable'] = 'sessions' ;
return $cnf;