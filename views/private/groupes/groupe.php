<?php
$G = $data['groupe'][0];
?>
<form action="" method="post" class="row">
    <div class="container-app bg-transparent">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-info"></i><span class="float-right">Informations groupe</span></h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Nom</small>
                        <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $G['nom']; ?>" />
                        <small class="text-muted">Description</small>
                        <textarea class="form-control" name="description"><?php echo $G['description']; ?></textarea>
                        <small class="text-muted d-block mb-2">Utilisateurs intégrés au groupe</small>
                        <?php
                        if (!empty($data['utilisateurs_groupe'])) {
                            foreach ($data['utilisateurs_groupe'] as $ug) {
                                echo "<a href='" . $this->echoRedirect('utilisateurs/' . $ug['id']) . "' class='font-weight-bold d-block' target='_blank'>";
                                echo "<i class='fas fa-user'></i> ";
                                echo $ug['nom'] . " " . $ug['prenom'] . "</a>";
                            }
                        } else {
                            echo "<span class='badge badge-warning'>Aucun utilisateur dans ce groupe</span>";
                        }
                        ?>
                    </div>
                    <div class="card-footer">
                        <!-- ACTIONS -->
                        <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-sm btn-success">
                            <i class="fa fa-hdd" aria-hidden="true"></i> Enregistrer
                        </button>
                        <button type="submit" name="submit" id="submit" value="enregistreretfermer" class="btn btn-sm btn-success">
                            <i class="fa fa-hdd" aria-hidden="true"></i> Enregistrer &amp; Fermer
                        </button>
                        <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times"></i> Fermer
                        </a>
                        <div class="float-right">
                            <button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-sm btn-danger" style="float:right">
                                <span class="fas fa-trash" aria-hidden="true"></span> Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLEAU DES ACCES CONTROLLERS-->
            <input type="hidden" name="id_groupe" id="id_groupe" value="<?php echo $data['id']; ?>" />
            <div class="col-12 col-lg-8 pr-0">
                <div class="card">
                    <div class="card-header badge-dark">
                        <h5><i class="fa fa-lock" aria-hidden="true"></i><span class="float-right">Droits d'accès aux controlleurs</span></h5>
                    </div>
                    <div class="card-body">
                        <select name="controller" id="controller" class="custom-select">
                            <?php
                            $TousLesControlleurs = scandir('./controllers');
                            foreach ($TousLesControlleurs as $ctrl) :
                                $ExCtrl = explode('.php', $ctrl);
                                $ctrl = strtolower($ExCtrl[0]);
                                if ($ctrl == "" || $ctrl == "." || $ctrl == ".." || $ctrl == "erreur" || $ctrl == "authentification" || $ctrl == "deconnexion" || $ctrl == "") {
                                    continue;
                                }
                                echo "<option value='" . $ctrl . "'>" . $ctrl . "</option>";
                            endforeach;
                            ?>
                        </select>
                        <button type="button" class="btn btn-success mt-2" onclick="Droits();">
                            <i class="fa fa-plus" aria-hidden="true"></i> Ajouter le controller
                        </button>
                        <div id="tab_acces">
                            <table class="table table-striped border">
                                <tr>
                                    <th>Controller</th>
                                    <th>Lecture</th>
                                    <th>Modification</th>
                                    <th>Suppression/Archivage</th>
                                </tr>
                                <?php
                                foreach ($data['droits'] as $droit) :
                                    $selectType = strpos($droit['controller'], 'plugin_');
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
                                    for ($i = 0; $i < $nbDroits; $i++) :
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
                                    for ($i = 0; $i < $nbDroits; $i++) :
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
                                    for ($i = 0; $i < $nbDroits; $i++) :
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
                    <div class="card-footer">
                        <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-sm btn-success">
                            <i class="fa fa-hdd" aria-hidden="true"></i> Enregistrer
                        </button>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-plug"></i><span class="float-right">Droits d'accès aux plugins</span></h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped border">
                            <tr>
                                <th>Controller</th>
                                <th>Lecture</th>
                                <th>Modification</th>
                                <th>Suppression/Archivage</th>
                            </tr>
                            <?php
                            foreach ($data['plugins'] as $plugin) {
                                $checkLecture = "";
                                $checkModif = "";
                                $checkSuppr = "";
                                $nomPlugin = strtolower($plugin['nom']);
                                if (isset($data['droitsPlugins']['plugin_' . $nomPlugin])) {
                                    $droits = explode('+', $data['droitsPlugins']['plugin_' . $nomPlugin]);
                                    foreach ($droits as $droit) {
                                        if ($droit == 7) {
                                            $checkLecture = "checked";
                                        }
                                        if ($droit == 77) {
                                            $checkModif = "checked";
                                        }
                                        if ($droit == 777) {
                                            $checkSuppr = "checked";
                                        }
                                    }
                                }
                                echo "<input type='hidden' name='controllers[]' value='plugin_" . $nomPlugin . "'  />";
                                echo "<tr>";
                                echo "<td>" . ucfirst($nomPlugin) . "</td>";
                                echo "<td>";
                                echo "<input type='checkbox' name='lecture_plugin_" . $nomPlugin . "' id='lecture_plugin_" . $nomPlugin . "' " . $checkLecture . "/>";
                                echo "<label for='lecture_plugin_" . $nomPlugin . "'><span></span></label>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type='checkbox' name='modification_plugin_" . $nomPlugin . "' id='modification_plugin_" . $nomPlugin . "' " . $checkModif . "/>";
                                echo "<label for='modification_plugin_" . $nomPlugin . "'><span></span></label>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type='checkbox' name='suppression_plugin_" . $nomPlugin . "' id='suppression_plugin_" . $nomPlugin . "' " . $checkSuppr . "/>";
                                echo "<label for='suppression_plugin_" . $nomPlugin . "'><span></span></label>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            if (count($data['plugins']) == 0) {
                                echo "<tr><td colspan=4><div class='alert alert-warning'>Aucun plugin d'installé</div></td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-sm btn-success">
                            <i class="fa fa-hdd" aria-hidden="true"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>