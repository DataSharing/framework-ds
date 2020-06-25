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
                    <div class="card-header badge-dark">
                        <h5><i class='fas fa-info'></i><span class='float-right'>Général</span></h5>
                    </div>
                    <div class="card-body">
                        <?= $this->FormGeneral(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsGeneral(); ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card" style="min-height:27em;">
                    <div class="card-header badge-dark">
                        <h5><i class='fas fa-database'></i><span class='float-right'>Base de données</span></h5>
                    </div>
                    <div class="card-body">
                        <?= $this->FormBdd(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsBdd(); ?>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-4">
                <div class="card" style="min-height:27em;">
                    <div class="card-header badge-dark">
                        <h5><i class='fas fa-sign-in-alt'></i><span class='float-right'>Authentification</span></h5>
                    </div>
                    <div class="card-body">
                        <?= $this->FormAuth(); ?>
                    </div>
                    <div class="card-footer">
                        <?= $this->ActionsAuth(); ?>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 mb-4">
                <div class="card">
                    <div class="card-header badge-dark">
                        <h5><i class='fas fa-history'></i><span class='float-right'>Logs</span></h5>
                    </div>
                    <div class="card-body  p-0">
                        <?= $this->FormLogs(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>