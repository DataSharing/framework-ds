<?php
/**
 * Class Session : Informations et verification de la session
 */
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

    /*
     * Si la variable de session n'existe pas, on redirige sur la page de login
     */
    Public function VerifSession(){ 
        if(!isset($_SESSION['id'])){
            header("Location : " . $this->base_url . "login");
        }else{
            return false;
        }
    }   
    
    /**
     * Informations de session pratique (utilisation, nom, prenom, mail, id groupe)
     * Variable disponible au chargement de la CLASS
     * 
     * @return string
     */
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
            if(!isset($_SESSION['id_groupe'])){
                $_SESSION['id_groupe'] = $data['id_groupe'];
            }
        }
        $this->utilisateur = $this->nom . " " . $this->prenom;
    }
    /**
        7       : Lecture
        77      : Mise à jour
        777     : Suppression
        7777    : Administrateur/Big BOSS

     * Verification des droits 
     * 
     * @param string $controller
     * @param int $right
     * @return boolean
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

    /**
     * Vérification des droits pour le MENU
     * 
     * @param string $controller
     * @param int $right
     * @return boolean
     */
    public function CheckRightMain(string $controller, int $right){
        $id_groupe = $_SESSION['id_groupe'];
        $this->model->table = "droits";
        $data['verification'] = $this->model->lecture(array('id'),array('controller'=>$controller,'droit'=>$right,'id_groupe'=>$id_groupe),'AND');
        if(!count($data['verification']) == 1){
            return false;
        }
        return true;
    }
}