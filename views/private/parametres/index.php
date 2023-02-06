<?php
if ($data['page'] == 0) {
    $class_default = 'active in';
    $active_default = 'active';
    $class_logs = '';
    $active_logs = '';
} else {
    $class_default = '';
    $active_default = '';
    $class_logs = 'active in';
    $active_logs = 'active';
}
?>
<form action="" method="post">
    <div class="container-app bg-transparent">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card" style="min-height:27em;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-info"></i> Général
                            <a href='index.php' class="btn btn-sm btn-dark w-auto float-end">
                                <i class="fas fa-times" aria-hidden="true"></i> Fermer
                            </a>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Informations application</h6>
                        <hr>
                        <?= $this->FormGeneral(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsGeneral(); ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card" style="min-height:27em;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-database"></i> Base de données</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Informations de connexion</h6>
                        <hr>
                        <?= $this->FormBdd(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsBdd(); ?>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-4">
                <div class="card" style="min-height:27em;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-sign-in-alt"></i> Authentification</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Informations d'authentification</h6>
                        <hr>
                        <?= $this->FormAuth(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsAuth(); ?>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-history"></i> Logs</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Connexion/déconnexion utilisateurs</h6>
                        <hr>
                        <?= $this->FormLogs(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>