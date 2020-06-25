<?php
/**
 * Class Menu : Gestion du menu
 */
class Menu extends Controller{
    Public function __construct(){
        parent::__construct();
        $this->load('core/Session');
        $this->load('core/Plugin');
        require dirname(__FILE__).'/../locales/'.$this->langage.'/menu.php';
    }
    
    public function index(){
        header('location:index.php'); 
    }

    public function date_du_jour_menu(){
        $jour = $this->EnFrJoursMois(date('D'),'j');
        $mois = $this->EnFrJoursMois(date('M'),'m');
        return $jour. " " . date('j') . " " . $mois;
    }

    public function MenuPrincipal(){
        /*
         * Mode Debug si plusieur profil
        if(isset($_POST['changerProfil'])){
            $_SESSION['id_groupe'] = $_POST['changerProfil'];
        }
         * 
         */
        $data['page_active'] = '';
        //$data['logout'] = $this->mode_authentification;
        if(isset($_GET['p'])) $data['page_active'] = $_GET['p'];
        $exid = explode('/',$data['page_active']);
        if($exid[0]!=="connexion"){
            $data['page_parent'] = $exid[0];
            $this->view('app/menu/menu',$data);
        }
    }
}
