<?php
set_time_limit(0);      /*permet au script de s'exécuter indéfiniment */
ignore_user_abort(1);
#ini_set('error_reporting', E_ALL|E_STRICT);
#ini_set('display_errors', 1);

include(dirname(__FILE__).'/../core/Controller.php');
include(dirname(__FILE__).'/../core/Cron.php');

$cron = New Cron();
include(dirname(__FILE__).'/../locales/'.$cron->langage.'/succes.php');