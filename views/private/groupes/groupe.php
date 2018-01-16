<?php
$G = $data['groupe'][0];
?>
<form action="" method="post" class="row">
    <div class="container" style="margin:3em auto;padding:2em">
        <div class="col-12">
            <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $G['nom']; ?>" />
            <textarea class="form-control" name="description" ><?php echo $G['description']; ?></textarea>
        </div>

        <!-- TABLEAU DES ACCES CONTROLLERS-->
        <input type="hidden" name="id_groupe" id="id_groupe" value="<?php echo $data['id']; ?>" />
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Droits d'accès par controlleurs</b>
                </div>
                <div class="panel-body">
                    <div class="col-12 col-md-4" style="padding: 0">
                        <select name="controller" id="controller" class="form-control">
                            <?php
                            $TousLesControlleurs = scandir('./controllers');
                            foreach ($TousLesControlleurs as $ctrl):
                                $ExCtrl = explode('.php', $ctrl);
                                $ctrl = strtolower($ExCtrl[0]);
                                if ($ctrl == "" || $ctrl == "." || $ctrl == ".." || $ctrl == "erreur" || $ctrl == "authentification" || $ctrl == "deconnexion" || $ctrl == "") {
                                    continue;
                                }
                                echo "<option value='" . $ctrl . "'>" . $ctrl . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-1">
                        <button type="button" class="btn btn-success" onclick="Droits();" >
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                    <br/>
                    <div id="tab_acces">
                        <table class="table table-striped">
                            <tr>
                                <th>Controller</th>
                                <th>Lecture</th>
                                <th>Modification</th>
                                <th>Suppression/Archivage</th>
                            </tr>
<?php
foreach ($data['droits'] as $droit):
    $selectType = strpos($droit['controller'], 'type_');
    if ($selectType !== FALSE) {
        continue;
    }
    $lecture = 0;
    $modification = 0;
    $suppression = 0;
    echo "<tr>";
    echo "<td>" . $droit['controller'] . "</td>";
    echo "<input type='hidden' name='controllers[]' value='" . $droit['controller'] . "'  />";
    $droits = explode('+', $droit['droit']);
    $nbDroits = count($droits);

    //LECTURE
    for ($i = 0; $i < $nbDroits; $i++):
        if ($droits[$i] == 7) {
            echo "<td>";
            echo "<input type='checkbox' name='lecture_" . $droit['controller'] . "' id='lecture_" . $droit['controller'] . "' checked/>";
            echo "<label for='lecture_" . $droit['controller'] . "'><span></span></label>";
            echo "</td>";
            $lecture = 1;
        }
    endfor;
    if ($lecture == 0) {
        echo "<td>";
        echo "<input type='checkbox' name='lecture_" . $droit['controller'] . "' id='lecture_" . $droit['controller'] . "' />";
        echo "<label for='lecture_" . $droit['controller'] . "'><span></span></label>";
        echo "</td>";
    }

    //MODIFICATION
    for ($i = 0; $i < $nbDroits; $i++):
        if ($droits[$i] == 77) {
            echo "<td>";
            echo "<input type='checkbox' name='modification_" . $droit['controller'] . "' id='modification_" . $droit['controller'] . "' checked/>";
            echo "<label for='modification_" . $droit['controller'] . "'><span></span></label>";
            echo "</td>";
            $modification = 1;
        }
    endfor;
    if ($modification == 0) {
        echo "<td>";
        echo "<input type='checkbox' name='modification_" . $droit['controller'] . "' id='modification_" . $droit['controller'] . "' />";
        echo "<label for='modification_" . $droit['controller'] . "'><span></span></label>";
        echo "</td>";
    }

    //SUPPRESSION
    for ($i = 0; $i < $nbDroits; $i++):
        if ($droits[$i] == 777) {
            echo "<td>";
            echo "<input type='checkbox' name='suppression_" . $droit['controller'] . "' id='suppression_" . $droit['controller'] . "' checked/>";
            echo "<label for='suppression_" . $droit['controller'] . "'><span></span></label>";
            echo "</td>";
            $suppression = 1;
        }
    endfor;
    if ($suppression == 0) {
        echo "<td>";
        echo "<input type='checkbox' name='suppression_" . $droit['controller'] . "' id='suppression_" . $droit['controller'] . "' />";
        echo "<label for='suppression_" . $droit['controller'] . "'><span></span></label>";
        echo "</td>";
    }
    echo "</tr>";
endforeach;
?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACTIONS -->

            <div class="col-12 col-md-10" style="float:left">
                <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success"><i class="fa fa-hdd-o" aria-hidden="true"></i> Enregistrer</button>
                <button type="submit" name="submit" id="submit" value="enregistreretfermer" class="btn btn-success"><i class="fa fa-hdd-o" aria-hidden="true"></i> Enregistrer &amp; Fermer</button>
                <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-secondary">Fermer</a>	
            </div>
            <div class="col-12 col-md-4">
<?php if (!$data['id'] == 1 || !$data['id'] == 2 || !$data['id'] == 3) { ?>
                    <button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-danger" style="float:right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</button>&nbsp;&nbsp;
                    <button type="submit" name="submit" id="submit" value="archiver" class="btn btn-warning" style="float:right;margin-right: 3px"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> 
                    <?php
                    if ($G['est_archive'] == 1) {
                        echo "Restaurer";
                    } else {
                        echo "Archiver";
                    }
                    ?></button>
                    <?php } //END IF DATA['ID'] ?>
            </div>
    </div>
</form>