<?php

namespace Minicli;

class App{

    protected $printer;

    protected $commandRegistry;

    public function __construct(){
        $this->printer=new CliPrinter();
        $this->commandRegistry=new CommandRegistry();
    }

    public function getPrinter(){
        return $this->printer;
    }

    public function registerCommand($name,$callback){
        $this->commandRegistry->registerCommand($name,$callback);
    }

    public function registerController($name,CommandController $controller ){
        $this->commandRegistry->registerController($name,$controller);
    }

    public function runCommand(array $argv=[],$defaultCommand="help"){

        $commandName=$defaultCommand;
        if(isset($argv[1])){
            $commandName=$argv[1];
        }
        try{
            call_user_func($this->commandRegistry->getCallable($commandName),$argv);
        }catch(\Exception $e){
            $this->getPrinter()->display($e->getMessage());
            exit;
        }
        
    }
}