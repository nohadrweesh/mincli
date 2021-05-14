<?php

namespace Minicli;
class CommandNamespace{

    protected $name;
    protected $controllers=[];

    public function __construct($name){
        $this->name=$name;
    }

    public function getName(){
        return $this->name;
    }

    public function getControllers(){
        return $this->controllers;
    }

    public function getController($name){
        return isset($this->controllers[$name])?$this->controllers[$name]:null;
    }

    public function loadControllers($commandPath){

        foreach (glob($commandPath."/".$this->getName()."/*Controller.php") as $controllerFile) {
            $this->loadCommandMap($controllerFile);
        }
        return  $this->getControllers();
    }

    public function loadCommandMap($controllerFile){
        $filename=basename($controllerFile);
        $controllerClass=str_replace('.php','',$filename);
        $commandName=strtolower(str_replace('Controller','',$controllerClass));
        $fullClassName=sprintf("App\\Command\\%s\\%s",$this->getName(),$controllerClass);
        
        $controller=new $fullClassName();
        $this->controllers[$commandName]=$controller;
    }



}