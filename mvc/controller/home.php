<?php
namespace mvc\controller;

class home extends \phpsam\mvc\controller {
    
    function action_index() {
        $this->render('index',array('x'=>'y'));
    }
    
}

