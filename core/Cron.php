<?php
Class Cron extends Controller{
   
    Public function __construct(){
        parent::__construct();
        include(dirname(__FILE__).'/../locales/'.$this->langage.'/logs.php');
        $this->load('core/Model','model');
        $this->load('core/Wol','wol');
         $this->load('core/Shutdown','off');
        $this->model->table = 'taches_planifiees';
    }
    
    public function Toutes_les_taches_planifiees(){
        $data = '';
        $data['taches_planifiees'] = $this->model->lecture('*');
        return $data['taches_planifiees'];   
    }
    
    public function log($log){
        $this->model->log('auto','cron',$log);
    }
    
    public function init_compteur_cron(){
        $this->model->table = 'taches_planifiees';
        $data = array('compteur_cron'=>0);
        $this->model->maj(array(),$data);
    }
    
    public function compteur_cron($id_tache,$cron){
        $this->model->table = 'taches_planifiees';
        $data = array('compteur_cron'=>$cron);
        $where = array('id'=>$id_tache);
        $this->model->maj($where,$data);
    }
    public function wakePc($id_tache,$nom){
        $logs = array();
        $this->model->table = 'regroupements';
        $query_reg = $this->model->lecture('*',array('id_tache_planifiee'=>$id_tache));
        $this->model->table = 'machines';
        
        foreach($query_reg as $data){
            $machines = $this->model->lecture('*',array('id_regroupement'=>$data['id']));
            foreach($machines as $pc){
                $logs[] = $this->wol->wake($pc['name'],$pc['mac'],$pc['ip']);
            }
        }
        
        if($logs){
            $handle = fopen(dirname(__FILE__).'/../logs/wake-'.$nom.'-'.$this->date_du_jour.'.log',"w+");
            foreach($logs as $log){
                fputs($handle,$log.PHP_EOL);
            }
            fclose($handle);
        }
        
    }
    
    public function Shutdown($id_tache){
        $this->model->table = 'regroupements';
        $query = $this->model->lecture('*',array('id_tache_planifiee'=>$id_tache));
        foreach($query as $reg){
            $this->off->traitement_ip($reg['id'],$reg['ip_debut'],$reg['ip_fin'],'eteindre');      
        }
    }
}
