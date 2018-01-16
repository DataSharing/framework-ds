<?php 

class Uploads extends Controller{
	public function CreationRepertoire($id) {
		$structure = SITE_ROOT . "/uploads/" . $id;
		if (!mkdir($structure, 0777, true)) {
			die('Echec lors de la création des répertoires...');
		}
		return true;
	}

	public function SupprimerDossier($strDirectory) {
		$handle = opendir($strDirectory);
		while (false !== ($entry = readdir($handle))) {
			if ($entry != '.' && $entry != '..') {
				if (is_dir($strDirectory . '/' . $entry)) {
					$this->SupprimerDossier($strDirectory . '/' . $entry);
				} elseif (is_file($strDirectory . '/' . $entry)) {
					unlink($strDirectory . '/' . $entry);
				}
			}
		}
		rmdir($strDirectory . '/' . $entry);
		closedir($handle);
	}

	public function supprimerElement($id, $fichier) {
		if($fichier == ""){return true;}
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

	public function Upload($file, $id, $old = "",$format = array()) {
		$valid_formats = $format;
        $max_file_size = 1024 * 1000000000; //50 Mo
        $path = "./uploads/" . $id . "/"; // Upload directory
        /*
        if(!is_dir($path)){
        	$this->CreationRepertoire($id);
        }*/
        $count = 0;
        $message = 0;
        $ok = 0;

        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
        	$name = $file['name'];
        	if($name == ""){
        		return true;
        	}
        	if (file_exists($path . $name)) {
        		$message = "L'image $name existe déjà!";
        	}
        	if ($file['error'] == 4) {
                //continue; // Skip file if any error found
        	}
        	if ($file['error'] == 0) {
        		if ($file['size'] > $max_file_size) {
        			$message = "$name es trop gros! (max : 50Mo)";
        		} elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
        			$message = "$name n'est pas au bon format!";
        		} elseif (file_exists($path . $name)) {
        			$message = "L'image $name existe déjà!";
                } else { // No error found! Move uploaded files 
                	if (move_uploaded_file($file["tmp_name"], $path . $name)) {
                		$this->supprimerElement($id,$old);
                		$ok = "Téléchargement : ok!";
                		$message = 1;
                	}
                }
            }
        }
        if ($message == 0) {
        	$this->view('app/erreurs/default',$message);
        	return false;
        } else {
        	return true;
            //$this->view('app/succes/notification',$ok);
        }
        return true;
    }
}