<?php
require_once dirname(__FILE__).'/../lib/PHPMailer/PHPMailerAutoload.php';
include_once dirname(__FILE__).'/../core/Model.php';

/**
 * Class Email : Gestion des envoies de mail avec la libraire PHPMailer
 */
Class Email Extends PHPMailer{

    Private $expediteur;
    Private $alias;
    
    /**
     * Configuration des informations SMTP
     * Fichier ./config/mail.php contient les informations de connexion
     */
    function __construct(){
        parent::__construct();
        include dirname(__FILE__).'/../config/mail.php';        

        //Configuration du SMTP
        $this->isSMTP();
        $this->Host 		= $mail['host'];
        $this->SMTPAuth		= $mail['smtp_auth'];
        $this->port 		= $mail['port'];
        if($this->SMTPAuth){
            $this->Username = $mail['utilisateur'];
            $this->Password = $mail['password'];
        }
        $this->expediteur	= $mail['expediteur'];
        $this->alias        = $mail['alias'];
    }
    
    /**
     * Envoyer un mail à une ou plusieur personne 
     * @param array     $destinataires : array('mail@mail.fr','mail2@mail.fr')
     * @param string    $sujet  : Sujet du mail
     * @return boolean
     * 
     * Si l'on passe par une BDD, on peut imaginer remplacer certains mot clé
     * Exemple : 
     *      -    ###description###
     * Dans ce cas, il nous faut un paramètre suplémentaire, un id unique et on remplace ###exemple### par le champs BDD
     * voir ci-dessous
     */
    public function envoyer($destinataires = array(),$sujet = "",$message = ""){
        /** Utilisation par la BDD

        $model = New Model();
        $model->table = 'mails';
        $message = $model->onerow('message',array('action'=>$action));
        $active= $model->onerow('active',array('action'=>$action));

        //Description
        //On remplace ###description### par celui d'un contenu avec ID
        if(strpos($message,'###description###') !== FALSE){
            $description = $model->onerow('commentaire',array('id'=>$id_reservation));
            $message = str_replace('###description###',$description,$message);
        }
         * 
         *  enables SMTP debug information (for testing)
                       // 1 = errors and messages
                       // 2 = messages only
         * 
         */
       
    	//$this->SMTPDebug = 1;
    	$this->SetFrom($this->expediteur,$this->alias);
        foreach($destinataires as $destinataire){
           $this->AddAddress($destinataire); 
        }
    	$this->Subject = $sujet;
    	$this->MsgHTML(html_entity_decode($message));
    	if($this->Send()){
            return true;
    	}
    	return false;
    }
    
}