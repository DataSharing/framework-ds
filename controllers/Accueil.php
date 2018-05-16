<?php
/**
 * Page Accueil
 * vue : views/Public/app/app.php
 *  * @author Walid Heddaji
 */
Class Accueil extends Controller{

	public function __construct(){
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Formulaire','form');
        $this->load('core/Session');
        //$this->session->CheckRight('accueil',LECTURE);
	}

    public function index($id = NULL,$arg = NULL){
        $this->traitement($id,$arg);
        $this->indexForm();
    }

    public function traitement($id,$arg){
    	$submit = $_POST['submit'] ?? '';
    	$donnees = array('nom','prenom');

    	if($_POST){
	    	if($this->form->validate($donnees,['nom','prenom']) == true){
	    		if($submit == "ajouter"){
	    			$this->session->CheckRight('accueil',MODIFICATION);
	    			var_dump($_POST);
	    		}
	    	}else{
	    		$this->view('app/erreurs/erreurs',$this->form->errors);
	    	}
	    }
    	
    }

    public function indexForm(){
    	$this->view('app/app');
    }
}

