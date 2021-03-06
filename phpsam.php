<?php
spl_autoload_register('phpsam::autoload_class');
require_once 'database/medoo.php';
class phpsam {
    
    public static $config=null;
    public static $base_url='';
    public static $base_directory='';
    public static $controller_name='';
    public static $action_name='';
    public static $theme='';
    public static $theme_url='';
    public static $medoo=null;
    public static $user=null;
    
    static function run($config=null) {
        $base_url=$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/';
        phpsam::$base_url=  "http://".str_replace("//", "/", $base_url);
        phpsam::$base_directory=dirname($_SERVER['SCRIPT_FILENAME']).'/';
        if($config==null) {
            $config=  new config\config();
        }
        phpsam::$config=$config;
        if(isset($config->theme)) {
            $theme=$config->theme;
        }
        else $theme='v1';
        phpsam::$theme=$theme;
        phpsam::$theme_url=phpsam::$base_url.'theme/'.$theme.'/';
        $route=new \phpsam\route\route($config,$_SERVER);
    }
    
    static function autoload_class($name) {
        $name=trim($name,"\\");
        $name=  str_replace("\\", "/", $name);
        $file=dirname($_SERVER['SCRIPT_FILENAME'])."/".$name . '.php';
        if(is_file($file)){
            require_once $file;
        }
    }
    
    static function redirect($controller,$action=null,$params=null) {
        $location=phpsam::$base_url.$controller.'/';
        if ($action) {
            $location.=$action;
        }
        if($params) {
            $location.='/'.$params;
        }
        header("Location:" . $location);
        die();
    }
    
}


