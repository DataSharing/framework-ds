<?php

Class Utilisateurs extends Controller{

	public function __construct(){
		parent::__construct();
		$this->load('core/Model');
		$this->load('core/Formulaire','form');
		$this->load('core/Session');
		$this->load('core/Security');
		/* Restriction pour accès ADMIN */
		if($this->session->acces != 'admin'){
			header('location:'.$this->base_url);
		}
		$this->model->table = "utilisateurs";
	}
					
	public function index($id = NULL,$arg = NULL){
		if(isset($_GET['page'])){$arg = NULL;}
		$this->traitement($id,$arg);
		$this->view('app/modals/confirmation.suppression');
	}

	public function traitement($id,$arg){
		$submit = "";
		$post = $this->form->ProtectionFormulaire($_POST);
		if(isset($_POST['submit'])) $submit = $_POST['submit'];

		if(!$id == NULL){
			//ENREGISTRER FORMULAIRE UTILISATEUR
			if($submit == "enregistrer" || $submit == "enregistrerEtFermer"){
				$data = array('nom'=>$post['nom'],
							  'prenom'=>$post['prenom'],
							  'mail'=>$post['email'],
							  'telephone'=>$post['telephone']);
				if($this->model->maj(array('id'=>$id),$data)){
					if($submit == "enregistrerEtFermer"){
						header('location:'.$this->base_url."utilisateurs");
					}
					$this->view('app/succes/notification','Les données sont bien enregistrées!');
				}else{
					$this->view('app/erreurs/erreur','Erreur lors de l\'enregistrement des données');
				}
			//REINITIALISER MOT DE PASSE
			}elseif($submit == 'reinitialiser'){
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
			//ACTIVE OU DESACTIVE LE COMPTE
			//ACCES UTILISATEUR
			}elseif($submit == 'acces'){
				$mdp = $this->model->onerow('password',array('id'=>$id));
				if(!$mdp == NULL){
					if($this->model->maj(array('id'=>$id),array('active'=>$post['etatcompte'],'acces'=>$post['droits']))){
						if($post['etatcompte'] == 0){
							$active = "désactivé";
						}else{
							$active = "activé";
						}
						$notif = array('Accès '.$post['droits' ]. ' a bien été enregistré.','Le compte à bien été '.$active);
						$this->view('app/succes/notification',$notif);
					}else{
						//ERREUR
					}
				}else{
					$this->view('app/erreurs/erreur',"Definir un mot de passe pour l'utilisateur!");
				}
			//SUPPRIMER UTILISATEUR
			}elseif($submit == 'supprimer'){
				if($this->model->delete(array('id'=>$id))){
					header('location:'.$this->base_url."utilisateurs");
				}
			//FERMER, REVENIR A LA LISTE USERS
			}elseif($submit == 'fermer'){
				header('location:'.$this->base_url."utilisateurs");
			}
			//FORMULAIRE PRINCIPAL
			$this->FormUtilisateur($id);
		}else{
			//** FORM ADD USER **// 
			if($submit == "AjouterUtilisateur"){
				$data = array('nom'=>$post['nom'],
							  'prenom'=>$post['prenom'],
							  'mail'=>$post['email'],
							  'telephone'=>$post['telephone'],
							  'acces'=>$post['droits'],
							  'date_creation'=>$this->date_du_jour,
							  'active'=>0);
				if($this->model->insertion($data)){
					//MSG OK
					$this->view('app/succes/notification',"L'utilisateur a bien été créé!");
				}else{
					//MSG ERREUR
				}
			}
			//TOUJOURS AFFICHER LE FORMULAIRE PRINCIPAL
			$this->FormListeUtilisateurs();
		}
	}

	public function FormListeUtilisateurs(){
		$data['all'] = $this->model->lecture('*');
		$this->viewPrivate('utilisateurs/liste',$data);
	}

	public function FormUtilisateur($id){
		$data['utilisateur'] = $this->model->lecture('*',array('id'=>$id));
		$this->model->table = "logs";
		$data['historique'] = $this->model->lecture('*',array('id_utilisateur'=>$id),'',array('id'=>'desc'),array('debut'=>5,'fin'=>0));
		$this->viewPrivate('utilisateurs/utilisateur',$data);
	}

}
