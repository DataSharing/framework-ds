<?php

class Menu extends Controller{
    Public function __construct(){
        parent::__construct();
        $this->load('core/Session');
        require dirname(__FILE__).'/../locales/'.$this->langage.'/menu.php';
    }
    
    public function index(){
        header('location:index.php'); 
    }

    public function MenuPrincipal(){
        $data['page_active'] = '';
        //$data['logout'] = $this->mode_authentification;
        if(isset($_GET['p'])) $data['page_active'] = $_GET['p'];
		$exid = explode('/',$data['page_active']);
        $data['offres'] = "";
        $data['demandes'] = "";
        $data['prets'] = "";
        $data['color'] = "";
        if(isset($_GET['p'])){
          if($exid[0] == 'prets'){
            $data['offres'] = "";
            $data['demandes'] = "";
            $data['prets'] = "active";
            $data['color'] = "#f0ad4e";
          }elseif($exid[0] == 'demandes'){
            $data['offres'] = "";
            $data['demandes'] = "active";
            $data['prets'] = "";
            $data['color'] = "#c03000";
          }elseif($exid[0] == 'offres'){
            $data['offres'] = "active";
            $data['demandes'] = "";
            $data['prets'] = "";
            $data['color'] = "#5cb85c";
          }
        }
		if($exid[0]!=="connexion"){
            $data['page_parent'] = $exid[0];
			$this->view('app/menu/menu',$data);
		}
		if(!isset($exid[1])){
			if($exid[0]!=="connexion"){
				if($exid[0]!=="administration"){
					if($exid[0]!=="accueil"){
						//$this->view('app/recherche');
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
