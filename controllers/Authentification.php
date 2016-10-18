<?php
include_once(dirname(__FILE__).'/../core/Db.php');

Class Authentification extends Controller{
    
    Public function __construct(){
        parent::__construct();
        $this->app_autoload();
        if (isset($_SESSION['id'])) {
           header('Location:' . $this->base_url . ' index.php');
        }
    }
    
    Public function index($id = NULL){
		$this->erreur->index($id);
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

