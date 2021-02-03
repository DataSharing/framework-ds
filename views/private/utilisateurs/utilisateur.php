<?php $u = $data['utilisateur'][0]; ?>
<form action="" method="post">
    <div class="container-app bg-transparent">
        <div class="row">
            <!-- INFOS Utilisateur -->
            <div class="col-12 col-md-8">
                <div class="card ">
                    <div class="card-header badge-dark">
                        <h5><i class='fas fa-info'></i><span class="float-right">Informations utilisateur</span></h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Nom</small>
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom']; ?>" required />
                        <small class="text-muted">Prénom</small>
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom']; ?>" required />
                        <small class="text-muted">E-mail</small>
                        <input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail']; ?>" required />
                        <small class="text-muted">Numéro de téléphone</small>
                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone']; ?>" />
                    </div>
                    <div class="card-footer">
                        <!-- ACTIONS -->
                        <button type="submit" name="submit" id="submit" value="fermer" class="btn btn-secondary">
                            <i class="fas fa-times" aria-hidden="true"></i> Fermer
                        </button>
                        <span class="float-right">
                            <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success">
                                <i class="fas fa-hdd" aria-hidden="true"></i> Enregistrer
                            </button>
                            <button type="submit" name="submit" id="submit" value="enregistrerEtFermer" class="btn btn-success">
                                <i class="fas fa-hdd" aria-hidden="true"></i> Enregistrer &amp; fermer
                            </button>
                        </span>
                        <!-- END ACTIONS -->
                    </div>
                </div>

                <div class="card mt-4 mb-4">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-history"></i><span class="float-right">Logs</span></h5>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        echo "<table class='table table-sm table-striped p-0 m-0'>";
                        echo "<tr>";
                        echo "<th>Date</th>";
                        echo "<th>id élément</th>";
                        echo "<th>Controller</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        foreach ($data['historique'] as $log) {
                            echo "<tr>";
                            echo "<td>" . $log['date_modification'] . "</td>";
                            echo "<td>";
                            if ($log['id_element'] == 0) {
                                echo "index";
                            } else {
                                echo $log['id_element'];
                            }
                            echo "</td>";
                            echo "<td>" . $log['controller'] . "</td>";
                            echo "<td>" . $log['action'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>

            <!-- END INFOS Utilisateur -->
            <!-- ACCES Utilisateur -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-user-cog"></i><span class="float-right">Accès utilisateur</span></h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Etat du compte</small>
                        <select name="etatcompte" class="custom-select w-100">
                            <option value="0" <?php if ($u['active'] == '0') echo "selected"; ?>>Compte désactivé</option>
                            <option value="1" <?php if ($u['active'] == '1') echo "selected"; ?>>Compte activé</option>
                        </select>
                        <small class="text-muted">Groupe</small>
                        <?= $this->selects->groupes($u['id_groupe']); ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" name="submit" id="submit" value="acces">
                                <span class="fas fa-edit" aria-hidden="true"></span> Modifier
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-lock" aria-hidden="true"></i><span class="float-right">Mot de passe</span></h5>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Nouveau mot de passe</small>
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe">
                        <small class="text-muted">Confirmation du nouveau mot de passe</small>
                        <input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe">
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            <button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning">
                                <i class="fas fa-star-of-life" aria-hidden="true"></i> Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header badge-dark">
                        <h5><i class="fas fa-trash"></i><span class="float-right">Supprimer le compte</span></h5>
                    </div>
                    <div class="card-body p-0">
                        <button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-danger w-100 m-0 rounded-0">
                            <span class="fas fa-trash" aria-hidden="true"></span> Suppression définitive
                        </button>
                    </div>
                </div>
            </div>
            <!-- END ACCES Utilisateur -->
        </div>
    </div>
</form>