<?php
namespace phpsam\mvc;
class controller {
    
    public $layout='default';
    protected $input_post=null;
    public $params=array();
    
    function before_action() {
        
    }
    
    function __construct() {
        if(isset($_POST)) {
            foreach($_POST as $key=>$value) {
                if(is_string($value)){
                    $this->input_post[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
                }
                else {
                    foreach($value as $kv=>$v) {
                        if(is_string($v)) {
                            $this->input_post[$key][$kv]=filter_var($v,FILTER_SANITIZE_STRING);
                        }
                    }
                }
            }
        }
    }
    
    function input_post($field=null) {
        if($field==null) {
            $return=$this->input_post;
        }
        else {
            $return=@$this->input_post[$field];
        }
        return $return;
    }
    
    function action($action_name=null,$action_params=null) {
        if($action_name==null) $action_name='index';
        $this->before_action();
        if(method_exists($this, "action_" . $action_name)){
            $x=call_user_func_array(array($this, 'action_' . $action_name), $action_params);
        }
        else {
            \phpsam\route\route::throw_error(404);
        }
        $this->after_action();
    }
    
    function after_action() {
        
    }
    
    function render($_view_name=null,$_data=null) {
        if(!@$_view_name) {
            \phpsam\route\route::throw_error(1);
        }
        else {
            if(is_array($_data)) {
                foreach($_data as $_key=>$_value) {
                    $$_key=$_value;
                }
            }
            $_reflection=new \ReflectionClass($this);
            //Get Content Page
            $_page=\phpsam::$base_directory.'/theme/' . \phpsam::$theme.'/views/'.  $_reflection->getShortName().'/'.$_view_name.'.php';
            
            if(is_file($_page)) {
                ob_start();
                require $_page;
                $_page_content=  ob_get_clean();
            }
            else {
                \phpsam\route\route::throw_error(1);
            }
            //Add Content To Layout
            $_layout=\phpsam::$base_directory.'/theme/' . \phpsam::$theme.'/layouts/'.  $this->layout.'.php';
            $content=@$_page_content;
            if(is_file($_layout)) {
                require $_layout;
            }
            else {
                \phpsam\route\route::throw_error(1);
            }
        }
    }
    
    function render_partial($_view_name=null,$_data=null) {
        if(!@$_view_name) {
            \phpsam\route\route::throw_error(1);
        }
        else {
            if(is_array($_data)) {
                foreach($_data as $_key=>$_value) {
                    $$_key=$_value;
                }
            }
            $_reflection=new \ReflectionClass($this);
            //Get Content Page
            $_page=\phpsam::$base_directory.'/theme/' . \phpsam::$theme.'/views/'.  $_reflection->getShortName().'/'.$_view_name.'.php';
            if(is_file($_page)) {
                ob_start();
                require $_page;
                $_page_content=  ob_get_clean();
            }
            else {
                \phpsam\route\route::throw_error(1);
            }
            
            echo $_page_content;
        }
    }
    
    function url($url='') {
        return \phpsam::$base_url . $url;
    }
    
    function set_flash($name,$value) {
       $_SESSION['_phpsamflash'][$name]=$value;
    }
    
    function get_flash($name) {
        if(isset($_SESSION['_phpsamflash'][$name])) {
            $return= $_SESSION['_phpsamflash'][$name];
            unset($_SESSION['_phpsamflash'][$name]);
            return $return;
        }
    }
    
    function redirect($controller,$action,$params=null) {
        \phpsam::redirect($controller, $action, $params);
    }
    
}