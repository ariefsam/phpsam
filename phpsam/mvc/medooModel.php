<?php
namespace phpsam\mvc;

class medooModel extends model {
    public $medoo=null;
    
    function __construct() {
        if(\phpsam::$medoo===null) {
            $this->medoo=new \medoo(\phpsam::$config->medoo);
            \phpsam::$medoo=$this->medoo;
        }
        else {
            $this->medoo=  \phpsam::$medoo;
        }
        parent::__construct();
    }
    
    public function __call($method, $args) {
        $this->medoo->$method($args[0]);
    }
    
}