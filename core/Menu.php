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
        $this->view('menu/menu',$data);
    }

    public function MenuMembre(){
        $data['page_active'] = '';
        //$data['logout'] = $this->mode_authentification;
        //if(isset($_GET['p'])) $data['page_active'] = $_GET['p'];
        $this->view('menu/membre',$data);
    }
}
