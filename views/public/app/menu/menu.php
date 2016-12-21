<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><b style="color:#f7464a">D</b>S Framework</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class=""><a href="<?php echo $this->base_url;?>accueil"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>  Accueil</a></li>
        </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right: 0em">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->mail;?> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span></a>
            <ul class="dropdown-menu">
              <!-- MENU ADMIN -->
              <?php if($this->session->acces == "admin"):?>
              <li><a href="<?php echo$this->base_url;?>utilisateurs"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Utilisateurs</a></li>
              <?php endif;?>
              <!-- END ADMIN -->
              <li><a href="<?php echo $this->base_url;?>deconnexion"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Déconnexion</a></li>
            </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
</nav>