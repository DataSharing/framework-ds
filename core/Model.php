<?php
include_once 'Db.php';

Class Model extends DB{
    
    Public $table;
    Public $limite;
    Public $ordre;
    /**
     *	Insère une nouvelle ligne dans la base de données.
     */
    public function insertion($donnees = array())
    {
        $query = $this->insert($donnees,$this->prefixebdd . $this->table);
        return $this->query($query,$donnees);
    }

    /**
     *	Récupère des données dans la base de données.
     * Exemple : 
     * $this->lecture('*',
     *              array('id'=>1),
     *              'AND',
     *              array('by'=>'id','ordre'=>'ASC'),
     *              array('suivant'=>0,'fin'=>5);
     */
    public function lecture($select = array('*'), $where = array(), $operateur = null,$order = array(),$limit = array())
    {
        $query = $this->select($select,$this->prefixebdd . $this->table
                . $this->where($where,$operateur)    
                .' ' . $this->orderby($order)
                .' ' . $this->limit($limit));      
        return $this->query($query,array_merge($where,$limit));
    }

    /**
     *	Récupère une information dans la base de données.
     *         
     */
    public function onerow($select, $where = array(), $operateur = null)
    {
        $query = 'select ' . $select . ' from ' . $this->prefixebdd . $this->table
                . $this->where($where,$operateur);
        $nb = $this->db->prepare($query,$where);
        foreach($where as $key=>$value){
            $nb->bindValue(':'.$key,$value);
        }
        $nb->execute();
        if($nb->rowCount() == 1){
            foreach($nb->fetchall() as $data){
                return $data["$select"];
            }
        }
        return false;
    } 

    /**
     *	Modifie une ou plusieurs lignes dans la base de données.
     */

    public function maj($where, $donnees = array())
    {		
        $query = $this->update($donnees,$this->prefixebdd . $this->table, $where);
        return $this->query($query,$donnees + $where);
    }

    /**
     *	Supprime une ou plusieurs lignes de la base de données.
     */
    public function delete($where = array())
    {
        $query = 'delete from ' . $this->prefixebdd . $this->table
                . $this->where($where);
        return $this->query($query, $where);
    }

    public function count($where = array(), $operateur = NULL){
        $query = $this->select('*',$this->prefixebdd . $this->table
                . $this->where($where,$operateur));
        $nb = $this->db->prepare($query);
        if($where){
            foreach($where as $key=>$value){
                $nb->bindValue(':'.$key,$value);
            }
        }
        $nb->execute();
        return $nb->RowCount();
    }

    public function recherche($select = "*", $where = array()){
        $or = "";
        $conditions = "";
        
        foreach($where as $key=>$value){
            $ex = explode(':',$key);
            $conditions = $conditions.$or.$ex[1]." LIKE ".$key;
            $or = " OR ";
        }
        
        $query = "select ".$select." from " . $this->prefixebdd . $this->table ." where ".$conditions;
        $queryPrepare = $this->db->prepare($query);
        
        foreach($where as $key=>$value){
            $queryPrepare->bindParam($key,$value);
        }  

        if($queryPrepare->execute()){
            return $queryPrepare->fetchall();
        }else{
            return "";
        }
    }
    
    public function libre($query){
        return $this->db->query($query);
    }

    public function auth($mail,$password,$mode = "app"){
		if($mode == "public"){
			$controller_connexion = "connexion/";
		}else{
			$controller_connexion = "erreur/";
		}
        $y = $this->db->prepare('SELECT COUNT(*) FROM ' . $this->prefixebdd . 'utilisateurs WHERE mail = ?');
        $y->execute(array($mail));
        $x = $y->fetch();

        if ($x[0] == 0){
            header('location:' . $this->base_url . $controller_connexion .'login');
        }else{
            //Si adresse email existe alors on vérifie la combinaison
            $e = $this->db->prepare('SELECT id,password,salage,active,nom,prenom FROM ' . $this->prefixebdd . 'utilisateurs WHERE mail = ?');
            $e->execute(array($mail));
            $rep = $e->fetch();
            $passe = sha1($password).$rep['salage'];

            if ($passe == $rep['password']){
                //COMPTE DESACTIVE
                 if($rep['active'] == 0){
                    header('location:' . $this->base_url . $controller_connexion . 'activation');
                }else{
                    $_SESSION['id'] = $rep['id'];
                     $this->log($rep['nom'].' '.$rep['prenom'],'auth',LOG_CONNEXION."[".$this->date_du_jour."]");
                    header('Location:' . $this->base_url . $this->controller_principal);
                }
            }else{
                header('location:' . $this->base_url . $controller_connexion . 'pwd');
            }
        }
    }
    
    public function lastInsertId(){
        return $this->db->lastinsertid();
    }
    
    public function log($utilisateur,$controller,$action,$id = ''){
        $controller = strtolower($controller);
        $query = 'insert into '.$this->prefixebdd.'logs(id_element,controller,modifie_par,date_modification,action) '
                . 'values(:id_element,:controller,:modifier_par,:date_modification,:action)';
        $req = $this->db->prepare($query);
        $req->bindValue(':id_element',$id,PDO::PARAM_INT);
        $req->bindValue(':controller',$controller,PDO::PARAM_STR);
        $req->bindValue(':modifier_par',$utilisateur,PDO::PARAM_STR);
        $req->bindValue(':date_modification',$this->date_du_jour);
        $req->bindValue(':action',$action,PDO::PARAM_STR);
        return $req->execute();
    }
}