<?php
namespace phpsam\route;

class route {
    
    public static $uri=array();
    
    function __construct($config=null,$server=null) {
        if($server==null) {
            $server=$_SERVER;
        }
        $base_url=\phpsam::$base_url;
        $uri=  str_replace(dirname($server['SCRIPT_NAME']).'/', "", $server['REQUEST_URI']);
        $explode_url=  explode("/", $uri);
        $this->uri=$explode_url;
        if(!$controller_name=@$explode_url[0]) {
            $controller_name='home';
        }
        if(!$action_name=@$explode_url[1]) {
            $action_name='index';
        }
        \phpsam::$controller_name=$controller_name;
        \phpsam::$action_name=$action_name;
        if(is_array($config->hook)) {
            foreach($config->hook as $value) {
                $obj=new $value;
                $obj->hook();
            }
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
            case 1:
                http_response_code(500);
                echo "<h1>Render Error(500)</h1>";
                break;
        }
    }
    
}
