<?php  
session_start();   
ob_start();

//DEBUG
ini_set('display_errors',1);
//Verification APP
include(dirname(__FILE__).'/core/Check.php');
Check::run();

//VARIABLE URL*********************************
$get = '';
if(isset($_GET['p'])) $get = htmlentities($_GET['p']);

//INCLUDE CLASS********************************
include(dirname(__FILE__).'/core/Controller.php');
include(dirname(__FILE__).'/core/Auth.php');
include(dirname(__FILE__).'/core/Menu.php');
include(dirname(__FILE__).'/core/Router.php');
//END INCLUDE CLASS****************************

//DOCTYPE**************************************
include(dirname(__FILE__).'/includes/doctype.php');

//INSTANCES************************************
$router = New Router();
$menu = New Menu();
$auth = New Auth();

$auth->CasLogout();
//PAGE DE LOGIN********************************
if (!isset($_SESSION['id'])) {
    $auth->CheckAuth($get);
}else{
    echo '<section id="menu">';
        $menu->MenuPrincipal();    
    echo "</section>";
    
    echo '<section id="contenu">';
        if($get){
            $router->rt($get);
        }else{
            $router->rt('CP');
        }
    echo "</section>";
    //$menu->volet();
}
//FOOTER******************************************
include(dirname(__FILE__).'/includes/footer.php');
ob_end_flush();