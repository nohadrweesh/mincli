<?php

namespace  Minicli;

abstract class CommandController{
    protected $app;
    protected $input;

    abstract public function handle();

    public function boot(App $app)
    {
       $this->app=$app;
    }

    public  function teardown()
    {
    }

    public function run (CommandCall $input){
        $this->input=$input;
        $this->handle();
    }

    protected function getArgs(){
        return $this->input->getArgs();
    }

    protected function getParams(){
        return $this->input->getParams();
    }

    protected function hasParam($param){
        return $this->input->hasParam($param);
    }

    protected function getParam($param){
        return $this->input->getParam($param);
    }

    protected function getApp(){
        return $this->app;
    }

    protected function getPrinter(){
        return $this->getApp()->getPrinter();
    }

}