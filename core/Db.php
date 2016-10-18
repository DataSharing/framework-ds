<?php

class DB {

    protected $db;
    protected $hostname;
    protected $namebdd;
    protected $userbdd;
    protected $passbdd;
    Public $base_url;
    
    public function __construct(){
        $this->DB();
    }

    Private function infosBDD(){
        include dirname(__FILE__).'/../config/database.php';
        include dirname(__FILE__).'/../config/config.php';
        $this->prefixebdd = $database['prefixebdd'];
        $this->hostname = $database['hostname'];
        $this->namebdd = $database['namebdd'];
        $this->userbdd = $database['userbdd'];
        $this->passbdd = $database['passbdd'];
        $this->base_url = $config['base_url'];
        $this->nom_du_site = $config['nom_du_site'];
        $this->controller_principal = $config['controller_principal'];	
        $this->date_du_jour = $config['date_du_jour'];	
    }
    
    public function DB(){
        $this->infosBDD();
        $conn = NULL;
    
        try{
            //"mysql:host=localhost;dbname=planning", 'root', ''
            $conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->namebdd . "", "" . $this->userbdd . "", "" . $this->passbdd . "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
                }   
            $this->db = $conn;
    }
   
    
    public function getConnection(){
        return $this->db;
    }
    
    Public function formatDate($date){
        $DateFormatBdd = new DateTime($date);
        return $DateFormatBdd->format('Y-m-d');
    }
    
    Public function query($query,$donnees = '',$countAction = 0){
        $type_requete = explode(' ',$query);
        //Requête préparée
        $req = $this->db->prepare($query); 
        if(!$donnees == ''){
            //Protection injection
            foreach($donnees as $key=>$value){               
                if(is_array($donnees[$key])){
                    $this->query($query,$donnees[$key],$countAction);
                }else{
                    if(is_numeric($value)){
                        $req->bindValue(":".$key,$value,PDO::PARAM_INT);
                    }else{
                        $req->bindValue(":".$key,$value,PDO::PARAM_STR);
                    }
                }
             }
        }

        if(strtolower($type_requete[0]) ==  'select'){
             if($countAction == 1){
                 return $req->execute();
             }else{
                 $req->execute();
                 return $req->fetchall();
             }
        }else{
            if($req->execute()){
                return true;
            }
         }
            return false;
    }
    
    Public function select($select,$table){
        $selections = '';
        if($select == '' || $select == '*'){
            $selections = '*';
        }else{
            foreach($select as $data){
                if($selections == ''){
                    $virgule = '';
                }else{
                    $virgule = ',';
                }
                $selections = $selections . $virgule . $data;
            }
        }
        return 'select ' . $selections . ' from ' . $table;
    }
    
    Public function insert($donnees,$table){
        $colonnes = '';
        $colonnesValues = '';
        $count = 0;
        foreach($donnees as $key=>$value){
            if($count == 0){
                    $virgule = '';
            }else{
                    $virgule = ',';
            }
            $count = $count + 1;
            $colonnes = $colonnes.$virgule.$key;
            $colonnesValues = $colonnesValues.$virgule.":".$key;
        }
        return 'insert into ' . $table . '(' . $colonnes . ') VALUES(' . $colonnesValues . ')';
    }
    
    Public function where($where = null,$operateur = NULL){
        $conditions = '';
        $ope = $operateur;
        $explode_ope = explode("+",$ope);
        $nb_ope = count($explode_ope);
        $count = 0;
        $verif_like = "";
        $signe = "";
        if($where == NULL){
            return '';
        }
            foreach($where as $key => $value){
                if($count == 1 && $ope == ''){
                    return false;
                }
                if($conditions == ''){
                        $operateur = '';
                }else{
                    if($nb_ope == 1){ 
                        $operateur = $ope;
                    }else{
                        $multi_ope = $count - 1;
                        $operateur = $explode_ope[$multi_ope];
                    }
                }
                $verif_like = explode('%',$value);
                if(count($verif_like) == 1){
                    $signe = "=";
                }else{
                    //VOIR POUR LE LIKE COMMENT JE PEUX GERER
                    $signe = "LIKE";
                }
                $conditions =  $conditions . ' ' . $operateur . ' ' . $key ." ". $signe . " :".$key;
                $count = $count + 1;
            }
        return ' where ' . $conditions;
    }
    
    Public function update($donnees,$table,$where){
        $dataset = '';
        foreach($donnees as $id => $value){
            $virgule = ',';
            if($dataset == ''){
                    $virgule = '';
            }else{
                    $virgule = ','; 
            }
            $dataset = $dataset . $virgule . $id . "=:".$id ;
        }
        return 'update ' . $table . ' SET ' . $dataset . ' '.$this->where($where);
    }
    
    Public function leftjoin($tables = array()){
        
        foreach($tables as $alias=>$table){
            
        }
    }
    
    Public function orderby($order){
        if($order == NULL){
            return '';
        }else{
            foreach($order as $key=>$value){
                return 'ORDER BY '.$key.' '.$value;
            }
        }
    }
    
    Public function limit($limit = null){
        $count = 0;
        if($limit == null){return '';}else{
            foreach($limit as $key=>$value){
                if($count == 0){
                    $suivant = $key;
                }else{
                    $fin = $key;
                }
                $count = $count + 1;
            }
            return 'LIMIT :'.$suivant.' offset :'.$fin;
        }
    }
    
}
