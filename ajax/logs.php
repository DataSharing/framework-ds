<?php
if (isset($_POST['logs']) && isset($_POST['controller']) && isset($_POST['id']) && isset($_POST['par_page']) && isset($_POST['recherche']) && isset($_POST['col'])) {
    $par_page = intval($_POST['par_page']);
    $id = $_POST['id'];
    $controller = $_POST['controller'];
    $recherche = htmlentities($_POST['recherche']);
    $col = $_POST['col'];
    $limit = array('par_page' => $par_page, 'suivant' =>  0);

    include_once '../core/Model.php';

    $model = new Model();

    $model->table = "logs";
    $where = ['id_element' => $id, 'controller' => $controller];

    if ((!empty($recherche) || $recherche != 'undefined') && $col != '') {
        $where[$col] = "%" . $recherche . "%";
    }

    $logs = $model->lecture(
        ['SQL_CALC_FOUND_ROWS *', 'date_modification', 'action', 'modifie_par', 'id_description'],
        $where,
        'AND',
        ['date_modification' => 'desc'],
        $limit
    );
    $count = $model->foundRows();
?>
    <div class="col-12">
        <table class="table table-sm table-striped border">
            <tr>
                <th style='font-size:0.7em;'><i class='fas fa-calendar'></i> Date</th>
                <th style='font-size:0.7em;'><i class='fas fa-user-edit'></i> Utilisateur</th>
                <th style='font-size:0.7em;'><i class='fas fa-edit'></i> Action</th>
            </tr>
            <?php
            if (!empty($logs)) {
                foreach ($logs as $log) {
                    echo "<tr>";
                    echo "<td style='width:10%;font-size:0.7em;'>" . $log['date_modification'] . "</td>";
                    echo "<td style='width:10%;font-size:0.7em;'>" . $log['modifie_par'] . "</td>";
                    if ($log['id_description'] != 0) {
                        $model->table = "logs_description";
                        $data_description = $model->onerow('diff', ['id' => $log['id_description']]);
                        $data['id_description'] = $log['id_description'];
                        $data['diff'] = $data_description;

                        echo "<td style='font-size:0.7em;'>";
                        echo $log['action'];
                        include '../views/public/app/modals/description.php';
                        //echo "<a href='javascript:void(0)' data-toggle='modal' data-target='#description_" . $log['id_description'] . "'><i class='fas fa-not-equal'></i></a>";
                        echo  "</td>";
                    } else {
                        echo "<td style='font-size:0.7em;'>" . $log['action'] . "</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr class='bg-warning'><td colspan=3 style='font-size:0.7em;'>Historique vide...</td></tr>";
            }
            ?>
        </table>
        <?php if ($count > $par_page) { ?>
            <span class="d-flex justify-content-center">
                <a href='javascript:void(0)' Onclick="logs();" class="btn btn-sm btn-info"><i class='fas fa-refresh'></i> Charger plus d'élément</a>
            </span>
        <?php } ?>
    </div>
<?php
}
