<?php

Class Check {
	public static function __run(){
		Check::DossierInstallation();
		if(Check::FileConfig() == 1){
			echo "<i>Fichier config.php manquant!</i><br>";
		}
		if(Check::FileDatabase() == 1){
			echo "<i>Fichier database.php manquant!</i><br>";
		}
		if(Check::FileConfig() == 1 || Check::FileDatabase() == 1){
			echo "<b>Dans l'ordre:</b><br>";
			echo "<i>-- Vérifier les droits d'écriture sur le repertoire</i><br>";
			echo "<i>-- Renommer ou copier le dossier d'installation à la racine du site et relancer l'installation en rafraichissant la page...</i><br>";
			exit;
		}	
	}
	
	public static function FileConfig(){
		if(file_exists(dirname(__FILE__).'/../config/config.php')){
			return 0;
		}
		return 1;
	}
	
	public static function FileDatabase(){
		if(file_exists(dirname(__FILE__).'/../config/database.php')){
			return 0;
		}
		return 1;
	}
	
	public static function DossierInstallation(){
		if(file_exists(dirname(__FILE__).'/../installation/install.php')){
			header('location:installation/index.php');
		}
		return '';
	}
}