<?php
Class App extends Controller{

   public function __construct(){
        $this->load('core/menu');
        $this->load('core/Auth');
        $this->load('core/Router');
    }
    public function __run(){
        include dirname(__FILE__).'/../config/styles.php';
        include dirname(__FILE__).'/../config/config.php';
        $data['base_url'] = $config['base_url'];
        $data['css'] = $css;
        $data['js'] = $js;
        $get = '';
        if(isset($_GET['p'])) $get = htmlentities($_GET['p']);
        $this->view('app/header',$data);
        $this->auth->CasLogout();
        if (!isset($_SESSION['id'])) {
            $this->auth->CheckAuth($get);
        }else{
            $this->menu->MenuPrincipal();
            if($get){
                $this->router->rt($get);
            }else{
                $this->router->rt('CP');
            }
        }
        $data['js'] = $jsBottom;
        $data['css'] = '';
        $this->view('app/footer',$data);
    }

    public function chargement_modals(){
        //Tous les modals
        $dossier = dirname(__FILE__)."/../views/modals";
        $fichiers = scandir($dossier);
        foreach($fichiers as $fichier){
            $ex = explode('.',$fichier);
            echo '<form name="'.$ex[1].'" action="" method="post">';
                $this->view("modals/".$fichier);
            echo "</form>";
        }
    }

}
