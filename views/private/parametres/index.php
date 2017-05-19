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
echo '<div class="col-sm-24 col-md-24 container">';
        echo '<div class="panel panel-inverse">';
            echo '<div class="panel-heading"><i class="icon icon-cogs icon-fw"></i> Configurations</div>';
            echo '<div class="panel-body">';
                //MENU
                echo '<ul class="nav nav-tabs" role="tablist">';
                    echo '<li class="'.$active_default.'"><a aria-controls="general" role="tab" data-toggle="tab" href="#general">Général</a></li>';
                    echo '<li class=""><a aria-controls="bdd" role="tab" data-toggle="tab" href="#bdd">Base de données</a></li>';
                    echo '<li class=""><a aria-controls="auth" role="tab" data-toggle="tab" href="#auth">Authentification</a></li>';
                    echo '<li class="'.$active_logs.'"><a aria-controls="logs" role="tab" data-toggle="tab" href="#logs">Logs</a></li>';
                echo '</ul><br>';

                //CONTENU
                echo '<div class="tab-content">';
                    #GENERAL
                    echo '<div id="general" class="tab-pane fade '.$class_default.'">';
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
