<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 29.01.18
 * Time: 21:18
 */

namespace MH;


class DefaultController
{
    /*
     *
     * */
    public $app;
    public $view;
    public $config;
    public $input;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->app  = \MH\App::getInstance();
        $this->view = \MH\View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = \MH\InputData::getInstance();
    }

    public function jsonResponse()
    {

    }
}