<?php
spl_autoload_register('phpsam::autoload_class');
class phpsam {
    public static $base_url='';
    static function run() {
        $route=new \phpsam\route\route();
    }
    
    static function autoload_class($name) {
        $name=  str_replace("\\", "/", $name);
        //echo 'whant to load '.dirname(__DIR__)."/".$name . '.php';
        $file=dirname($_SERVER['SCRIPT_FILENAME'])."/".$name . '.php';
        //echo $file."\n";
        if(is_file($file)){
            require $file;
        }
    }
    
    function test() {
        return 'test';
    }
    
}


