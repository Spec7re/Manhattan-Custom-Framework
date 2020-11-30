<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 12.01.18
 * Time: 17:17
 */

namespace MH\Routers;

interface IRouter {

    public function getURI();

    public function getPost();
}