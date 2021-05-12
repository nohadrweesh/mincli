<?php

namespace Minicli;

class CommandRegistry{

    protected $registry=[];
    protected $controllers=[];

    public function registerCommand($name,$callback){
        $this->registry[$name]=$callback;
    }

    public function getCommand($name){
        return isset($this->registry[$name])?
                    $this->registry[$name]:null;
    }
    
    public function registerController($name,CommandController $controller){
        $this->controllers[$name]=$controller;
    }
    public function getController($name){
        return isset($this->controllers[$name])?
                    $this->controllers[$name]:null;
    }

    public function getCallable($name){
        $controller=$this->getController($name);

        if($controller instanceof CommandController){
            return [$controller,'run'];
        }

        $command=$this->getCommand($name);
        if($command===null){
            throw new \Exception("Command \"$name\" not found");

        }

        return $command;
    }
    


}