<?php
namespace phpsam\mvc;
class controller {
    
    public $layout='default';
    
    function before_action() {
        
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
            $_page=\phpsam::$base_directory.'mvc/theme/' . \phpsam::$theme.'/'.  $_reflection->getShortName().'/'.$_view_name.'.php';
            
            if(is_file($_page)) {
                ob_start();
                require $_page;
                $_page_content=  ob_get_clean();
            }
            else {
                \phpsam\route\route::throw_error(1);
            }
            //Add Content To Layout
            $_layout=\phpsam::$base_directory.'mvc/theme/' . \phpsam::$theme.'/layouts/'.  $this->layout.'.php';
            $content=$_page_content;
            if(is_file($_layout)) {
                require $_layout;
            }
            else {
                \phpsam\route\route::throw_error(1);
            }
        }
    }
}