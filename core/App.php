<?php
/*
 * Class App : Traitement du lancement de l'application
 * 
 */
Class App extends Controller{
   
   public function __construct(){
        parent::__construct();
        $this->load('core/Auth');
        $this->load('core/Menu');
        $this->load('core/Router');
        $this->load('core/Plugin');
    }

    public function __run(){
        include dirname(__FILE__).'/../config/styles.php';
        include dirname(__FILE__).'/../config/config.php';
        $dataPlugins = $this->plugin->_initPlugins();
        $data['jsPlugins'] = $dataPlugins['js'];
        $data['cssPlugins'] = $dataPlugins['css'];
        $data['nom_du_site'] = $config['nom_du_site'];
        $data['base_url'] = $config['base_url'];
        $data['css'] = $css;
        $data['js'] = $js;

        $data['others'] = $others;
        $get = '';
        if(isset($_GET['p'])) $get = htmlentities($_GET['p']);
        $data['page_active'] = $get;
        $this->view('app/header',$data);
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
        
}

