<?php
$controller = $argv[1] ?? "";
$type = $argv[2] ?? "public";

if (empty($controller)) {
	echo "Argument manquant (php file.php arg1 arg2)".PHP_EOL;
	echo "arg1 : nameController".PHP_EOL;
	echo "arg2 : public or private view";
	exit;
}

//Create file Controller
$file = "../../controllers/".ucfirst($controller).".php";
if(!file_exists($file)){
	copy("../../scripts/generate/elements/controller.php",$file);
	$fileCopied = fopen($file,'r') or die('Fichier manquant');
	$content = file_get_contents($file);
	$editContent = str_replace('generate',$controller,$content);
	$editContent = str_replace('Generate',ucfirst($controller),$editContent);
	$editContent = str_replace('public',strtolower($type),$editContent);
	if($type == "public"){
		$editContent = str_replace('Private','',$editContent);
	}
	fclose($fileCopied);
	$modification = fopen($file,'w+') or die('Fichier manquant');
	fwrite($modification,$editContent);
	fclose($modification);
	echo "Controller : ok!".PHP_EOL;
}else{
	echo "Le controlleur existe déjà".PHP_EOL;
}
//Create repertory and file for view
$directory = "../../views/".$type."/".$controller;
if(!is_dir($directory)){
	mkdir($directory);
	fopen($directory."/index.php",'w');
	fopen($directory."/".$controller.".php",'w');
	echo "View : ok!".PHP_EOL;
}else{
	echo "Le dossier dans la vue existe déjà".PHP_EOL;
}