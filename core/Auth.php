<?php
class Auth extends Controller{
    
    Public function __construct(){
        parent::__construct();
        $this->app_autoload();
    }
    
    public function CheckAuth($get){      
        switch ($this->mode_authentification) {
            case 'cas':
                $this->CasAuth();
                break;           
            case 'app':
                $this->AppAuth($get);
                break;
        }    
    }
    
    public function AppAuth($get){
        $router = New Router();
        $router->rt($get,false);
    }
    
    public function CasClient(){
        phpCAS::setDebug();
        phpCAS::setVerbose(true);
        phpCAS::client(CAS_VERSION_3_0,$this->url_cas,intval($this->port_cas),$this->get_cas);
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();
    }
    
    public function CasAuth(){
        $this->CasClient();
        if($this->CasAuthVerificationUserExist(phpCas::getuser())){
            header('Location:' . $this->base_url . $this->ControllerPrincipal);
        }else{
            $this->view('erreurs/droits');
        }
    }
    
    public function CasAuthVerificationUserExist($utilisateur = ''){
        if(!$utilisateur){header('location:'.$this->base_url);}
        $this->model->table = 'utilisateurs';
        $select = array('id','identifiant');
        $all_id = $this->model->lecture($select);
        foreach($all_id as $u){
            if($utilisateur == $u['identifiant']){
                $_SESSION['id'] = $u['id'];
                $this->model->log($u['identifiant'],get_class($this),LOG_CONNEXION."[".$this->date_du_jour."]");
                return true;
            }
        }
        return false;
    }
    
    public function CasLogout(){
        if(isset($_REQUEST['logout'])){
            $this->CasClient();
            $this->model->log($this->session->identifiant,get_class($this),LOG_DECONNEXION."[".$this->date_du_jour."]");
            session_destroy();
            phpCAS::logout();
            exit;
        }
    }
    
    
}