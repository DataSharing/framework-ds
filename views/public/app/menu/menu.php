<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">D<b style="color:#f7464a">S</b></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <?php if($this->session->CheckRightMain('accueil',LECTURE)):?>
          <li class=""><a href="<?php echo $this->echoRedirect('accueil');?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>  Tableau de bord</a></li>
          <?php endif;if($this->session->CheckRightMain('calendrier',LECTURE)):?>
          <li class=""><a href="<?php echo $this->echoRedirect('calendrier');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Calendrier</a></li>
          <?php endif;if($this->session->CheckRightMain('ressources',LECTURE)):?>
          <li class=""><a href="<?php echo $this->echoRedirect('ressources');?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>  Ressources</a></li>
          <?php endif;if($this->session->CheckRightMain('reservations',LECTURE)):?>
          <li class=""><a href="<?php echo $this->echoRedirect('reservations');?>"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>  Réservations</a></li>
          <?php endif;?>
        </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 0em">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->mail;?> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span></a>
            <ul class="dropdown-menu">
              <!-- MENU ADMIN -->
              <li><a href="<?php echo$this->echoRedirect('profil');?>"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Mon profil</a></li>
              <?php if($this->session->CheckRightMain('utilisateurs',LECTURE)):?>
              <li><a href="<?php echo$this->echoRedirect('utilisateurs');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Utilisateurs</a></li>
              <?php endif;if($this->session->CheckRightMain('groupes',LECTURE)):?>
              <li><a href="<?php echo$this->echoRedirect('groupes');?>"><span class="fa fa-users" aria-hidden="true"></span> Groupes</a></li>
              <?php endif;?>
              <?php if($this->session->CheckRightMain('Mails',LECTURE)):?>
              <li><a href="<?php echo$this->echoRedirect('mails');?>"><i class="fa fa-envelope" aria-hidden="true"></i> Gestion des mails</a></li>
               <?php endif;?>
              <?php if($this->session->CheckRightMain('parametres',LECTURE)):?>
              <li><a href="<?php echo$this->echoRedirect('parametres');?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Paramètres</a></li>
              <?php endif;?>
              <!-- END ADMIN -->
              <li><a href="<?php echo $this->echoRedirect('deconnexion');?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Déconnexion</a></li>
            </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
</nav>