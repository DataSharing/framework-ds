<?php

class Uploads extends Controller {
   public function CreationRepertoire($id) {
      $structure = "./uploads/" . $id;
      if (!mkdir($structure, 0777, true)) {
         die('Echec lors de la création des répertoires...');
      }
      return true;
   }
   public function SupprimerDossier($strDirectory) {
      if (!is_dir($strDirectory)) {
         return true;
      }
      $handle = opendir($strDirectory);

      while (false !== ($entry = readdir($handle))) {
         if ($entry != '.' && $entry != '..') {
            if (is_dir($strDirectory . '/' . $entry)) {
               $this->SupprimerDossier($strDirectory . '/' . $entry);
            } elseif (is_file($strDirectory . '/' . $entry)) {
               if (!unlink($strDirectory . '/' . $entry)) {
                  return false;
               }
            }
         }
      }
      rmdir($strDirectory . '/' . $entry);
      closedir($handle);
      return true;
   }
   public function supprimerElement($id, $fichier) {
      if ($fichier == "") {
         return true;
      }
      $dossier = "./uploads/" . $id . "/";
      if (unlink($dossier . $fichier)) {
         return true;
      }
      return false;
   }
   function ViderDossier($dir, $delete = false) {
      $dossier = $dir;
      $dir = opendir($dossier);
      while ($file = readdir($dir)) {
         if (!in_array($file, array(".", ".."))) {
            if (is_dir("$dossier/$file")) {
               $this->ViderDossier("$dossier/$file", true);
            } else {
               unlink("$dossier/$file");
            }
         }
      }
      closedir($dir);

      if ($delete == true) {
         rmdir("$dossier/$file");
      }
   }
   public function Upload($files, $id, $format = array()) {
      $valid_formats = $format;
      $max_file_size = 1024 * 1000000000; //50 Mo
      $path = "./uploads/" . $id . "/"; // Upload directory
      if (!is_dir($path)) {
         $this->CreationRepertoire($id);
      }
      $count = 0;
      $message = array();
      $ok = 0;

      if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
         for ($i = 0; $i < count($files['name']); $i++) {
            $existe = 0;
            $name = $files['name'][$i];
            if ($name == "") {
               return true;
            }
            if (file_exists($path . $name)) {
               $existe = 1;
               $message[] = "L'image $name existe déjà!";
            }
            if ($files['error'][$i] == 4) {
               //continue; // Skip file if any error found
            }
            if ($files['error'][$i] == 0) {
               if ($files['size'][$i] > $max_file_size) {
                  $message[] = "$name es trop gros! (max : 50Mo)";
               } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                  if ($existe == 0) {
                     $message[] = "$name n'est pas au bon format!";
                  }
               } elseif (file_exists($path . $name)) {
                  $message[] = "L'image $name existe déjà!";
               } else { // No error found! Move uploaded files
                  if (move_uploaded_file($files["tmp_name"][$i], $path . $name)) {
                     $ok = "Téléchargement : ok!";
                  }
               }
            }
         }
      }
      if (!empty($message)) {
         $this->view('app/erreurs/erreurs', $message);
         return false;
      } else {
         return true;
         //$this->view('app/succes/notification',$ok);
      }
      return true;
   }
}