<?php
include_once dirname(__FILE__) . '/../core/Db.php';

class Model extends DB
{
   public $table;
   public $leftjoin;
   public $groupby;
   public $having;
   public $limite;
   public $ordre;
   public $prefixebdd;
   public $errors = array();
   private $db;
   /**
    *  Insère une nouvelle ligne dans la base de données.
    */
   public function insertion($donnees = array())
   {
      $query = $this->insert($donnees, $this->prefixebdd . $this->table);
      return $this->query($query, $donnees);
   }
   /**
    *  Récupère des données dans la base de données.
    * Exemple :
    * $this->lecture(array('id','nom','prenom'),
    *              array('id'=>1),
    *              'AND',
    *              array('id'=>'ASC'),
    *              array('suivant'=>0,'fin'=>5),
     'id');

     Fonction recherche LIKE '%%'
     $this->lecture(array('id','nom','prenom'),
    *              array('id'=>1,'nom'=>'%nom%'),
    *              'AND',
    *              array('id'=>'ASC'),
    *              array('suivant'=>0,'fin'=>5),
     'id');
    */
   public function lecture($select = array('*'), $where = array(), $operateur = null, $order = array(), $limit = array())
   {
      $query = $this->select($select, $this->prefixebdd . $this->table
         . $this->leftjoin($this->leftjoin)
         . ' ' . $this->where($where, $operateur)
         . ' ' . $this->groupby($this->groupby)
         . ' ' . $this->having($this->having)
         . ' ' . $this->orderby($order)
         . ' ' . $this->limit($limit));
      /* Reset  */
      $this->leftjoin = null;
      $this->groupby = null;
      $this->having = null;
      //echo $query . "<br/>";
      return $this->query($query, array_merge($where, $limit));
   }
   /**
    *  Récupère une information dans la base de données.
    *
    */
   public function onerow($select, $where = array(), $operateur = null)
   {
      $query = 'select ' . $select . ' from ' . $this->prefixebdd . $this->table
         . $this->where($where, $operateur);
      $nb = $this->prepare($query, $where);
      foreach ($where as $key => $value) {
         $nb->bindValue(':' . $key, $value);
      }
      $nb->execute();
      if ($nb->rowCount() == 1) {
         foreach ($nb->fetchall() as $data) {
            $this->leftjoin = null;
            return $data["$select"];
         }
      }
      $this->leftjoin = null;
      return false;
   }
   /**
    *  Modifie une ou plusieurs lignes dans la base de données.
    */
   public function maj($where, $donnees = array(), $operateur = NULL)
   {
      $query = $this->update($donnees, $this->prefixebdd . $this->table, $where, $operateur);
      //echo $query;
      return $this->query($query, $donnees + $where);
   }
   /**
    *  Supprime une ou plusieurs lignes de la base de données.
    */
   public function delete($where = array(), $operateur = '')
   {
      $query = 'delete from ' . $this->prefixebdd . $this->table
         . $this->where($where, $operateur);
      return $this->query($query, $where);
   }
   /**
    * Dupliquer un enregistrement
    * $this->dupliquer('nom,prenom,age','id=1');
    */
   public function dupliquer($colonnes = "", $where = "", $otherTable = "", $otherColonnes = "")
   {
      if (empty($otherTable)) {
         $otherTable = $this->prefixebdd . $this->table;
      }

      if (empty($otherColonnes)) {
         $otherColonnes = $colonnes;
      }
      $query = "INSERT INTO " . $this->prefixebdd . $this->table . " (" . $colonnes . ") ";
      $query .= "SELECT " . $otherColonnes . " FROM " . $otherTable . " ";
      $query .= "WHERE " . $where;
      return $this->query($query);
   }

   /**
    *  Compter le nombre d'enregistrement
    *
    */
   public function count($where = array(), $operateur = NULL, $other = NULL)
   {
      $data = array();

      if ($other == NULL) {
         $where_select = $this->where($where, $operateur);
      } else {
         $where_select = " where " . $other;
         $query = $this->select('*', $this->prefixebdd . $this->table . $where_select);
         $nb = $this->prepare($query);
         $nb->execute();
         return $nb->RowCount();
      }

      $query = $this->select('*', $this->prefixebdd . $this->table . $where_select);
      $nb = $this->prepare($query);
      if ($where) {
         foreach ($where as $key => $value) {
            //respecter l'ordre
            $key = str_replace('<>', '', $key);
            $key = str_replace('<=', '', $key);
            $key = str_replace('>=', '', $key);
            $key = str_replace('>', '', $key);
            $key = str_replace('<', '', $key);
            $key = str_replace('<', '', $key);
            $key = str_replace('!=', '', $key);
            $key = str_replace('.', '', $key);
            $data[':' . $key] = $value;
         }
      }
      $nb->execute($data);
      //var_dump($data);
      //echo $query."<br>";
      return $nb->RowCount();
   }

   public function libre($requete)
   {
      return $this->query($requete);
   }

   /**
      Nombre de row avec un LIMIT
    */
   public function foundRows()
   {
      $rows = $this->query('select FOUND_ROWS() as nb;');
      return $rows[0]['nb'];
   }

   /*
   * Installation table pour PLugin
   * 
   */
   public function createTable($table)
   {
      if ($this->query($table)) {
         return true;
      }
      return false;
   }
   /*
   * Drop table pour PLugin
   * 
   */
   public function dropTable($table)
   {
      if ($this->query($table)) {
         return true;
      }
      return false;
   }
   /**
    *  Vérifier les doublons dans les données
     --> Pour l'insertion
     $this->doublons(array('nom'=>$_POST['nom']));

     --> Pour l'enregistrement

    *
    */
   public function doublons($donnees = array(), $id = array())
   {
      $operateur = "";
      $return = 0;
      foreach ($donnees as $key => $value) {
         if (!empty($id)) {
            foreach ($id as $key1 => $value1) {
               $where[$key1] = $value1;
            }
            $operateur = "AND";
         }
         $where[$key] = $value;
         if ($this->count($where, $operateur) >= 1) {
            $this->errors[] = $value . " existe déjà!";
            $return++;
         }
      }

      if ($return >= 1) {
         return false;
      }
      return true;
   }
   /**
    *  Authentification
    */
   public function auth($mail, $password, $mode = "app")
   {
      if ($mode == "public") {
         $controller_connexion = "connexion/";
      } else {
         $controller_connexion = "erreur/";
      }
      $explodeMail = explode('@', $mail);
      if (!isset($explodeMail[1])) {
         $mail = $mail . "@gmail.com";
      }
      $y = $this->prepare('SELECT COUNT(*) FROM ' . $this->prefixebdd . 'utilisateurs WHERE mail = ?');
      $y->execute(array($mail));
      $x = $y->fetch();

      if ($x[0] == 0) {
         $this->redirect($controller_connexion . "login");
      } else {
         //Si adresse email existe alors on vérifie la combinaison
         $e = $this->prepare('SELECT id,password,salage,active,nom,prenom FROM ' . $this->prefixebdd . 'utilisateurs WHERE mail = ?');
         $e->execute(array($mail));
         $rep = $e->fetch();
         $passe = sha1($password) . $rep['salage'];

         if ($passe == $rep['password']) {
            //COMPTE DESACTIVE
            if ($rep['active'] == 0) {
               $this->redirect($controller_connexion . "activation");
            } else {
               $_SESSION['id'] = $rep['id'];
               $this->log($rep['nom'] . ' ' . $rep['prenom'], 'auth', LOG_CONNEXION, 0, $rep['id']);
               $this->redirect();
            }
         } else {
            $this->redirect($controller_connexion . 'pwd');
         }
      }
   }

   /**
    * Dernier Id inséré
    */
   public function lastInsertId()
   {
      return $this->dernierID();
   }

   /**
    * Logs app
    */
   public function log($utilisateur, $controller, $action, $id = 0, $id_user = 0, $id_description = 0)
   {
      $controller = strtolower($controller);
      $query = 'insert into ' . $this->prefixebdd . 'logs(id_element,controller,modifie_par,date_modification,action,id_utilisateur,id_description) '
         . 'values(:id_element,:controller,:modifier_par,:date_modification,:action,:id_utilisateur,:id_description)';
      $req = $this->prepare($query);
      $req->bindValue(':id_element', $id, PDO::PARAM_INT);
      $req->bindValue(':controller', $controller, PDO::PARAM_STR);
      $req->bindValue(':modifier_par', $utilisateur, PDO::PARAM_STR);
      $req->bindValue(':date_modification', $this->date_du_jour);
      $req->bindValue(':action', $action, PDO::PARAM_STR);
      $req->bindValue(':id_utilisateur', $id_user, PDO::PARAM_INT);
      $req->bindValue(':id_description', $id_description, PDO::PARAM_INT);
      return $req->execute();
   }
}
