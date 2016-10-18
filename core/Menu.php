<?php

class Menu extends Controller{
    Public function __construct(){
        parent::__construct();
        require dirname(__FILE__).'/../locales/'.$this->langage.'/menu.php';
        $this->app_autoload();
    }
    
    public function index(){
        header('location:index.php'); 
    }

    public function MenuPrincipal(){
        $data['page_active'] = '';
        //$data['logout'] = $this->mode_authentification;
        if(isset($_GET['p'])) $data['page_active'] = $_GET['p'];
		$exid = explode('/',$data['page_active']);
		if($exid[0]!=="connexion"){
			$this->view('app/menu/menu',$data);
		}
		if(!isset($exid[1])){
			if($exid[0]!=="connexion"){
				if($exid[0]!=="administration"){
					if($exid[0]!=="accueil"){
						$this->view('app/recherche');
					}
				}
			}
		}
    }

    public function MenuMembre(){
        $data['page_active'] = '';
        //$data['logout'] = $this->mode_authentification;
        //if(isset($_GET['p'])) $data['page_active'] = $_GET['p'];
        $this->view('app/menu/membre',$data);
    }
}
