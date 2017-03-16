<?php
require_once dirname(__FILE__).'/../lib/PHPMailer/PHPMailerAutoload.php';
include_once dirname(__FILE__).'/../core/Model.php';

Class Email Extends PHPMailer{

    Private $expediteur;
    Private $alias;

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

    /*
        $action (ajouter,non_restitue,restitue)
        $destinataires = array(mail,mail,mail,...)
     * 
     * Personnaliser le mail 
        ###description###     : Si un champs dans la bdd est prevu pour les mails

    */
    public function envoyer($destinataires = array(),$sujet,$action = ""){
        /* Utilisation par la BDD

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
		*/

        if($active == 0){
            return true;
        }
        // enables SMTP debug information (for testing)
                       // 1 = errors and messages
                       // 2 = messages only
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
    
    public function affichage_heure($heure){
        $exHeure = explode('.',$heure);
        if(isset($exHeure[1])){
            return $exHeure[0]."h30";
        }else{
            return $heure."h00";
        }
    }
    
    public function afficher_date($date, $affichage = 'date'){
        $date_sans_time = explode(' ',$date);
        if($affichage == 'date'){
            if($date == '0000-00-00'){
                return '0000-00-00';
            }else{
                $datetimeformat = new DateTime($date_sans_time[0]);
                return $datetimeformat->format('d-m-Y');
            }
        }elseif($affichage == 'dateheure'){
            $datetimeformat = new DateTime($date);
            return $datetimeformat->format('d-m-Y H:i');
        }
    }
    
}
