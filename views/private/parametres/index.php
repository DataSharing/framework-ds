<?php
if($data['page'] == 0){
    $class_default = 'active in';
    $active_default = 'active';
    $class_logs = '';
    $active_logs = '';
}else{
    $class_default = '';
    $active_default = '';
    $class_logs = 'active in';
    $active_logs = 'active';
}
echo "<br>";
echo '<div class="col-sm-24 col-md-24 container" style="margin:4em auto;">';
        echo '<div class="card">';
            echo '<div class="card-header"><i class="icon icon-cogs icon-fw"></i> Configurations</div>';
            echo '<div class="card-block">';
                //MENU
                echo '<nav class="nav nav-pills flex-column flex-sm-row">';
                    echo '<a aria-controls="general" role="tab" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link active" href="#general">Général</a>';
                    echo '<a aria-controls="bdd" role="tab" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link" href="#bdd">Base de données</a>';
                    echo '<a aria-controls="auth" role="tab" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link"  href="#auth">Authentification</a>';
                    echo '<a aria-controls="logs" role="tab" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link"  href="#logs">Logs</a>';
                echo '</nav><br>';

                //CONTENU
                echo '<div class="tab-content">';
                    #GENERAL
                    echo '<div id="general" class="tab-pane fade show active">';
                    echo "<form name='configurations' action='' method='post'>";
                        echo "<div class='col-sm-10 col-md-8'>";
                            $this->FormGeneral();
                        echo "</div>";
                    echo "</form>";
                    echo '</div>';
                    #BDD
                    echo '<div id="bdd" class="tab-pane fade">';
                    echo "<form name='configurations' action='' method='post'>";
                        echo "<div class='col-sm-10 col-md-8'>";
                            $this->FormBdd();
                        echo "</div>";
                    echo "</form>";
                    echo '</div>';
                    #Auth
                    echo '<div id="auth" class="tab-pane fade">';
                    echo "<form name='configurations' action='' method='post'>";
                        echo "<div class='col-sm-10 col-md-8'>";
                            $this->FormAuth();
                        echo "</div>";
                    echo "</form>";
                    echo '</div>';
                    #logs
                    echo '<div id="logs" class="tab-pane fade '.$class_logs.'">';
                    echo "<form name='configurations' action='' method='post'>";
                        $this->FormLogs();
                    echo "</form>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
