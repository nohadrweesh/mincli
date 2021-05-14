<?php

namespace Minicli;

class CommandRegistry{

    protected $namespaces=[];
    protected $defaultRegistry=[];
    protected $commandsPath;

    public  function __construct($commandsPath)
    {
        $this->commandsPath=$commandsPath;
        $this->autoloadNamespaces();
    }

    public function getCommandsPath(){
        return $this->commandsPath;
    }

    public function autoloadNamespaces()
    {
        
        foreach (glob($this->getCommandsPath().'/*',GLOB_ONLYDIR) as $namespacePath) {
            $this->registerNamespace(basename($namespacePath));
        }
    }

    public function registerNamespace($commandNamespace)
    {
        $namespace=new CommandNamespace($commandNamespace);
        $namespace->loadControllers($this->getCommandsPath());
        $this->namespaces[strtolower($commandNamespace)]=$namespace;

    }

    public function getNamespace($command){
        return isset($this->namespaces[$command])?
                    $this->namespaces[$command]:null;
    }

    public function registerCommand($name,$callback){
        $this->defaultRegistry[$name]=$callback;
    }

    public function getCommand($name){
        return isset($this->defaultRegistry[$name])?
                    $this->defaultRegistry[$name]:null;
    }
    
    public function getCallableController($command,$subcommand=null){
        $namespace=$this->getNamespace($command);
        if($namespace !== null){
            return $namespace->getController($subcommand);
        }
        return null;
    }

    public function getCallable($name){


        $singleCommand=$this->getCommand($name);
        if($singleCommand===null){
            throw new \Exception("Command \"$name\" not found");

        }

        return $singleCommand;
    }
    


}