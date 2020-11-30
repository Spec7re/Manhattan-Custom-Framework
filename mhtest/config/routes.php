<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 15.01.18
 * Time: 15:48
 */

$cnf['administration']['namespace']='Controllers\Admin';
$cnf['administration']['controllers']['index']['to'] = 'test';
$cnf['administration']['controllers']['index']['methods']['new'] = 'Override Engaged';

$cnf['administration']['controllers']['new']['to'] = 'create';

$cnf['Admin']['namespace']= 'Controllers\Admin';
$cnf['*']['namespace'] = 'Controllers';

return $cnf;