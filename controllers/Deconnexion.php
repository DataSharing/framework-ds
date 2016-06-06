<?php

Class Deconnexion extends Controller{
    function __construct() {
        parent::__construct();
        $this->app_autoload();
    }
    public function index(){
        session_start();
        $_SESSION=array();
        session_destroy();
        $this->model->log($this->utilisateur,get_class($this),LOG_DECONNEXION."[".$this->date_du_jour."]");
        header("location: " . $this->base_url . "login" ) ;
    }
}

