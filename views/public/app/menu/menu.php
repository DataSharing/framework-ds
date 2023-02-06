<nav class="navbar navbar-dark  fixed-top navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Data Sharing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <?php if ($this->session->CheckRightMain('accueil', LECTURE)) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->echoRedirect('accueil'); ?>">
              <i class="fa fa-home" aria-hidden="true"></i> Accueil
            </a>
          </li>
          <?php endif;
        if ($this->session->CheckRightMainPlugins('plugin_', LECTURE)) :
          if ($this->plugin->nb() >= 1) {
          ?>
            <li class="nav-item dropdown">
              <a id="dropdown03" class="nav-link" href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plug" aria-hidden="true"></i> Plugins
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdown02">
                <?php
                foreach ($this->plugin->allPlugins() as $data) {
                  if ($this->session->CheckRightPlugin('plugin_' . strtolower($data['directory']), LECTURE)) {
                    echo "<a href='" . $this->echoRedirect('plugins/' . strtolower($data['directory'])) . "' class='dropdown-item' >";
                    echo $data['name'];
                    echo "</a>";
                  }
                }
                ?>
              </div>
            </li>
        <?php
          }
        endif; ?>
      </ul>
      <div class="d-flex">
        <div class="dropdown">
          <a class="text-white nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $this->session->mail; ?> <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="<?php echo $this->echoRedirect('profil'); ?>">
                <i class="fa fa-user-circle" aria-hidden="true"></i> Mon profil
              </a>
            </li>
            <?php if ($this->session->CheckRightMain('utilisateurs', LECTURE)) : ?>
              <li>
                <a class="dropdown-item" href="<?php echo $this->echoRedirect('utilisateurs'); ?>">
                  <i class="fa fa-user" aria-hidden="true"></i> Utilisateurs
                </a>
              </li>
            <?php endif;
            if ($this->session->CheckRightMain('groupes', LECTURE)) : ?>
              <li>
                <a class="dropdown-item" href="<?php echo $this->echoRedirect('groupes'); ?>">
                  <i class="fa fa-users" aria-hidden="true"></i> Groupes
                </a>
              </li>
            <?php endif;
            if ($this->session->CheckRightMain('parametres', LECTURE)) : ?>
              <li>
                <a class="dropdown-item" href="<?php echo $this->echoRedirect('parametres'); ?>">
                  <i class="fa fa-cog" aria-hidden="true"></i> Paramètres
                </a>
              </li>
            <?php endif;
            if ($this->session->CheckRightMain('plugins', LECTURE)) : ?>
              <li>
                <a class="dropdown-item" href="<?php echo $this->echoRedirect('plugins'); ?>">
                  <i class="fa fa-plug" aria-hidden="true"></i> Plugins
                </a>
              </li>
            <?php endif; ?>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo $this->echoRedirect('deconnexion'); ?>">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Déconnexion
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>