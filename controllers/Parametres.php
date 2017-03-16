<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parametres
 *
 * @author walid.heddaji
 */
class Parametres extends Controller{
    public function __construct(){
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Formulaire','form');
        $this->load('core/Session');
        $this->load('core/Security');
        $this->load('helpers/Serveur');
        $this->session->CheckRight('parametres',LECTURE);
    }

    public function index($id = NULL,$arg = NULL){
        if($id == 'succes'){ 
            $this->FormRedirection();
        }else{
            if($arg == 'maj'){
                $this->view('app/succes/notification',FORM_ENREGISTRER);
            }
            $this->traitements();
            $this->configurations();
        }
    }
    
    public function configurations(){
        $data['page'] = 0;
        if(isset($_GET['page'])) $data['page'] = $_GET['page'];
        $this->viewPrivate('parametres/index',$data);
    }
    
    public function traitements(){
        $submit = '';
        if(isset($_POST['submit'])){
            $this->session->CheckRight('parametres',MODIFICATION);
            $submit = $_POST['submit'];
        }
        $post = $this->form->ProtectionFormulaire($_POST);
        if($submit == 'modifierGeneral'){
            $data = array('nom_du_site'=>$post['nom_du_site'],
                          'base_url'=>$post['base_url'],
                          'langage'=>$post['langues'],
                          'controller_principal'=>$post['controllers']);
            if($this->majFichier($data,'config')){
                $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTRER."[config.php]");
                $this->redirect('parametres/succes');
            }else{
                $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTREMENT_DONNEES_ERREUR.'[config.php]');
                $this->view('app/erreurs/notification',FORM_ENREGISTREMENT_DONNEES_ERREUR);
            }
        }elseif($submit == 'modifierBdd'){
            if($this->TestConnection($post['hostname'],$post['namebdd'],$post['userbdd'],$post['passbdd'])){            
                $data = array('hostname'=>$post['hostname'],
                              'namebdd'=>$post['namebdd'],
                              'userbdd'=>$post['userbdd'],
                              'passbdd'=>$post['passbdd'],
                              'prefixebdd'=>$post['prefixebdd']);
                if($this->majFichier($data,'database')){
                    $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTRER."[database.php]");
                    $this->redirect('parametres/succes');
                }else{
                    $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTREMENT_DONNEES_ERREUR."[database.php]");
                    $this->view('app/erreurs/notification',FORM_ENREGISTREMENT_DONNEES_ERREUR);
                }
            }else{
                echo "<div class='alert alert-danger'>".$this->msgerror."</div>";
            }
        }elseif($submit == 'testBdd'){
            $testCo = $this->TestConnection($post['hostname'],$post['namebdd'],$post['userbdd'],$post['passbdd']);
            if($testCo){            
                $this->view('app/succes/notification',FORM_CONNEXION_BDD_OK);
            }else{
                $this->view('app/erreurs/notification',FORM_CONNEXION_BDD_ERREUR." [".$this->msgerror."]");
            }
        }elseif($submit == 'modifierAuth'){
            $data = array('url_cas'=>isset($post['url_cas']),
                          'get_cas'=>isset($post['get_cas']),
                          'mode'=>isset($post['mode'][0]),
                          'port_cas'=>isset($post['port_cas']));
            if($this->majFichier($data,'auth')){
                $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTRER."[auth.php]");
                $this->redirect('parametres/succes');
            }else{
                $this->model->log($this->utilisateur,get_class($this),FORM_ENREGISTREMENT_DONNEES_ERREUR."[auth.php]");
                $this->view('app/erreurs/notification',FORM_ENREGISTREMENT_DONNEES_ERREUR);
            }
        }
    }
    
    public function FormGeneral(){
        $dir = "./controllers";
        $dh  = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
             $files[] = $filename;
        }
        $data['fichiers'] = $files;
        
        $this->viewPrivate('parametres/general',$data);
    }
    
    public function FormBdd(){
        $this->viewPrivate('parametres/bdd');
    }
    
    public function FormAuth(){
        $this->viewPrivate('parametres/auth');
    }
    
    public function FormRedirection(){
         $this->viewPrivate('parametres/actions/redirection');
    }
    
    public function FormLogs(){
        $this->model->table = 'logs';
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
        if($page == ''){$page =1;}
        $par_page = 25;
        $suivant = ($page-1) * $par_page; 		
        $data['logs'] = $this->model->lecture('*',array(),'',array('date_modification'=>'desc'),array('par_page'=>$par_page,'fin'=>$suivant));
        $this->viewPrivate('parametres/logs',$data);
        $this->form->pagination('logs',$page,$par_page);
    }
    
    public function filtre($fichier){
        $file = explode('.php',$fichier);
        $derniereLettre = substr($file[0], -1);
        if($file[0] == 'Succes' || $file[0] == 'Erreur' || $file[0] == 'Login' || $file[0] == 'Deconnexion' || $file[0] == '' || $file[0] == '.' || $file[0] == '..'){
        }else{
            if($derniereLettre == 's' || $file[0] == 'Accueil'){
                return $file[0];
            }
        }
    }
    
    public function ActionsGeneral(){
        $this->viewPrivate('parametres/actions/general');
    }
    
    public function ActionsBdd(){
        $this->viewPrivate('parametres/actions/bdd');
    }
    
    public function ActionsAuth(){
        $this->viewPrivate('parametres/actions/auth');
    }
    
    public function majFichier($data = array(),$nom){
        $fichier= "./config/".$nom.".php";
        // ouverture du fichier
        if ($config = fopen($fichier, 'r+b') or die('Impossible')){
            // lecture du fichier (le pointeur se retrouve à la fin)
            if ($content = fread($config, filesize($fichier))){
                foreach($data as $key=>$value){
                    $var = "'".$key."'";
                    // remplacement de la variable
                    $content = preg_replace('`\$'.$nom.'\['.$var.'\]\s*=\s*\'.*?\'\s*;`s', '$'.$nom.'['.$var.'] = \''.$value.'\';', $content);
                }
                rewind($config); // on remet le pointeur au début du fichier
                ftruncate($config, 0); // on efface le contenu
                fwrite($config, $content); // on écrit le nouveau contenu
                fclose($config);
            }
        }
        return true;
    }
    
    function TestConnection($hostname,$namebdd,$userbdd,$pwdbdd){
        $DB = NULL;
        Try {
                $DB = new PDO("mysql:host=" . $hostname . ";dbname=" . $namebdd . "", "" . $userbdd . "", "" . $pwdbdd . "");
                $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $DB;
                return true;
        } catch (PDOException $e) {
                $this->msgerror = 'Échec lors de la connexion : ' . $e->getMessage();
        }
    }
}
