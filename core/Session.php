<?php

class Session extends Controller {
    
    Public $id;
    Public $nom;
    Public $prenom;
    Public $identifiant;
    Public $mail;
    Public $utilisateur;
    
    Public function __construct() {
        parent::__construct();
        $this->load('core/Model');
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
            if(!isset($_SESSION['id_reference'])){
                $_SESSION['id_reference'] = $this->idReferenceGroupe($data['id_groupe']);
            }
            if(!isset($_SESSION['id_groupe'])){
                $_SESSION['id_groupe'] = $data['id_groupe'];
            }
            if(!isset($_SESSION['vue'])){
                if($data['vue'] == ""){
                    $data['vue'] = "jour";
                }
                $_SESSION['vue'] = $data['vue'];
            }
        }
        $this->utilisateur = $this->nom . " " . $this->prenom;
    }
    
    /**
     * 
     * @param type $idGroupe
     */
    public function idReferenceGroupe($idGroupe){
        $this->model->table = "groupes";
        $id = $this->model->onerow('id_reference',array('id'=>$idGroupe));
        return $id;
    }
    
    /*
        7       : Lecture
        77      : Mise à jour
        777     : Suppression
        7777    : Administrateur/Big BOSS

    */
    public function CheckRight(string $controller, int $right){
        $id_groupe = $_SESSION['id_groupe'];
        $this->model->table = "droits";
        $data['verification'] = $this->model->lecture(array('id'),array('controller'=>$controller,'droit'=>$right,'id_groupe'=>$id_groupe),'AND');
        if(!count($data['verification']) == 1){
            $this->view('app/erreurs/index','Vous n\'avez pas les droits nécessaire!');
            exit;
        }
        return true;
    }

     public function CheckRightType(string $controller, int $right){
        $id_groupe = $_SESSION['id_groupe'];
        $this->model->table = "droits";
        $data['verification'] = $this->model->lecture(array('id'),array('controller'=>$controller,'droit'=>$right,'id_groupe'=>$id_groupe),'AND');
        if(!count($data['verification']) == 1){
            return false;
        }
        return true;
    }

    public function CheckRightMain($controller, $right){
        $id_groupe = $_SESSION['id_groupe'];
        $this->model->table = "droits";
        $data['verification'] = $this->model->lecture(array('id'),array('controller'=>$controller,'droit'=>$right,'id_groupe'=>$id_groupe),'AND');
        if(!count($data['verification']) == 1){
            return false;
        }
        return true;
    }
}