<?php
include './config/config.php';
$this->form->input('nom_du_site','text','Nom du site','',$config['nom_du_site'],'[A-Za-z0-9 ]*');
$this->form->input('base_url','url','Base url de votre site','',$config['base_url'],'');
echo "<select name='controllers' class='form-control' >";
foreach($data['fichiers'] as $fichier){
    $file = $this->filtre($fichier);
    if(strtolower($file) == strtolower($config['controller_principal'])){
        echo "<option value='$file' selected='selected'><b>".$file."</b></option>";
    }elseif(!$file == ''){
        echo "<option value='$file'>".$file."</option>";
    }
}
echo "</select></br>";
echo "<select name='langues' class='form-control'>";
    echo "<option value=''>Choisir un langage</option>";
    echo "<option value='fr-FR'";
    if($config['langage'] == 'fr-FR'){ echo "selected='selected'";}
    echo ">Français</option>";
    echo "<option value='en-EN'";
    if($config['langage'] == 'en-EN'){ echo "selected='selected'";}
    echo ">Anglais</option>";
echo "</select></br>";
$this->ActionsGeneral();