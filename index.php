<?php  
session_start();   
ob_start();

//DEBUG
ini_set('display_errors',1);

include(dirname(__FILE__).'/core/Check.php');
include(dirname(__FILE__).'/core/Controller.php');
include(dirname(__FILE__).'/core/App.php');

Check::__run();
$app = New app();
$app->__run();

ob_end_flush();