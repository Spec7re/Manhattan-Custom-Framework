<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 10.01.18
 * Time: 19:52
 */
namespace MH\Routers;

class DefaultRouter implements \MH\Routers\IRouter
{
    public function getURI()
    {
        echo '!!!Route online!!!<br>';

        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])+1);


    }


    public function getPost()
    {
        return $_POST;
    }
}