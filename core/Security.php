<?php

Class Security extends Controller{

    function input_token($nom,$token = ''){
        echo '<input type="hidden" name="'.$nom.'_token" id="'.$nom.'_token" value="'.$token.'" />';
    }
    
    function generer_token($nom = ''){
        $token = uniqid(rand(), true);
        $_SESSION[$nom.'_token'] = $token;
        $_SESSION[$nom.'_token_time'] = time();
        return $token;
    }

    function verifier_token($temps, $referer, $nom = ''){
        if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token'])){
            if($_SESSION[$nom.'_token'] == $_POST['token']){
                if($_SESSION[$nom.'_token_time'] >= (time() - $temps)){
                    if($_SERVER['HTTP_REFERER'] == $this->base_url.$referer){
                        return true;
                    }
                }else{
                    echo erreur::error(6);
                }
            }
        }
        return false;
    }
    
    function generer_salage($nb_caractere = 50){
        $salage = "";     
        $chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
        $longeur_chaine = strlen($chaine);
       
        for($i = 1; $i <= $nb_caractere; $i++)
        {
            $place_aleatoire = mt_rand(0,($longeur_chaine-1));
            $salage .= $chaine[$place_aleatoire];
        }

        return $salage;   
    }

}

