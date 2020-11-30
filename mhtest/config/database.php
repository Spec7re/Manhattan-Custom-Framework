<?php

$cnf['default']['connection_uri'] = 'mysql:host=127.0.0.1; dbname=manhattan';
$cnf['default']['username'] ='root';
$cnf['default']['password'] ='password';
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND]="SET NAMES 'UTF8'";
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

return $cnf;
