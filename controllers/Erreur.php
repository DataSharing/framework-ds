<?php
/**
 * Page Erreur
 * @author Walid Heddaji
 */
Class Erreur extends Controller{
    
    Public function __construct(){
        parent::__construct();    
    }
    
    public function index($code = NULL){
        if($code == NULL){$code = '0';}
        $fonction = "error" . $code;
        $this->$fonction();
    }
    
    Public function error0(){
        return '';
    }

    public function error404(){
        echo "<h1>Page introuvable, cette page n'existe pas!</h1>";
    }
    
    public function errorLogin(){  
        $this->view("app/erreurs/erreur","Login ou mot de passe incorrect!");
    }
    
    public function errorPwd(){
        $this->view("app/erreurs/erreur","Login ou mot de passe incorrect!");
    }
    
    public function errorActivation(){
        $this->view("app/erreurs/erreur","Votre compte est désactivé, veuillez contacter l'administrateur du site!");
    }
}