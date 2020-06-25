<?php

class DB
{
   private $db = null;
   private static $instance = null;
   public $prefixebdd;
   private $hostname;
   private $namebdd;
   private $userbdd;
   private $passbdd;
   public $base_url;
   public $rewrite;

   public function __construct()
   {
      $this->infosBDD();
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
   private function infosBDD()
   {
      include dirname(__FILE__) . '/../config/database.php';
      include dirname(__FILE__) . '/../config/config.php';
      $this->prefixebdd = $database['prefixebdd'];
      $this->hostname = $database['hostname'];
      $this->namebdd = $database['namebdd'];
      $this->userbdd = $database['userbdd'];
      $this->passbdd = $database['passbdd'];
      $this->base_url = $config['base_url'];
      $this->rewrite = $config['rewrite'];
      $this->nom_du_site = $config['nom_du_site'];
      $this->controller_principal = $config['controller_principal'];
      $this->date_du_jour = $config['date_du_jour'];
   }
   public function PdoConnection()
   {
      $connection = NULL;
      try {
         //"mysql:host=localhost;dbname=planning", 'root', ''
         $connection = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->namebdd . ";charset=utf8", "" . $this->userbdd . "", "" . $this->passbdd . "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
         echo 'ERROR: ' . $e->getMessage();
      }
      $this->db = $connection;
   }
   public function getInstance()
   {
      $this->infosBDD();
      self::infosBDD();
      if (!isset(self::$instance)) {
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         self::$instance = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->namebdd . ";charset=utf8", "" . $this->userbdd . "", "" . $this->passbdd . "", $pdo_options);
      }
      return self::$instance;
   }
   public function getConnection()
   {
      return $this->db;
   }
   public function formatDate($date)
   {
      $DateFormatBdd = new DateTime($date);
      return $DateFormatBdd->format('Y-m-d');
   }
   public function query($query, $donnees = '', $countAction = 0)
   {
      $this->db = $this->getInstance();
      $in = "";
      $valueIN = '';
      $clauseIN = '';
      $countIn = 0;
      $type_requete = explode(' ', $query);
      //Requête préparée
      $req = $this->db->prepare($query);
      if (!$donnees == '') {
         //Gestion signe supérieur
         $newDonnees = array();
         foreach ($donnees as $key => $value) :
            if (is_array($value)) continue;
            //respecter l'ordre
            $key = str_replace('<>', '', $key);
            $key = str_replace('<=', '', $key);
            $key = str_replace('>=', '', $key);
            $key = str_replace('>', '', $key);
            $key = str_replace('<', '', $key);
            $key = str_replace('<', '', $key);
            $key = str_replace('!=', '', $key);
            $key = str_replace('.', '', $key);
            

            $verif_in = strpos($key, '(in)');
            if ($verif_in !== false) {
               $key = str_replace('(in)', '', $key);
               $valeurIN = explode(',', $value);
               foreach ($valeurIN as $ci) {
                  $ids[] = $ci;
               }
               $countIn++;
            }

            $key = str_replace('(', '', $key);
            $key = str_replace(')', '', $key);
            
            $verif_I = strpos($key, '?');
            if ($verif_I !== false) {
               $key = str_replace('?', '', $key);
               $ids[] = $value;
               $countIn++;
            }
            $newDonnees[$key] = $value;
         endforeach;
         //Protection injection
         foreach ($newDonnees as $key => $value) {
            //echo "key : ".$key." | value : ".$value."<br>";
            if (is_array($newDonnees[$key])) {
               $this->query($query, $newDonnees[$key], $countAction);
            } else {
               if ($key == 'suivant' || $key == 'par_page' || $countIn >= 1) {
                  //Ne rien faire
               } elseif (is_numeric($value) && !is_float($value)) {
                  $req->bindValue(":" . $key, $value, PDO::PARAM_INT);
               } else {
                  $req->bindValue(":" . $key, $value, PDO::PARAM_STR);
               }
            }
         }
      }

      if (strtolower($type_requete[0]) == 'select') {
         if ($countAction == 1) {
            return $req->execute($ids);
         } else {
            if (!empty($ids)) {
               $req->execute($ids);
            } else {
               $req->execute();
            }
            return $req->fetchall();
         }
      } else {
         if ($req->execute()) {
            return true;
         }
      }
      return false;
   }

   public function select($select, $table)
   {
      $selections = '';
      if ($select == '' || $select == '*') {
         $selections = '*';
      } else {
         foreach ($select as $data) {
            if ($selections == '') {
               $virgule = '';
            } else {
               $virgule = ',';
            }
            $selections = $selections . $virgule . $data;
         }
      }
      return 'select ' . $selections . ' from ' . $table;
   }
   public function insert($donnees, $table)
   {
      $colonnes = '';
      $colonnesValues = '';
      $count = 0;
      foreach ($donnees as $key => $value) {
         if ($count == 0) {
            $virgule = '';
         } else {
            $virgule = ',';
         }
         $count = $count + 1;
         $colonnes = $colonnes . $virgule . $key;
         $colonnesValues = $colonnesValues . $virgule . ":" . $key;
      }
      return 'insert into ' . $table . '(' . $colonnes . ') VALUES(' . $colonnesValues . ')';
   }
   public function prepare($query, $where = array())
   {
      $this->db = $this->getInstance();
      $newWhere = array();
      foreach ($where as $key => $value) :
         $key = str_replace('>', '', $key);
         $key = str_replace('<', '', $key);
         $key = str_replace('<>', '', $key);
         $key = str_replace('<=', '', $key);
         $key = str_replace('>=', '', $key);
         $key = str_replace('!=', '', $key);
         $key = str_replace('.', '', $key);
         $key = str_replace('(in)', '', $key);
         $newWhere[$key] = $value;
      endforeach;
      return $this->db->prepare($query, $newWhere);
   }

   public function dernierID()
   {
      return $this->db->lastinsertid();
   }

   public function where($where = null, $operateur = NULL, $groupBy = "")
   {
      $conditions = '';
      $ope = $operateur;
      $explode_ope = explode("+", $ope);
      $nb_ope = count($explode_ope);
      $count = 0;
      $verif_like = "";
      $verif_superieur = "";
      $verif_inferieur = "";
      $verif_superieur_egal = "";
      $verif_inferieur_egal = "";
      $verif_different = "";
      $verif_pasegal = "";
      $verif_in = "";
      $signe = "";
      //var_dump($where);
      if ($where == NULL) {
         return '';
      }
      foreach ($where as $key => $value) {
         if ($count == 1 && $ope == '') {
            return false;
         }
         if ($conditions == '') {
            $operateur = '';
         } else {
            if ($nb_ope == 1) {
               $operateur = $ope;
            } else {
               $multi_ope = $count - 1;
               $operateur = $explode_ope[$multi_ope];
            }
         }

         //c'est moche mais fonctionnel #spaghetti
         //Respecter l'ordre IMPORTANT!
         if (!is_array($value)) {
            $verif_like = strpos($value, '%');
         }
         $verif_superieur = strpos($key, '>');
         $verif_inferieur = strpos($key, '<');
         $verif_superieur_egal = strpos($key, '>=');
         $verif_inferieur_egal = strpos($key, '<=');
         $verif_different = strpos($key, '<>');
         $verif_pasegal = strpos($key, '!=');
         $verif_in = strpos($key, '(in)');
         $verif_i = strpos($key, '?');
         $verif_parenthese_ouverte = strpos($key, '(');
         $verif_parenthese_fermee = strpos($key, ')');
         $parenthese_o = "";
         $parenthese_f = "";
         $po = "";
         $pf = "";

         /* Verification case */
         $case = false;
         $verif_case = strpos($key, 'cas');
         if ($verif_case !== false) {
            $verif_end = strpos($key, "end");
            if ($verif_end !== false) {
               $verif_then = strpos($key, 'then');
               if ($verif_then !== false) {
                  $case = true;
               }
            }
         }

         if ($verif_like !== false) {
            $signe = "LIKE";
         } elseif ($verif_superieur_egal !== false) {
            $signe = ">=";
         } elseif ($verif_inferieur_egal !== false) {
            $signe = "<=";
         } elseif ($verif_different !== false) {
            $signe = "<>";
         } elseif ($verif_superieur !== false) {
            $signe = ">";
         } elseif ($verif_inferieur !== false) {
            $signe = "<";
         } elseif ($verif_pasegal !== false) {
            $signe = "!=";
         } elseif ($verif_in !== false) {
            $signe = "in";
            $parenthese_o = "(";
            $parenthese_f = ")";
         } else {
            $signe = "=";
         }

         //Parenthese OR AND
         if ($verif_parenthese_ouverte !== false) {
            $po = "(";
         }

         if ($verif_parenthese_fermee !== false) {
            $pf = ")";
         }

         //Respecter l'ordre
         if ($case == false) {
            $key = str_replace('<>', '', $key);
            $key = str_replace('<=', '', $key);
            $key = str_replace('>=', '', $key);
            $key = str_replace('>', '', $key);
            $key = str_replace('<', '', $key);
            $key = str_replace('!=', '', $key);
            $key = str_replace('(in)', '', $key);
            $key = str_replace('?', '', $key);
            $key = str_replace('(', '', $key);
            $key = str_replace(')', '', $key);
         }

         $valeur = $parenthese_o;
         if ($signe == 'in') {
            $valeurIN = explode(',', $value);
            $nb = count($valeurIN);
            $count = 1;
            $virgule = ',';
            foreach ($valeurIN as $vi) {
               if ($count == $nb) $virgule = '';
               $valeur .= "?" . $virgule;
               $count++;
            }
         } elseif ($verif_i !== false) {
            $valeur .= ' ?';
         } else {
            $valeur .= " :" . str_replace('.', '', $key);
         }
         $valeur .= $parenthese_f;

         if (is_array($value)) {
            $valeur = $value[0];
            $signe = "=";
         }

         $conditions = $conditions . ' ' . $operateur . ' ' . $po . $key . " " . $signe . $valeur . $pf;
         $count++;
      }
      //echo $conditions."<br>";
      return ' where ' . $conditions;
   }
   public function update($donnees, $table, $where, $operateur = NULL)
   {
      $dataset = '';
      foreach ($donnees as $id => $value) {
         $virgule = ',';
         if ($dataset == '') {
            $virgule = '';
         } else {
            $virgule = ',';
         }
         $dataset = $dataset . $virgule . $id . "=:" . $id;
      }
      return 'update ' . $table . ' SET ' . $dataset . ' ' . $this->where($where, $operateur);
   }
   public function leftjoin($leftjoin = array())
   {
      if (!empty($leftjoin)) {
         $lj = "";
         $count = 0;
         foreach ($leftjoin as $table => $join) {
            $lj = $lj . " left join " . $this->prefixebdd . $table . " ON " . $join;
            $count++;
         }
         return $lj;
      }
      return "";
   }
   public function orderby($order)
   {
      if ($order == NULL) {
         return '';
      } else {
         $virgule = ",";
         $orderby = "";
         $count = 1;
         $nb = count($order);
         foreach ($order as $key => $value) {
            if ($count == $nb) {
               $virgule = "";
            }
            $orderby = $orderby . $key . ' ' . $value . $virgule;
            $count++;
         }
         return 'ORDER BY ' . $orderby;
      }
      return "";
   }
   public function groupby($groupby)
   {
      if (!empty($groupby)) {
         return "group by " . $groupby;
      }
      return "";
   }

   public function having($having)
   {
      if (!empty($having)) {
         return "having " . $having;
      }
      return "";
   }


   public function limit($limit = null)
   {
      $count = 0;
      if ($limit == null) {
         return '';
      } else {
         return 'LIMIT ' . $limit['par_page'] . ' offset ' . $limit['suivant'];
      }
   }
}
