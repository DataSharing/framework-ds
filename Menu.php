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

        if(isset($_GET['theme']))
        {
            $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : "navbar-dark bg-dark";
            $get = isset($_GET['p']) ? $_GET['p'] : "";
            if($theme == "navbar-corbeille bg-corbeille")
            {

            }elseif($theme == "navbar-dark bg-dark")
            {
                $_SESSION['theme'] = "navbar-light bg-light";
                $this->redirect(str_replace('theme', '', $get));
            }else{
                $_SESSION['theme'] = "navbar-dark bg-dark";
                $this->redirect(str_replace('theme', '', $get));
            }
        }

        if(isset($_GET['corbeille']))
        {  
            if(!isset($_SESSION['old_theme']))
            {
                $_SESSION['old_theme'] = $_SESSION['theme'];
            }

            $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : "navbar-dark bg-dark";
            $get = isset($_GET['p']) ? $_GET['p'] : "";
            if($theme == "navbar-corbeille bg-corbeille")
            {
                if($_SESSION['old_theme'] == "navbar-corbeille bg-corbeille")
                {
                    $_SESSION['theme'] = "navbar-dark bg-dark";
                }else{
                     $_SESSION['theme'] = $_SESSION['old_theme'];
                }

                $_SESSION['acces_corbeille'] = 0;
                unset($_SESSION['old_theme']);
                $this->redirect(str_replace('theme', '', $get));
            }else{
                $_SESSION['theme'] = "navbar-corbeille bg-corbeille";
                $_SESSION['acces_corbeille'] = 1;
                $this->redirect(str_replace('corbeille', '', $get));
            }
        }
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
