<?php

class Controller{   
    
    Public $base_url;
    Public $date_du_jour;
    Public $ControllerPrincipal;
    Public $nom_du_site;
    Public $langage;
    Public $utilisateur;
    
    Public $autoload_C;
    Public $autoload_M;
    Public $autoload_Ctr;
    
    Public $mode_authentification;
    Public $double_authentification;
    Public $login;
    Public $url_cas;
    Public $get_cas;
    Public $port_cas;
    
    public function __construct(){
        include dirname(__FILE__).'/../config/config.php';
        include dirname(__FILE__).'/../config/autoload.php';
        include dirname(__FILE__).'/../config/auth.php';
        
        //AUTOLOAD.PHP
        $this->autoload_C = $autoload['core'];
        $this->autoload_Ctr = $autoload['controllers'];
        $this->autoload_M = $autoload['models'];
        
        //CONFIG.PHP
        $this->date_du_jour = $config['date_du_jour'];
        $this->base_url = $config['base_url'];
        $this->nom_du_site = $config['nom_du_site'];
	    $this->controller_principal = $config['controller_principal'];
        $this->langage = $config['langage'];      
        
        //AUTH.PHP
        $this->mode_authentification = $auth['mode'];
        $this->double_authentification = $auth['code'];
        $this->login = $auth['login'];   
        $this->url_cas = $auth['url_cas'];
        $this->get_cas = $auth['get_cas'];
        $this->port_cas = $auth['port_cas'];

        //AUTOLOAD CHARGEMENT
        //include(dirname(__FILE__).'/../core/Db.php');
    }
    
    public function app_autoload(){
        //CORE CLASS
        $class = $this->autoload_C;
        if(!$class == ''){
            foreach($class as $al=>$alias){
                if($alias == ''){$alias = NULL;}
                if(!class_exists($al)){
                    //echo $al." / ".$alias."<br>";
                    $this->load('core/'.$al,$alias);
                }
            }
        }
        
        //MODELS CLASS
        $class = $this->autoload_M;
        if(!$class == ''){
            foreach($class as $al=>$alias){
                if($alias == ''){$alias = NULL;}
                if(!class_exists($al)){
                    $this->load('models/'.$al,$alias);
                }
            }
        }
        
        //CONTROLLERS CLASS
        $class = $this->autoload_Ctr;
        if(!$class == ''){
            foreach($class as $al=>$alias){
                if($alias == ''){$alias = NULL;}
                if(!class_exists($al)){
                    //echo $al." / ".$alias."<br>";
                    $this->load('controllers/'.$al,$alias);
                }
            }
        }
        
        //Chargement de la librairie CAS si Auth activé
        if($this->mode_authentification == 'cas'){
            include_once(dirname(__FILE__)."/../lib/cas/CAS.php");
        }
        
        //Chargement du fichier de langage pour les controllers
        if(file_exists('./locales/'.$this->langage.'/'.strtolower(get_class($this)).'.php')){
            require  './locales/'.$this->langage.'/'.strtolower(get_class($this)).'.php';
        }
        
        require './locales/'.$this->langage.'/formulaire.php';
        require './locales/'.$this->langage.'/succes.php';
        require './locales/'.$this->langage.'/erreurs.php';
        require './locales/'.$this->langage.'/logs.php';
        $this->utilisateur = $this->session->nom." ".$this->session->prenom;
    }
    
    Public function load($controller, $alias = NULL){
        $dossier = explode('/',$controller);
        $nb = count($dossier);
        if($nb > 1){
            $repertoire = $dossier[0];
            $controller = ucwords($dossier[1]);
        }else{
            $controller = ucwords($controller);
            $repertoire = 'controllers';            
        }
        /*
        if(is_a($this->$controller,$controller)){
            return "";
        }*/
        //echo dirname(__FILE__).'/../' . $repertoire . '/' . $controller . '.php<br>';
        if(file_exists(dirname(__FILE__).'/../' . $repertoire . '/' . $controller . '.php')){
            include_once(dirname(__FILE__).'/../' . $repertoire . '/' . $controller.'.php');
            if(!$alias){
                $controller = strtolower($controller);
                $this->$controller = New $controller();
                //echo $controller."<br>";
                return $this->$controller;
            }else{
                $alias = strtolower($alias);
                $this->$alias = New $controller();
                return $this->$alias;
            }
        }else{
            return false;
        }
    }
    
    public function view($path,$data = false, $error = false){      
		require "views/public/$path.php";
	}
	
	public function viewPrivate($path,$data = false, $error = false){      
		if(!isset($_SESSION['id'])){
			header('location:'.$this->base_url.'erreur/404');
		}else{
			require "views/private/$path.php";
		}
	}
        
    Public function redirection($url = NULL){
        header('location:' . $this->base_url . $url);
    }

    /*
    Public function add_css($path = NULL,$place = 'header'){
        $array = array();
        if(is_array($path)){
            foreach($path as $css){
                $array = array($css);
            }
            $data['css'] = $array;
            this->view('app/'.$place,$data);
        }else{
            $data['css'] = $path;
            this->view('app/'.$place,$data);
        }
    }

    Public function add_js($path = NULL){
        if(is_array($path)){
            foreach($path as $js){
               echo '<script type="text/javascript" ';
               echo 'src="'.$this->base_url.'template/bootstrap/js/'.$js.'" >';
            }
        }else{
            echo '<script type="text/javascript" ';
               echo 'src="'.$this->base_url.'template/bootstrap/js/'.$path.'" >';
        }
    }
    */
    
}

