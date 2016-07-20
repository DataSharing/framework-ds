<?php

class Session extends Controller {
    
    Public $id;
    Public $nom;
    Public $prenom;
    Public $identifiant;
    Public $mail;
    
    Public function __construct() {
        parent::__construct();
        $this->load('core/Model','model');
        $this->model->table = 'utilisateurs';
        if(isset($_SESSION['id'])){
            $this->id = $_SESSION['id'];
            $this->Session();
        }
    }
    Public function VerifSession(){ 
        if(!isset($_SESSION['id'])){
            header("Location : " . $this->base_url . "login");
        }else{
            return false;
        }
    }   
    
    Public function Session(){
		if($this->id == 0){
            $this->prenom = "invité";
            $this->nom = "";
            //$this->identifiant = $data['identifiant'];
            $this->mail = "";
			return "";
		}
		
        $DonneesUtilisateur = $this->model->lecture('*',array('id'=>$this->id));
        foreach($DonneesUtilisateur as $data){
            $this->id = $data['id'];
            $this->prenom = $data['prenom'];
            $this->nom = $data['nom'];
            //$this->identifiant = $data['identifiant'];
            $this->mail = $data['mail'];
        }
    }
    
}