<?php
/**
 * Page Utilisateurs
 * vue : views/Private/utilisateurs/...
 * @author Walid Heddaji
 */
Class Utilisateurs extends Controller{

	public function __construct(){
		parent::__construct();
		$this->load('core/Model');
		$this->load('core/Formulaire','form');
		$this->load('core/Session');
		$this->load('core/Security');
		/* Restriction pour accès ADMIN */
		$this->session->CheckRight('utilisateurs',LECTURE);
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
		if(isset($_POST['submit'])){
			$this->session->CheckRight('utilisateurs',MODIFICATION);
			$submit = $_POST['submit'];
		}

		if($id == "archives"){
			$this->FormListeUtilisateurs($id);
		}elseif(!$id == NULL){
			//ENREGISTRER FORMULAIRE UTILISATEUR
			if($submit == "enregistrer" || $submit == "enregistrerEtFermer"){
                            $data = array('nom'=>$post['nom'],
                                                      'prenom'=>$post['prenom'],
                                                      'mail'=>$post['email'],
                                                      'telephone'=>$post['telephone']);
                            if($this->model->maj(array('id'=>$id),$data)){
                                if($submit == "enregistrerEtFermer"){
                                    $this->redirect("utilisateurs");
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
					if($this->model->maj(array('id'=>$id),array('active'=>$post['etatcompte'],'id_groupe'=>$post['groupes']))){
						if($post['etatcompte'] == 0){
							$active = "désactivé";
						}else{
							$active = "activé";
						}
						$notif = array('Accès '.$post['groupes' ]. ' a bien été enregistré.','Le compte à bien été '.$active);
						$this->view('app/succes/notification',$notif);
					}else{
						//ERREUR
					}
				}else{
					$this->view('app/erreurs/erreur',"Definir un mot de passe pour l'utilisateur!");
				}
			//SUPPRIMER UTILISATEUR
			}elseif($submit == 'supprimer'){
				$this->session->CheckRight('utilisateurs',SUPPRESSION);
				if($this->model->delete(array('id'=>$id))){
                    $this->redirect('utilisateurs');
				}
			//FERMER, REVENIR A LA LISTE USERS
			}elseif($submit == 'fermer'){
                            $this->redirect('utilisateurs');
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
							  'id_groupe'=>$post['groupes'],
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
			$this->FormListeUtilisateurs($id);
		}
	}

	public function FormListeUtilisateurs($archives){
		$operateur  = "";
        $data['r'] = "";
        $operateur = "";
        $get = $this->form->ProtectionFormulaire($_GET);
		if($archives == "archives"){
            $data['archives'] = 1;
            $recherche['est_archive'] = 1;
        }else{
            $data['archives'] = 0;
            $recherche['est_archive'] = 0;
        }
     	if(isset($get['r'])){
            $data['r'] = $get['r'];
            $recherche['nom'] = "%".$get['r']."%";
            //$recherche['prenom'] = "%".$get['r']."%";
            $operateur  = "AND";
        }
		$data['all'] = $this->model->lecture(array('*'),$recherche,$operateur);
		$this->model->table = "groupes";
		$data['groupes'] = $this->model->lecture();
		$this->viewPrivate('utilisateurs/liste',$data);
	}

	public function FormUtilisateur(int $id){
		$data['utilisateur'] = $this->model->lecture('*',array('id'=>$id));
		$this->model->table = "logs";
		$data['historique'] = $this->model->lecture('*',array('id_utilisateur'=>$id),'',array('id'=>'desc'),array('debut'=>5,'fin'=>0));
		$this->model->table = "groupes";
		$data['groupes'] = $this->model->lecture();
		$this->viewPrivate('utilisateurs/utilisateur',$data);
	}

	public function nomGroupe(int $id){
		$this->model->table = "groupes";
		$nom = $this->model->onerow('nom',array('id'=>$id));
		return $nom;
	}

}
