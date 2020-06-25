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
        echo "<div class='container' style='width:350px;background:transparent'>";
        echo "<div class='alert alert-danger'>Login ou mot de passe incorrect!</div></div>";
    }
    
    public function errorPwd(){
        echo "<div class='container' style='width:350px;background:transparent'>";
        echo "<div class='alert alert-danger'>Login ou mot de passe incorrect!</div></div>";
    }
    
    public function errorActivation(){
        echo "<div class='container' style='width:350px;background:transparent'>";
        echo "<div class='alert alert-danger'>Votre compte est désactivé, veuillez contacter l'administrateur du site!</div></div>";
    }
}