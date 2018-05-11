<?php
$G = $data['groupe'][0];
?>
<form action="" method="post">
    <div class="container" style="margin:3em auto;padding:2em">
        <div class="row">

            <div class="col-12">
                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $G['nom']; ?>" />
                <textarea class="form-control" name="description" ><?php echo $G['description']; ?></textarea>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-plug" aria-hidden="true"></i> Plugins</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
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

                               if (isset($data['droitsPlugins']['plugin_' . $plugin['nom']])) {
                                  $droits = explode('+', $data['droitsPlugins']['plugin_' . $plugin['nom']]);
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
                               echo "<input type='hidden' name='controllers[]' value='plugin_" . $plugin['nom'] . "'  />";
                               echo "<tr>";
                               echo "<td>" . ucfirst($plugin['nom']) . "</td>";
                               echo "<td>";
                               echo "<input type='checkbox' name='lecture_plugin_" . $plugin['nom'] . "' id='lecture_plugin_" . $plugin['nom'] . "' " . $checkLecture . "/>";
                               echo "<label for='lecture_plugin_" . $plugin['nom'] . "'><span></span></label>";
                               echo "</td>";
                               echo "<td>";
                               echo "<input type='checkbox' name='modification_plugin_" . $plugin['nom'] . "' id='modification_plugin_" . $plugin['nom'] . "' " . $checkModif . "/>";
                               echo "<label for='modification_plugin_" . $plugin['nom'] . "'><span></span></label>";
                               echo "</td>";
                               echo "<td>";
                               echo "<input type='checkbox' name='suppression_plugin_" . $plugin['nom'] . "' id='suppression_plugin_" . $plugin['nom'] . "' " . $checkSuppr . "/>";
                               echo "<label for='suppression_plugin_" . $plugin['nom'] . "'><span></span></label>";
                               echo "</td>";
                               echo "</tr>";
                            }
                            if (count($data['plugins']) == 0) {
                               echo "<tr><td colspan=4><div class='alert alert-warning'>Aucun plugin d'installé</div></td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- TABLEAU DES ACCES CONTROLLERS-->
            <input type="hidden" name="id_groupe" id="id_groupe" value="<?php echo $data['id']; ?>" />
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b><i class="fa fa-lock" aria-hidden="true"></i> Droits d'accès par controlleurs</b>
                    </div>
                    <div class="card-body">
                        <p><b>Ctrl : Controlleur | L : Lecture | M : Modification | S/A : Suppression/Archivage</b></p><br/>
                        <div class="row">
                            <div class="col-12 col-md-4" style="padding: 0">
                                <select name="controller" id="controller" class="custom-select">
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
                                    <i class="fa fa-check" aria-hidden="true"></i></button>
                            </div>

                            <div class="col-12">
                                <div id="tab_acces">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Ctrl</th>
                                            <th>L</th>
                                            <th>M</th>
                                            <th>S/A</th>
                                        </tr>
                                        <?php
                                        foreach ($data['droits'] as $droit):
                                           $selectType = strpos($droit['controller'], 'type_');
                                           $selectPlugin = strpos($droit['controller'], 'plugin_');
                                           if ($selectType !== FALSE || $selectPlugin !== FALSE) {
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
                                        ?>                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TABLEAU DES ACCES TYPES -->
                <div class="card">
                    <div class="card-header">
                        <b><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Droits d'accès par type</b>
                    </div>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-12 col-md-4" style="padding: 0">
                                <select name="type" id="type" class="custom-select">
                                    <?php
                                    foreach ($data['types'] as $type):
                                       echo "<option value='" . strtolower("type_" . $type['nom']) . "'>" . $type['nom'] . "</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-success" onclick="DroitsType();" >
                                    <i class="fa fa-check" aria-hidden="true"></i></button>
                            </div>
                            <div class="col-12" style="padding: 0">
                                <table class="table" id="tab_acces_type">
                                    <?php
                                    foreach ($data['droits'] as $droit):
                                       $selectType = strpos($droit['controller'], 'type_');
                                       if ($selectType === FALSE) {
                                          continue;
                                       }
                                       echo "<tr>";
                                       echo "<td><label class='label-type'>" . $droit['controller'] . "</label></td>";
                                       $ctrl = "'" . $droit['controller'] . "'";
                                       echo '<td><button type="button" class="btn btn-sm btn-danger" style="padding: 0.3em;width:100%" onClick="supprimerDroit(' . $ctrl . ');"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';
                                       echo "</tr>";
                                    endforeach;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Interface -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <b><i class="fa fa-dashboard" aria-hidden="true"></i> Interface du tableau de bord</b>
                    </div>
                    <div class="card-body" >
                        <select name="interfaces" id="interfaces" class="custom-select" required>
                            <option value="administrateur" <?php if ($G['interface'] == "administrateur") echo "selected"; ?>>Administrateur</option>
                            <option value="moderateur" <?php if ($G['interface'] == "moderateur") echo "selected"; ?>>Modérateur</option>
                            <option value="emprunteur" <?php if ($G['interface'] == "emprunteur") echo "selected"; ?>>Emprunteur</option>
                        </select>
                    </div>
                </div>
                <!-- Groupe Référence -->
                <div class="card">
                    <div class="card-header">
                        <b><i class="fa fa-clone" aria-hidden="true"></i> Groupe référence</b>
                    </div>
                    <div class="card-body" >
                        <select name="groupe_reference" id="groupes_reference" class="custom-select" required>
                            <option value="1" <?php if ($G['id_reference'] == 1) echo "selected"; ?>>Administrateur</option>
                            <option value="2" <?php if ($G['id_reference'] == 2) echo "selected"; ?>>Modérateur</option>
                            <option value="3" <?php if ($G['id_reference'] == 3) echo "selected"; ?>>Emprunteur</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ACTIONS -->
            <div class="col-12 col-md-8">
                <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success">
                    <i class="fa fa-hdd-o" aria-hidden="true"></i> Enregistrer</button>
                <button type="submit" name="submit" id="submit" value="enregistreretfermer" class="btn btn-success">
                    <i class="fa fa-hdd-o" aria-hidden="true"></i> Enregistrer &amp; Fermer</button>
                <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-secondary">Fermer</a>
            </div>
            <div class="col-12 col-md-4">
                <button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-danger" style="float:right">
                    <i class="fa fa-trash" aria-hidden="true"></i> Supprimer</button>&nbsp;&nbsp;
                <button type="submit" name="submit" id="submit" value="archiver" class="btn btn-warning" style="float:right;margin-right: 3px">
                    <i class="fa fa-archive" aria-hidden="true"></i>
                    <?php
                    if ($G['est_archive'] == 1) {
                       echo "Restaurer";
                    } else {
                       echo "Archiver";
                    }
                    ?></button>
            </div>
        </div>
    </div>
</form>