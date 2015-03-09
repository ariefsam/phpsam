<?php
namespace phpsam\route;

class route {
    
    public static $uri=array();
    
    function __construct($server=null) {
        if($server==null) {
            $server=$_SERVER;
        }
        $base_url=$server['HTTP_HOST'].dirname($server['SCRIPT_NAME']);
        \phpsam::$base_url=$base_url;
        $uri=  str_replace(dirname($server['SCRIPT_NAME']).'/', "", $server['REQUEST_URI']);
        $explode_url=  explode("/", $uri);
        $this->uri=$explode_url;
        if(!$controller_name=@$explode_url[0]) {
            $controller_name='home';
        }
        if(!$action_name=@$explode_url[1]) {
            $action_name='index';
        }
        
        $controller_class="\\mvc\\controller\\" . $controller_name;
        if(class_exists($controller_class)){
            $controller=new $controller_class();
            $controller->action($action_name,$explode_url);
        }
        else {
            $this->throw_error(404);
        }
        
    }
    
    public static function throw_error($code) {
        switch ($code) {
            case 404:
                http_response_code(404);
                echo "<h1>Page Not Found (404)</h1>";
                break;
        }
    }
    
}
