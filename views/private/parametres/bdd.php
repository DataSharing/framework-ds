<?php
include './config/database.php';
$this->form->input('hostname','text','Serveur hôte','',$database['hostname'],'[A-Za-z0-9/.\-]*');
$this->form->input('namebdd','text','Nom de la base de données','',$database['namebdd']);
$this->form->input('userbdd','text','Utilisateur','',$database['userbdd']);
$this->form->input('passbdd','password','Mot de passe','',$database['passbdd']);
$this->form->input('prefixebdd','text','Prefixe de la bdd','',$database['prefixebdd'],'','');
$this->ActionsBdd();

