<?php
spl_autoload_register('phpsam::autoload_class');

class phpsam {
    
    public static $config=null;
    public static $base_url='';
    public static $base_directory='';
    public static $controller_name='';
    public static $action_name='';
    public static $theme='';
    
    static function run($config=null) {
        $base_url="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/';
        phpsam::$base_url=$base_url;
        phpsam::$base_directory=dirname($_SERVER['SCRIPT_FILENAME']).'/';
        if($config==null) {
            $config=  new config\config();
        }
        phpsam::$config=$config;
        if(isset($config->theme)) {
            phpsam::$theme=$config->theme;
        }
        $route=new \phpsam\route\route($config,$_SERVER);
    }
    
    static function autoload_class($name) {
        $name=  str_replace("\\", "/", $name);
        $file=dirname($_SERVER['SCRIPT_FILENAME'])."/".$name . '.php';
        if(is_file($file)){
            require_once $file;
        }
    }
    
}


