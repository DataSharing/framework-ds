<?php

/**
 * Page groupes
 * vue : views/Private/groupes/...
 *
 * @author walid.heddaji
 */
class Groupes extends Controller
{
    public $errors;

    public function __construct()
    {
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Formulaire', 'form');
        $this->load('core/Session');
        $this->session->CheckRight('groupes', LECTURE);
    }
    public function index($id = NULL, $arg = NULL)
    {
        if (isset($_GET['page'])) {
            $arg = NULL;
        }
        $this->traitement($id, $arg);
        if ($arg != NULL) {
            $this->formGroupe($arg);
        } else {
            $this->formIndex($id);
        }
        $this->viewPrivate('groupes/modal');
    }

    public function traitement($id, $arg)
    {
        $submit = "";
        if (isset($_POST['submit'])) {
            $this->session->CheckRight('groupes', MODIFICATION);
            $submit = $_POST['submit'];
        }
        $post = $this->form->ProtectionFormulaire($_POST);
        $get = $this->form->ProtectionFormulaire($_GET);
        /**
        Enregistrer / Enregistrer & fermer
        _POST(
        nom
        description
        )
         */
        if ($submit == "enregistrer" || $submit == "enregistreretfermer") {
            $donnees = array('nom', 'description');
            $required = array('nom');
            if ($arg && $this->form->validate($donnees, $required)) {
                //mise à jour du formulaire
                $this->model->table = "groupes";
                $data = array(
                    'nom' => $post['nom'],
                    'description' => $post['description']
                );
                if ($this->model->maj(array('id' => $arg), $data)) {
                    /*
                    Mise à jour des droits
                    _POST(
                    controllers (array)
                    lecture_controller*
                    modification_controller*
                    suppression_controller
                    )

                    * controller signifie le nom du controller
                    exemple:
                    - lecture_accueil
                    - modification_accueil
                    - lecture_tableau_de_bord
                    - suppression_utilisateurs
                    Et ceux qui n'appraissent pas sont décochés donc le groupe
                    n'a pas le droit en question
                    */
                    $controllers = isset($_POST['controllers']) ? $post['controllers'] : [];
                    if ($this->majDroits($controllers, $post, $arg)) {
                        if ($submit == "enregistreretfermer") {
                            $this->redirect('groupes');
                        } else {
                            $this->view('app/succes/notification', 'Les données ont bien été enregistrées');
                        }
                    } else {
                        $this->view('app/erreurs/erreur', 'Erreurs lors de la mise à jour des droits');
                    }
                }
            }
        }
        /*
        Ajouter
        _POST(nom)

        */
        if ($submit == "ajouter") {
            $donnees = array('nom', 'description');
            $required = array('nom');
            if ($this->form->validate($donnees, $required)) {
                $this->model->table = "groupes";
                if ($this->model->insertion(array('nom' => $post['nom'], 'description' => "", 'est_archive' => 0))) {
                    $this->view('app/succes/notification', 'Le groupe <b>' . $post['nom'] . '</b> a bien été ajouté');
                } else {
                    $this->view('app/erreurs/erreur', 'Erreurs lors de l\'insertion du groupe');
                }
            }
        }
        /*
        Supprimer
        _POST(id)
        */
        if ($submit == "supprimer") {
            $this->session->CheckRight('groupes', SUPPRESSION);
            $this->model->table = "droits";
            if ($this->model->delete(array('id' => $arg))) {
                $this->model->table = "groupes";
                if ($this->model->delete(array('id' => $arg))) {
                    $this->redirect('groupes');
                } else {
                    $this->view('app/erreurs/erreur', 'Erreurs lors de la suppression du groupe');
                }
            }
        }
        /*
        Archivage _POST(id)
        */
        if ($submit == "archiver") {
            if ($arg) {
                if (!isset($get['est_archive'])) {
                    $archive = 1;
                    $etat = "archivé";
                } else {
                    $archive = 0;
                    $etat = "restauré";
                }
                $this->model->table = "groupes";
                if ($this->model->maj(array('id' => $arg), array('est_archive' => $archive))) {
                    $this->view('app/succes/notification', 'Le groupe a bien été ' . $etat);
                } else {
                    $this->view('app/erreurs/erreur', 'Erreurs lors de l\'archivage ou de la restauration du groupe');
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

    /**
        Mise à jour des droits
        _POST(
            controllers (array)
            lecture_controller*
            modification_controller*
            suppression_controller
        )
        
     * controller signifie le nom du controller
        exemple:
            - lecture_accueil
            - modification_accueil
            - lecture_tableau_de_bord
            - suppression_utilisateurs
        Et ceux qui n'appraissent pas sont décochés donc le groupe
        n'a pas le droit en question
     */

    public function majDroits(array $controllers, array $posts, int $id_groupe)
    {
        $this->model->table = "droits";
        if (!empty($controllers)) {
            foreach ($controllers as $controller) :
                //init variable
                $aSupprimer = array();
                $where = array();
                //Check Lecture
                if (isset($posts['lecture_' . $controller])) {
                    $where = array('id_groupe' => $id_groupe, 'controller' => $controller, 'droit' => 7);
                    if ($this->model->count($where, 'AND') == 0) {
                        //Deuxième where représente les données à insérer
                        //C'est les même que le where
                        //Donc pas besoin de refaire inutilement un array
                        //Valable pour tous
                        $this->model->insertion($where);
                    }
                } else {
                    $where = array('id_groupe' => $id_groupe, 'droit' => 7, 'controller' => $controller);
                    $this->model->delete($where, 'AND');
                }
                //check Modification
                if (isset($posts['modification_' . $controller])) {
                    $where = array('id_groupe' => $id_groupe, 'controller' => $controller, 'droit' => 77);
                    if ($this->model->count($where, 'AND') == 0) {
                        $this->model->insertion($where);
                    }
                } else {
                    $where = array('id_groupe' => $id_groupe, 'droit' => 77, 'controller' => $controller);
                    $this->model->delete($where, 'AND');
                }
                //Check suppression
                if (isset($posts['suppression_' . $controller])) {
                    $where = array('id_groupe' => $id_groupe, 'controller' => $controller, 'droit' => 777);
                    if ($this->model->count($where, 'AND') == 0) {
                        $this->model->insertion($where);
                    }
                } else {
                    $where = array('id_groupe' => $id_groupe, 'droit' => 777, 'controller' => $controller);
                    $this->model->delete($where, 'AND');
                }
            endforeach;
        }
        return true;
    }

    public function formIndex($archives)
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

        $orderby['id'] = 'DESC';
        $operateur  = "";
        $data['r'] = "";
        $get = $this->form->ProtectionFormulaire($_GET);

        /* Other order by */
        $this->orderByOk = ['id', 'nom'];
        if (isset($_GET["orderby"]) && isset($_GET['mode'])) {
            /* Sécuritée pour les changements directement via l'url */
            if (in_array($_GET['orderby'], $this->orderByOk)) {
                $orderby = array($_GET['orderby'] => $_GET['mode']);
            }
        }

        if ($archives == "archives") {
            $data['archives'] = 1;
            $where['est_archive'] = 1;
        } else {
            $data['archives'] = 0;
            $where['est_archive'] = 0;
        }

        if (isset($get['r'])) {
            $data['r'] = $get['r'];
            $where['nom'] = "%" . $get['r'] . "%";
            $operateur  = "AND";
        }

        $this->model->table = "groupes";
        $data['groupes'] = $this->model->lecture(
            [
                'SQL_CALC_FOUND_ROWS *',
            ],
            $where,
            $operateur,
            $orderby,
            $limit
        );

        $data['nb'] = $this->model->foundRows();
        $data['pagination'] =  $this->form->pagination($data['nb'], $page, $par_page, $where, $operateur, strtolower(__class__));
        $this->viewPrivate('groupes/index', $data);
    }

    public function formGroupe($id)
    {
        $data['id'] = $id;
        $this->model->table = "groupes";
        $data['groupe'] = $this->model->lecture(array('*'), array('id' => $id));
        //Droits_groupes n'est pas une table
        //C'est  une VUE
        $this->model->table = "droits_groupes";
        $data['droits'] = $this->model->lecture(array('*'), array('id_groupe' => $id));
        $plugins = $this->model->lecture(array('*'), array('controller' => 'plugin_%', 'id_groupe' => $id), 'AND');
        $data['droitsPlugins'] = array();
        foreach ($plugins as $plugin) {
            $data['droitsPlugins'][$plugin['controller']] = $plugin['droit'];
        }
        $this->model->table = "plugins";
        $data['plugins'] = $this->model->lecture();
        $this->model->table = "utilisateurs";
        $data['utilisateurs_groupe'] = $this->model->lecture(['id', 'nom', 'prenom'], ['id_groupe' => $id], '', ['nom' => 'asc']);
        $this->viewPrivate('groupes/groupe', $data);
    }
}
