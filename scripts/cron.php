<?php
set_time_limit(0);      /*permet au script de s'exécuter indéfiniment */
ignore_user_abort(1);
#ini_set('error_reporting', E_ALL|E_STRICT);
#ini_set('display_errors', 1);

include(dirname(__FILE__).'/../core/Controller.php');
include(dirname(__FILE__).'/../core/Cron.php');

$cron = New Cron();
include(dirname(__FILE__).'/../locales/'.$cron->langage.'/succes.php');

$TLTP = $cron->Toutes_les_taches_planifiees();

//Ce jour*****************************/
    $aujourdhui = date('Y-m-d');
    $jour_semaine_JS = date('D');
    $jourJ = date('d');
    $moisM = date('m');
    $heureH = date('G');
    $minuteM = date('i');
/*************************************/
    
//réinitialisation des compteurs cron
//Minuit 1
$minuit1 = $heureH.":".$minuteM;
if($minuit1 == '00:01' || $minuit1 == '0:1' || $minuit1 == '0:01' || $minuit1 == '00:1' ){
    $cron->log(LOG_INIT_COMPTEUR." Date:".$minuit1);
    $cron->init_compteur_cron();
}
/*************************************/

foreach($TLTP as $tp){
    //Tâche planifiée**************/
    $heure = $tp['heures'];
    $minute = $tp['minutes'];
    $jour = $tp['jours'];
    $mois = $tp['mois'];
    $jour_semaine = $tp['jour_semaine'];
    $exp_array = explode(',',$jour_semaine);

    $date_debut = $tp['date_debut'];
    $date_fin = $tp['date_fin'];

    $action = $tp['action'];
    /******************************/
    //TEST TACHE PLANIFIEE ERREUR
    /*
    echo "*******************TACHE PLANIFIEE********************<br>";
    echo $heure.":".$minute."<br>"
            . "jour semaine:".$jour_semaine."<br>"
            . "jour:".$jour." mois:".$mois."<br>"
            . "debut: ".$date_debut." fin:".$date_fin."<br>"
            . "".$action."<br>";
    echo "*******************CE JOUR****************************<br>";
    echo $heureH.":".$minuteM."<br>"
            . "jour semaine:".$jour_semaine_JS."<br>"
            . "jourJ:".$jourJ." moisM:".$moisM."<br>"
            . "mnt:".$aujourdhui."<br>";
    echo "******************************************************";
    echo "<br><br><br>";
    /******************************/
    if($tp['compteur_cron'] == 0){
        if($date_debut <= $aujourdhui){
            if($date_fin >= $aujourdhui || $date_fin == '0000-00-00'){
                if($mois == $moisM || $mois == '*'){
                    if($jour == $jourJ || $jour == '*'){
                        foreach($exp_array as $jsa){
                            if($jsa == $jour_semaine_JS || $jsa == '*'){
                                if($heure == $heureH){
                                    if($minute == $minuteM 
                                    || $minute + 1 == $minuteM 
                                    || $minute + 2 == $minuteM 
                                    || $minute + 3 == $minuteM){
                                        if($action == 'demarrer'){
                                            $cron->wakePc($tp['id'],$tp['nom']);
                                            $cron->compteur_cron($tp['id'],1);
                                            $cron->log(LOG_TACHE_PLANIFIEE_SUCCES."[".$tp['nom']."]");
                                        }elseif($action == 'eteindre'){
                                            $cron->compteur_cron($tp['id'],1);
                                            $cron->log(LOG_TACHE_PLANIFIEE_SUCCES."[".$tp['nom']."]");
                                            $cron->Shutdown($tp['id']);                                        
                                        }else{
                                            $cron->compteur_cron($tp['id'],1);
                                            $cron->log(LOG_TACHE_PLANIFIEE_ERREUR."[".$tp['nom']."]");
                                        }
                                    }//else{echo "Minutes-".$tp['nom']."<br>";}
                                }//else{echo "Heures-".$tp['nom']."<br>";}
                            }//else{echo "Jour semaine-".$tp['nom']."<br>";}
                        }//END FOREACH
                    }//else{echo "Jours-".$tp['nom']."<br>";}
                }//else{echo "Mois-".$tp['nom']."<br>";}	
            }//else{echo "Date fin-".$tp['nom']."<br>";}
        }//else{echo "Date debut-".$tp['nom']."<br>";}
    }//END IF COMPTEUR CRON
}//END FOREACH GENERAL

?>