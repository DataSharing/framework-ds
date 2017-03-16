<?php

Class Deconnexion extends Controller{
    function __construct() {
        parent::__construct();
        $this->load('core/Session');
        $this->load('core/Model');
        $this->load('core/Auth');
    }
    
    public function index(){
        include dirname(__FILE__).'/../config/auth.php';
        $this->model->log($this->utilisateur,get_class($this),LOG_DECONNEXION."[".$this->date_du_jour."]",0,$_SESSION['id']);
        if($auth['mode'] == 'cas'){
            $this->auth->CasLogout(true);
        }else{
            $_SESSION=array();
            session_destroy();
        }
        $this->redirect();
    }
}

