<?php

/**
 * Page Utilisateurs
 * vue : views/Private/utilisateurs/...
 * @author Walid Heddaji
 */
class Utilisateurs extends Controller
{
	public $errors = [];

	public function __construct()
	{
		parent::__construct();
		$this->load('core/Model');
		$this->load('core/Formulaire', 'form');
		$this->load('helpers/Selects');
		$this->load('core/Session');
		$this->load('core/Security');
		/* Restriction pour accès ADMIN */
		$this->session->CheckRight('utilisateurs', LECTURE);
	}

	public function index($id = NULL, $arg = NULL)
	{
		if (isset($_GET['page'])) {
			$arg = NULL;
		}
		$this->traitement($id, $arg);
		$this->view('app/modals/confirmation.suppression');

		if (empty($id)) {
			$this->indexForm();
		} else {
			if ($id == "archives") {
				$this->indexForm($id);
			} else {
				$this->utilisateurForm($id);
			}
		}
	}

	public function traitement($id, $arg)
	{
		$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
		$post = $this->form->ProtectionFormulaire($_POST);

		if ($_POST) {
			if (!$id == NULL) {
				//ENREGISTRER FORMULAIRE UTILISATEUR
				if ($submit == "enregistrer" || $submit == "enregistrerEtFermer") {
					$this->session->CheckRight('utilisateurs', MODIFICATION);
					$donnees = array('nom', 'prenom', 'email', 'telephone');
					$required = array('nom', 'prenom', 'email');
					$data = array(
						'nom' => $post['nom'],
						'prenom' => $post['prenom'],
						'mail' => $post['email'],
						'telephone' => $post['telephone']
					);
					if ($this->form->validate($donnees, $required)) {
						$this->model->table = "utilisateurs";
						if ($this->model->maj(array('id' => $id), $data)) {
							if ($submit == "enregistrerEtFermer") {
								$this->redirect("utilisateurs");
							}
							$this->view('app/succes/notification', 'Les données sont bien enregistrées!');
						} else {
							$this->view('app/erreurs/erreur', 'Erreur lors de l\'enregistrement des données');
						}
					}
				}

				//REINITIALISER MOT DE PASSE
				if ($submit == 'reinitialiser') {
					$this->session->CheckRight('utilisateurs', MODIFICATION);
					if ($post['pwd'] == $post['pwd2'] && !$post['pwd'] == "" && !$post['pwd2'] == "") {
						$salage = $this->security->generer_salage();
						$data = array(
							'password' => sha1($post['pwd']) . $salage,
							'salage' => $salage
						);
						$this->model->table = "utilisateurs";
						if ($this->model->maj(array('id' => $id), $data)) {
							$this->view('app/succes/notification', 'Le mot de passe a bien été réinitialisé!');
						} else {
							$this->view('app/erreurs/erreur', 'Erreur de base de données');
						}
					} else {
						if ($post['pwd'] == "" || $post['pwd2'] == "") {
							$this->view('app/erreurs/erreur', 'Les champs mot de passe sont obligatoires!');
						} else {
							$this->view('app/erreurs/erreur', 'Les mots de passe ne sont pas identiques!');
						}
					}
				}

				//ACTIVE OU DESACTIVE LE COMPTE
				//ACCES UTILISATEUR
				if ($submit == 'acces') {
					$this->session->CheckRight('utilisateurs', MODIFICATION);
					$this->model->table = "utilisateurs";
					$mdp = $this->model->onerow('password', array('id' => $id));
					if (!$mdp == NULL) {
						if ($this->model->maj(array('id' => $id), array('active' => $post['etatcompte'], 'id_groupe' => $post['groupes']))) {
							if ($post['etatcompte'] == 0) {
								$active = "désactivé";
							} else {
								$active = "activé";
							}
							$notif = array('L\'utilisateur a bien été enregistré dans le groupe <strong>' . $this->selects->groupes($post['groupes'], 1) . '</strong> et son compte à bien été <strong>' . $active . "</strong>");
							$this->view('app/succes/notification', $notif);
						} else {
							//ERREUR
						}
					} else {
						$this->view('app/erreurs/erreur', "Definir un mot de passe pour l'utilisateur!");
					}
				}

				//SUPPRIMER UTILISATEUR
				if ($submit == 'supprimer') {
					$this->session->CheckRight('utilisateurs', SUPPRESSION);
					$this->model->table = "utilisateurs";
					if ($this->model->delete(array('id' => $id))) {
						$this->redirect('utilisateurs');
					}
					//FERMER, REVENIR A LA LISTE USERS
				} elseif ($submit == 'fermer') {
					$this->redirect('utilisateurs');
				}
			}
			//** FORM ADD USER **// 
			if ($submit == "AjouterUtilisateur") {
				$this->session->CheckRight('utilisateurs', MODIFICATION);
				$donnees = array('nom', 'prenom', 'email', 'telephone', 'groupes');
				$required = array('nom', 'prenom', 'email', 'groupes');
				$data = array(
					'nom' => $post['nom'],
					'prenom' => $post['prenom'],
					'mail' => $post['email'],
					'telephone' => $post['telephone'],
					'id_groupe' => $post['groupes'],
					'date_creation' => $this->date_du_jour,
					'active' => 0
				);
				$this->model->table = "utilisateurs";
				if ($this->form->validate($donnees, $required)) {
					if ($this->model->insertion($data)) {
						//MSG OK
						$this->view('app/succes/notification', "L'utilisateur a bien été créé!");
					} else {
						//MSG ERREUR
					}
				}
			}
		}

		if (count($this->errors) >= 1) {
			$this->view('app/erreurs/erreurs', $this->errors);
		}

		if (count($this->form->errors) >= 1) {
			$this->view('app/erreurs/erreurs', $this->form->errors);
		}
	}

	public function indexForm($archives = '')
	{
		/* PAGINATION */
		$par_page = 30;
		if (isset($_GET["page"])) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}

		if ($page == '') {
			$page = 1;
		}

		if ($page == "all") {
			$limit = [];
		} else {
			$suivant = ($page - 1) * $par_page;
			$limit = array('par_page' => $par_page, 'suivant' => $suivant);
		}
		/* PAGINATION */

		$orderby['u.id'] = 'DESC';
		$operateur  = "";
		$data['r'] = "";
		$operateur = "";
		$get = $this->form->ProtectionFormulaire($_GET);

		/* Other order by */
		$this->orderByOk = ['u.id', 'u.active', 'u.nom', 'g.nom', 'u.date_creation'];
		if (isset($_GET["orderby"]) && isset($_GET['mode'])) {
			/* Sécuritée pour les changements directement via l'url */
			if (in_array($_GET['orderby'], $this->orderByOk)) {
				$orderby = array($_GET['orderby'] => $_GET['mode']);
			}
		}

		if ($archives == "archives") {
			$data['archives'] = 1;
			$where['u.est_archive'] = 1;
		} else {
			$data['archives'] = 0;
			$where['u.est_archive'] = 0;
		}

		if (isset($get['r'])) {
			$data['r'] = $get['r'];
			$where['u.nom'] = "%" . $get['r'] . "%";
			$operateur  = "AND";
		}

		$this->model->table = "utilisateurs u";
		$this->model->leftjoin = ['groupes g' => 'g.id=u.id_groupe'];
		$data['all'] = $this->model->lecture(
			[
				'SQL_CALC_FOUND_ROWS u.*',
				'u.id',
				'u.nom',
				'u.prenom',
				'u.active',
				'u.mail',
				'u.date_creation',
				'g.nom as groupe',
			],
			$where,
			$operateur,
			$orderby,
			$limit
		);

		$data['nb'] = $this->model->foundRows();
		$data['pagination'] =  $this->form->pagination($data['nb'], $page, $par_page, $where, $operateur, strtolower(__class__));
		$this->viewPrivate('utilisateurs/index', $data);
	}

	public function utilisateurForm(int $id)
	{
		$this->model->table = "utilisateurs";
		$data['utilisateur'] = $this->model->lecture('*', array('id' => $id));
		$this->model->table = "logs";
		$data['historique'] = $this->model->lecture('*', array('id_utilisateur' => $id), '', array('id' => 'desc'), array('par_page' => 30, 'suivant' => 0));
		$this->viewPrivate('utilisateurs/utilisateur', $data);
	}
}
