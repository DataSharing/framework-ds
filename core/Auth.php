<?php
class Auth extends Controller{
    
    Public function __construct(){
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Security');
    }

    public function CheckAuth($get){      
        switch ($this->mode_authentification) {
            case 'cas':
                $this->CasAuth();
                break;           
            case 'app':
                $this->AppAuth($get);
                break;
			case 'public':
                $this->NoAuth();
                break;
        }    
    }
    
	public function NoAuth(){
		$_SESSION['id'] = 0;
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
        $attributes = phpCas::getAttributes();
        $mail = $attributes['mail'];
        if($this->CasAuthVerificationUserExist($mail)){
            header('Location:' . $this->base_url . $this->ControllerPrincipal);
        }else{
            /* A MODIFIER SELON L'INTEGRATION */
            $displayName = explode(' ',$attributes['displayName']);
            $nom = $displayName[0];
            $prenom = $displayName[1];
            $salage = $this->security->generer_salage();
            $pwd = $this->security->generer_salage(15);
            $this->model->table = "utilisateurs";
            $data = array('nom'=>$nom,
                          'prenom'=>$prenom,
                          'mail'=>$mail,
                          'telephone'=>"",
                          'id_groupe'=>3,
                          'salage'=>$salage,
                          'password'=>sha1($pwd),
                          'date_creation'=>$this->date_du_jour,
                          'active'=>1,
                          'est_archive'=>0);
            if($this->model->insertion($data)){     
                $_SESSION['id'] = $this->model->lastInsertId();
                $_SESSION['id_groupe'] = 3;
                $this->model->log($mail,get_class($this),LOG_CONNEXION."[".$this->date_du_jour."]");
                header('Location:' . $this->base_url . $this->ControllerPrincipal);
            }else{
                $this->view('app/erreurs/droits');
            }
        }
    }
    
    public function CasAuthVerificationUserExist($utilisateur = ''){
        if(!$utilisateur){header('location:'.$this->base_url);}
        $this->model->table = 'utilisateurs';
        $select = array('id','mail','id_groupe');
        $all_id = $this->model->lecture($select);
        foreach($all_id as $u){
            //A MODIFIER POUR QUE SE SOIT GENERIQUE
            if($utilisateur == $u['mail']){
                $_SESSION['id'] = $u['id'];
                $this->model->log($u['mail'],get_class($this),LOG_CONNEXION."[".$this->date_du_jour."]");
                return true;
            }
        }
        return false;
    }
    
    public function CasLogout($deconnexion = false){
        //if(isset($_REQUEST['logout'])){
        if($deconnexion == true){    
            $this->CasClient();
            $this->model->log($this->session->utilisateur,get_class($this),LOG_DECONNEXION."[".$this->date_du_jour."]");
            session_destroy();
            phpCAS::logout();
            exit;
        }
    }
    
    
}