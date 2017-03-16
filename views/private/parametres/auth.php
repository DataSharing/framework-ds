<?php
include './config/auth.php';
echo "<center>";
    echo "<label>Mode d'authentification</label><br/>";
    echo "<label  class='btn btn-primary'><input type='radio' name='mode[]' id='mode' value='app' ";
    if($auth['mode'] == 'app'){echo 'checked';$etat = 'disabled';}
    echo "/> Application</label>&nbsp;";
    echo "<label  class='btn btn-warning'><input type='radio' name='mode[]' id='mode' value='cas' ";
    if($auth['mode'] == 'cas'){echo 'checked';$etat = 'required';}
    echo "/> CAS</label>";
echo "</center><br/>";
$this->form->input('url_cas','text','Adresse du serveur cas [cas.exemple.fr]','',$auth['url_cas'],'[A-Za-z0-9/.\-]*',$etat);
$this->form->input('get_cas','text','Variable url [/cas]','',$auth['get_cas'],'[A-Za-z0-9/.\-]*',$etat);
$this->form->input('port_cas','text','Port','',$auth['port_cas'],'[0-9]*',$etat);
$this->ActionsAuth();