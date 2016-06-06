<?php
class Router extends Controller{

    Public function __construct(){
        parent::__construct();
        $this->load('core/Session','session');
    }
    
    public function rt($get, $session = TRUE){
        $params = $this->params($get);
        $action = strtolower($params['action']);
        $id = $params['id'];

        if($session == TRUE){
            if($get == 'CP'){
                $CP = strtolower($this->controller_principal);
                $this->load($CP);
                return $this->$CP->index($id);
            }elseif($this->load($action)){
                return $this->$action->index($id);
            }else{
                header('location:' . $this->base_url . 'erreur/404');
            }  
        }else{
            if($action == 'authentification' || $action == 'erreur' || $action == ''){
                $this->load('authentification');
                $this->load('erreur');
                return $this->authentification->index() . $this->erreur->index($id);
            }else{
                $this->redirection();
            }
        }
    }
    
    public function params($get){
        $params = explode( "/", $get );
        for($i = 0; $i < count($params); $i+=2) {
            $p['action'] = $params[$i];
            if(count($params) == 1){
                $p['id'] = '';
            }else{
                $p['id'] = $params[$i+1];
            }
        }
        return $p;
    }

}
