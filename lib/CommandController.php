<?php

namespace  Minicli;

abstract class CommandController{
    protected $app;

    abstract public function run($argv);

    public  function __construct(App $app)
    {
       $this->app=$app;
    }

    public function getApp(){
        return $this->app;
    }

}