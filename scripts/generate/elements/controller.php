<?php
/**
 * Page Generate
 * vue : views/public/generate
 *  * @author Walid H.
 */
Class Generate extends Controller{

    Public $success;
    Public $errors;

    public function __construct(){
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Formulaire','form');
        $this->load('core/Session');
        $this->session->CheckRight('generate',LECTURE);
    }

    public function index($id = NULL,$arg = NULL){
        $recherche = $this->recherche($_POST);
        $this->traitement($id,$arg);
        $this->indexForm();
    }

    public function traitement($id,$arg){
    	$submit = $_POST['submit'] ?? '';

    	if($_POST){
            $post = $this->form->protectionFormulaire($_POST);
            /*** Ajouter */
            if($submit == "ajouter"){
                $this->session->CheckRight('generate',MODIFICATION);
                $donnees = array();
                $required = array();
                if($this->form->validate($donnees,$required)){
                    $data = array();
                    $this->model->table = "";
                    if($this->model->insetion($data)){
                        $this->success[] = "";
                    }else{
                        $this->errors[] = "";
                    }
                }
            }

            /*** Enregistrer */
            if($submit == "enregistrer" || $submit == "enregistreretfermer" && $arg != null){
                $this->session->CheckRight('generate',MODIFICATION);
                $donnees = array();
                $required = array();
                if($this->form->validate($donnees,$required)){
                    $data = array();
                    $this->model->table = "";
                    if($this->model->maj(array('id'=>$arg),$data)){
                        $this->success[] = "";
                    }else{
                        $this->errors[] = "";
                    }
                }
            }

            /*** Supprimer */
            if($submit == "supprimer" && $arg != null){
                $this->session->CheckRight('generate',SUPPRESSION);
                $this->model->table = "";
                if($this->model->delete(array('id'=>$arg))){
                    $this->success[] = "";
                }else{
                    $this->errors[] = "";
                }
            }
        }

        //Gestion des notification
        if(count($this->success) >= 1){
            $this->view('app/success/notification',$this->success);
        }

        if (count($this->errors) >= 1) {
            $this->view('app/erreurs/erreurs', $this->errors);
        }

        if (count($this->form->errors) >= 1) {
            $this->view('app/erreurs/erreurs', $this->form->errors);
        }

    }

    public function recherche($varPost) {
        $recherche = array();
        $post = $this->form->protectionFormulaire($varPost);
        if (isset($post['recherche']) && !empty($post['recherche'])) {
            $recherche['example'] = "%".$post['recherche']."%";
        }
        return $recherche;
    }

    public function indexForm(){
        $this->model->table = "";
        $data[""] = $this->model->lecture();
        $this->viewPrivate('generate/index',$data);
    }

    public function generateForm($id){
        $this->model->table = "";
        $data[""] = $this->model->lecture(array('*'),array('id'=>$id));
        $this->viewPrivate('generate/generate',$data);
    }
}

