<?php

Class Deconnexion extends Controller{
    function __construct() {
        parent::__construct();
        $this->load('core/Session');
        $this->load('core/Model');
    }
    public function index(){
        $this->model->log($this->utilisateur,get_class($this),LOG_DECONNEXION."[".$this->date_du_jour."]",0,$_SESSION['id']);
        $_SESSION=array();
        session_destroy();
        $this->redirect("login");
    }
}

