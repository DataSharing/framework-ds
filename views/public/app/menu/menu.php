<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Framework <b style="color:#f7464a">DS</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <?php if($this->session->CheckRightMain('sites',LECTURE)):?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->echoRedirect('sites');?>"><i class="fa fa-dashboard" aria-hidden="true"></i>  Sites</a>
          </li>
          <?php endif;?>.
          <?php if($this->session->CheckRightMain('cms',LECTURE)):?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->echoRedirect('cms');?>"><i class="fa fa-dashboard" aria-hidden="true"></i>  CMS</a>
          </li>
          <?php endif;?>
      </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 0em">
        <li class="nav-item dropdown">
            <a id="dropdown02" class="nav-link" href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->mail;?> <i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
            <div class="dropdown-menu" aria-labelledby="dropdown02">
              <!-- MENU ADMIN -->
              <a class="dropdown-item" href="<?php echo$this->echoRedirect('profil');?>"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Mon profil</a>
              <?php if($this->session->CheckRightMain('utilisateurs',LECTURE)):?>
              <a class="dropdown-item" href="<?php echo$this->echoRedirect('utilisateurs');?>">
                <i class="fa fa-user" aria-hidden="true"></i> Utilisateurs</a>
              <?php endif;if($this->session->CheckRightMain('groupes',LECTURE)):?>
              <a class="dropdown-item" href="<?php echo$this->echoRedirect('groupes');?>"><span class="fa fa-users" aria-hidden="true"></span> Groupes</a>
              <?php endif;?>
              <?php if($this->session->CheckRightMain('parametres',LECTURE)):?>
              <a class="dropdown-item" href="<?php echo$this->echoRedirect('parametres');?>">
                <i class="fa fa-cog" aria-hidden="true"></i> Paramètres</a>
              <?php endif;?>
              <!-- END ADMIN -->
              <a class="dropdown-item" href="<?php echo $this->echoRedirect('deconnexion');?>">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</a>
            </div>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
</nav>