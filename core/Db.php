<?php
/**
 * Class DB : Base de données
 */
class DB {

    private $db = null;
    private static $instance = null;
    private $prefixebdd;
    private $hostname;
    private $namebdd;
    private $userbdd;
    private $passbdd;
    Public $base_url;

    public function __construct(){
        //$this->PdoConnection();
    }

    private function __clone() {}

    /**
     * Toutes les informations de connexion à la BDD
     * fichier : database.php 
     */
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
    
    /**
     * Connexion à la BDD
     * Création de l'instance $this->db
     */
    public function PdoConnection(){
        $this->infosBDD();
        $connection = NULL;
        try{
            //"mysql:host=localhost;dbname=planning", 'root', ''
            $connection = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->namebdd . ";charset=utf8", "" . $this->userbdd . "", "" . $this->passbdd . "",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
            }   
            $this->db = $connection;
    }
   
    /**
     * 
     * @return object
     */
    public function getInstance() {
    	$this->infosBDD();
    	self::infosBDD();
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->namebdd . ";charset=utf8", "" . $this->userbdd . "", "" . $this->passbdd . "", $pdo_options);
      }
      return self::$instance;
    }

    /**
     * 
     * @return object
     */
    public function getConnection(){
        return $this->db;
    }
    
    /**
     * Modifie le format de la date
     * @param date $date
     * @return date
     */
    Public function formatDate($date){
        $DateFormatBdd = new DateTime($date);
        return $DateFormatBdd->format('Y-m-d');
    }

    /**
     *
     * @param string $query
     * @param array $donnees
     * @param int $countAction
     * @return boolean
     */
    Public function query($query,$donnees = '',$countAction = 0){
    	$this->db = $this->getInstance();
        $type_requete = explode(' ',$query);
        //Requête préparée
        $req = $this->db->prepare($query); 
        if(!$donnees == ''){
            //Gestion signe supérieur
            $newDonnees = array();
            foreach($donnees as $key=>$value):  
                $key = str_replace('>', '',$key);
                $key = str_replace('<', '',$key);
                $newDonnees[$key] = $value;
            endforeach;
            //Protection injection
            foreach($newDonnees as $key=>$value){ 
                //echo "key : ".$key." | value : ".$value."<br>"; 
                if(is_array($newDonnees[$key])){
                    $this->query($query,$newDonnees[$key],$countAction);
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
    
    /**
     * Préparation de la requête SELECT
     * @param string $select
     * @param string $table
     * @return string
     */
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
    
    /**
     * Préparation de la requête INSERT
     * @param array $donnees
     * @param string $table
     * @return string
     */
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
    
    /**
     * Requête préparée PDO
     * @param string $query
     * @param array $where
     * @return array
     */
    Public function prepare($query,$where = array()){
    	$this->db = $this->getInstance();
        $newWhere = array();
        foreach($where as $key=>$value):  
            $key = str_replace('>', '',$key);
            $key = str_replace('<', '',$key);
            $newWhere[$key] = $value;
        endforeach;
        return $this->db->prepare($query,$newWhere);
    }

    /**
     * Retourne le dernière ID
     * @return int
     */
    Public function dernierID(){
        return $this->db->lastinsertid();
    }

    /**
     * Préparation de la condition WHERE
     * @param array $where
     * @param string $operateur
     * @param array $groupBy
     * @return boolean|string
     */
    Public function where($where = null,$operateur = NULL,$groupBy = ""){
        $conditions = '';
        $ope = $operateur;
        $explode_ope = explode("+",$ope);
        $nb_ope = count($explode_ope);
        $count = 0;
        $verif_like = "";
        $verif_superieur = "";
        $verif_inferieur = "";
        $signe = "";
        //var_dump($where);
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
                $verif_like = strpos($value,'%');
                $verif_superieur = strpos($key,'>');
                $verif_inferieur = strpos($key,'<');
                if($verif_superieur !== false){
                    $signe = ">";
                }elseif($verif_inferieur !== false){
                    $signe = "<";
                }elseif($verif_like !== false){
                   $signe = "LIKE";
                }else{
                    $signe = "=";
                }
                $key = str_replace('>', '',$key);
                $key = str_replace('<', '',$key);
                $conditions =  $conditions . ' ' . $operateur . ' ' . $key ." ". $signe . " :".$key;
                $count++;
            }
        return ' where ' . $conditions;
    }
    
    /**
     * Préparation de la requête UPDATE
     * @param array $donnees
     * @param string $table
     * @param array $where
     * @param string $operateur
     * @return string
     */
    Public function update($donnees,$table,$where,$operateur = NULL){
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
        return 'update ' . $table . ' SET ' . $dataset . ' '.$this->where($where,$operateur);
    }
    
    /**
     * Préparation ORDER BY
     * @param array $order
     * @return string
     */
    Public function orderby($order){
        if($order == NULL){
            return '';
        }else{
            foreach($order as $key=>$value){
                return 'ORDER BY '.$key.' '.$value;
            }
        }
    }
    
    /**
     * Préparation LIMIT
     * @param int $limit
     * @return string
     */
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
