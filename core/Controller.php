<?php

/**
 * Class Controller : Element principal du framework
 */
class Controller
{

    public $base_url;
    public $date_du_jour;
    public $ControllerPrincipal;
    public $nom_du_site;
    public $langage;
    public $rewrite;

    public $autoload_C;
    public $autoload_M;
    public $autoload_Ctr;

    public $mode_authentification;
    public $double_authentification;
    public $login;
    public $url_cas;
    public $get_cas;
    public $port_cas;

    public function __construct()
    {
        include dirname(__FILE__) . '/../config/config.php';
        include dirname(__FILE__) . '/../config/autoload.php';
        include dirname(__FILE__) . '/../config/auth.php';

        //AUTOLOAD.PHP
        $this->autoload_C = $autoload['core'];
        $this->autoload_Ctr = $autoload['controllers'];
        $this->autoload_M = $autoload['models'];

        //CONFIG.PHP
        $this->date_du_jour = $config['date_du_jour'];
        $this->base_url = $config['base_url'];
        $this->nom_du_site = $config['nom_du_site'];
        $this->controller_principal = $config['controller_principal'];
        $this->langage = $config['langage'];
        $this->rewrite = $config['rewrite'];

        //AUTH.PHP
        $this->mode_authentification = $auth['mode'];
        $this->double_authentification = $auth['code'];
        $this->login = $auth['login'];
        $this->url_cas = $auth['url_cas'];
        $this->get_cas = $auth['get_cas'];
        $this->port_cas = $auth['port_cas'];

        //AUTOLOAD CHARGEMENT
        //include(dirname(__FILE__).'/../core/Db.php');
        $this->app_autoload();
    }

    /**
     * Chargement de la fonction dans chaque page
     */
    public function app_autoload()
    {

        /**
         * Droits utilisateurs
         */
        if (!defined('LECTURE')) define('LECTURE', 7);
        if (!defined('MODIFICATION')) define('MODIFICATION', 77);
        if (!defined('SUPPRESSION')) define('SUPPRESSION', 777);
        if (!defined('ADMINISTRATEUR')) define('ADMINISTRATEUR', 7777);

        //Chargement de la librairie CAS si Auth activé
        if ($this->mode_authentification == 'cas') {
            include_once(dirname(__FILE__) . "/../lib/cas/CAS.php");
        }

        //Chargement du fichier de langage pour les controllers
        if (file_exists('./locales/' . $this->langage . '/' . strtolower(get_class($this)) . '.php')) {
            require  './locales/' . $this->langage . '/' . strtolower(get_class($this)) . '.php';
        }

        require dirname(__FILE__) . '/../locales/' . $this->langage . '/formulaire.php';
        require dirname(__FILE__) . '/../locales/' . $this->langage . '/succes.php';
        require dirname(__FILE__) . '/../locales/' . $this->langage . '/erreurs.php';
        require dirname(__FILE__) . '/../locales/' . $this->langage . '/logs.php';
    }

    /**
     * Chargement d'une class dans le dossier core ou helpers
     * Exemple : $this->load('core/Maclass.php','alias');
     * Utilisation: $this->alias->maFunction();
     * 
     * @param string $controller
     * @param string $alias
     * @return boolean : true=>retourne l'instance False=>erreur
     */
    public function load($controller, $alias = NULL)
    {
        $dossier = explode('/', $controller);
        $nb = count($dossier);
        if ($nb > 1) {
            $repertoire = $dossier[0];
            $controller = ucwords($dossier[1]);
        } else {
            $controller = ucwords($controller);
            $repertoire = 'controllers';
        }
        //echo dirname(__FILE__) . '/../' . $repertoire . '/' . $controller . '.php<br>';
        if (file_exists(dirname(__FILE__) . '/../' . $repertoire . '/' . $controller . '.php')) {
            if (!isset($this->$controller)) {
                include_once(dirname(__FILE__) . '/../' . $repertoire . '/' . $controller . '.php');
                if (!$alias) {
                    $controller = strtolower($controller);
                    $this->$controller = new $controller();
                    return $this->$controller;
                } else {
                    $alias = strtolower($alias);
                    $this->$alias = new $controller();
                    return $this->$alias;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Vue Public
     * Affichage de la vue et envoi de données 
     * @param string $path : fichier php
     * @param array $data : données à transferer dans la vue
     * @param boolean $error
     */
    public function view($path, $data = false, $error = false)
    {
        require "views/public/$path.php";
    }

    /**
     * Vue Privée
     * Affichage de la vue et envoi de données 
     * @param string $path : fichier php
     * @param array $data : données à transferer dans la vue
     * @param boolean $error
     */
    public function viewPrivate($path, $data = false, $error = false)
    {
        if (!isset($_SESSION['id'])) {
            header('location:' . $this->base_url . 'erreur/404');
        } else {
            require "views/private/$path.php";
        }
    }

    /**
     * Vue Plugin
     * Affichage de la vue et envoi de données 
     * @param string $path : fichier php
     * @param array $data : données à transferer dans la vue
     * @param boolean $error
     */
    public function viewPlugin($name, $path, $data = false, $error = false)
    {
        $view = strtolower("plugins/$name/views/$path.php");
        require $view;
    }

    /**
     * Redirection en se basant sur le mode rewrite
     * on : réécriture de l'url
     * off : variable url
     * 
     * @param string $url
     */
    public function redirect($url = NULL)
    {
        if ($this->rewrite == 'on') {
            header('location:' . $this->base_url . $url);
        } else {
            header('location:' . $this->base_url . "?p=" . $url);
        }
    }

    /**
     * Retourne l'url complète pour les liens
     *
     * @param string $url
     * @return string
     */
    public function echoRedirect($url = NULL)
    {
        if ($this->rewrite == 'on') {
            return $this->base_url . $url;
        } else {
            $url = str_replace('?', '&', $url);
            return $this->base_url . "?p=" . $url;
        }
    }

    /*
    Public function add_css($path = NULL,$place = 'header'){
        $array = array();
        if(is_array($path)){
            foreach($path as $css){
                $array = array($css);
            }
            $data['css'] = $array;
            this->view('app/'.$place,$data);
        }else{
            $data['css'] = $path;
            this->view('app/'.$place,$data);
        }
    }

    Public function add_js($path = NULL){
        if(is_array($path)){
            foreach($path as $js){
               echo '<script type="text/javascript" ';
               echo 'src="'.$this->base_url.'template/bootstrap/js/'.$js.'" >';
            }
        }else{
            echo '<script type="text/javascript" ';
               echo 'src="'.$this->base_url.'template/bootstrap/js/'.$path.'" >';
        }
    }
    */
}
