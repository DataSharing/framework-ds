<?php
/**
 * Class Router 
 */
class Router extends Controller{

    Public function __construct(){
        parent::__construct();
    }
    
    /**
     * Route ves le controller
     * 
     * @param string $get
     * @param boolean $session
     * @return object
     */
    public function rt($get, $session = TRUE){
        $params = $this->params($get);
        $action = strtolower($params['action']);
        $id = $params['id'];

		if(isset($params['arg'])){
			$arg = $params['arg'];
		}else{
			$arg = "";
		}
        if($session == TRUE){
            if($get == 'CP'){
                $CP = strtolower($this->controller_principal);
                $this->load($CP);
                return $this->$CP->index($id,$arg);
            }elseif($this->load($action)){
                return $this->$action->index($id,$arg);
            }else{
                $this->redirect('erreur/404');
            }  
        }else{
            if($action == 'authentification' || $action == 'erreur' || $action == ''){
                $this->load('Authentification','ctrl_auth');
                $this->load('Erreur','ctrl_erreur');
                return $this->ctrl_auth->index() . $this->ctrl_erreur->index($id);
            }else{
                $this->redirect();
            }
        }
    }
    
    /**
     * Explode url 
     * 
     * @param string $get
     * @return array
     */
    public function params($get){
        $params = explode( "/", $get );
        for($i = 0; $i < count($params); $i+=3) {
            $p['action'] = $params[$i];
            if(count($params) == 1){
                $p['id'] = '';
                $p['arg'] = "";
            }else{
                $p['id'] = $params[$i+1];
                if(count($params)>2){
                    $p['arg'] = $params[$i+2];
                }
            }
        }
        return $p;
    }

}
