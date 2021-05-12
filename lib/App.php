<?php

namespace Minicli;

class App{

    protected $printer;

    protected $registry=[];

    public function __construct(){
        $this->printer=new CliPrinter();
    }

    public function getPrinter(){
        return $this->printer;
    }

    public function registerCommand($name,$callback){
        $this->registry[$name]=$callback;
    }

    public function getCommand($name){
        return isset($this->registry[$name])?
                    $this->registry[$name]:null;
    }

    public function runCommand(array $argv=[]){

        $commandName="help";
        if(isset($argv[1])){
            $commandName=$argv[1];
        }

        $command=$this->getCommand($commandName);
        if($command === null){
            $this->getPrinter()->display( "Error: Command \"$commandName\" not found. ");
            exit;
        }

        call_user_func($command,$argv);
    }
}