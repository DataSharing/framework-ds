<?php

Class Authentification extends Controller{
    
    static $instances=array();

    Public function __construct(){
        parent::__construct();
        $this->load('core/Model');
        $this->load('Erreur','ctrl_erreur');
        if (isset($_SESSION['id'])) {
           $this->redirect();
        }
    }
    
    Public function index($id = NULL){
        $this->ctrl_erreur->index($id);
        $this->traitements();
        $this->authentification();
    }
    
    public function authentification(){
        $this->view('app/authentification/index');
    }
    
    Private function traitements(){   
        if(isset($_POST) && isset($_POST['inputEmail']) AND isset($_POST['inputPassword'])){
            if($this->model->auth($_POST['inputEmail'],$_POST['inputPassword'])){
            }
        }       
    }
    
}

