<?php
/**
 * Page Profil
 * vue : views/Private/profil/...
 * @author Walid Heddaji
 */

class Profil extends Controller {

    Public function __construct() {
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Formulaire','form');
        $this->load('core/Session');
        $this->load('core/Security');
        $this->session->CheckRight('profil', LECTURE);
    }

    public function index($id = NULL,$arg = NULL){
    	$this->traitement($id,$arg);
    	$this->formProfil($_SESSION['id']);
    }

    public function traitement($id,$arg){
    	$submit = "";
    	$post = $this->form->ProtectionFormulaire($_POST);
    	if(isset($_POST['submit'])) $submit = $_POST['submit'];

    	if(isset($_SESSION['id'])){
    		$id = $_SESSION['id'];
    		$this->model->table = "utilisateurs";
			//ENREGISTRER FORMULAIRE UTILISATEUR
			if($submit == "enregistrer" || $submit == "enregistrerEtFermer"){
				$this->session->CheckRight('profil', MODIFICATION);
				$data = array('nom'=>$post['nom'],
							  'prenom'=>$post['prenom'],
							  'mail'=>$post['email'],
							  'telephone'=>$post['telephone']);
				if($this->model->maj(array('id'=>$id),$data)){
					if($submit == "enregistrerEtFermer"){
                        $this->redirect();
					}
					$this->view('app/succes/notification','Les données sont bien enregistrées!');
				}else{
					$this->view('app/erreurs/erreur','Erreur lors de l\'enregistrement des données');
				}
			//REINITIALISER MOT DE PASSE
			}elseif($submit == 'reinitialiser'){
				$this->session->CheckRight('profil', MODIFICATION);
				if($post['pwd'] == $post['pwd2'] && !$post['pwd'] == "" && !$post['pwd2'] == ""){
					$salage = $this->security->generer_salage();
					$data = array('password'=>sha1($post['pwd']).$salage,
								  'salage'=>$salage);
					if($this->model->maj(array('id'=>$id),$data)){
						$this->view('app/succes/notification','Le mot de passe a bien été réinitialisé!');
					}else{
						//ERREUR
					}
				}else{
					if($post['pwd'] == "" || $post['pwd2'] == ""){
						$this->view('app/erreurs/erreur','Les champs mot de passe sont obligatoires!');
					}else{
						$this->view('app/erreurs/erreur','Les mots de passe ne sont pas identiques!');
					}
				}
			}
		}
		if($submit == "fermer"){
			$this->redirect("accueil");
		}
    }

    public function formProfil($id){
    	$this->model->table = "utilisateurs";
    	$data['utilisateur'] = $this->model->lecture(array('*'),array('id'=>$id));
    	$data['nom_groupe'] = $this->nomGroupe();
    	$this->viewPrivate('profil/index',$data);
    }

    public function nomGroupe(){
    	$id_groupe = $_SESSION['id_groupe'];
    	$this->model->table = "groupes";
    	$nom = $this->model->onerow('nom',array('id'=>$id_groupe));
    	return $nom;
    }
}