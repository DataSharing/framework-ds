<?php
echo '<form class="form-signin" action="" method="post">';
    	echo '<img class="logo-login" src="'.$this->base_url.'template/bootstrap/images/logo.png" style="width:100%;transform:rotate(90deg)">';
        echo '<input type="email" autofocus="" required="" placeholder="Adresse mail" class="form-control" name="inputEmail"><br>';
        echo '<input type="password" required="" placeholder="Mot de passe" class="form-control" name="inputPassword"><br>';
    echo '<center><button type="submit" class="btn btn-primary" style="width:100%">Connexion</button></center>';
echo '</form>';