<?php
namespace phpsam\mvc;
class controller {
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
}