<?php $u = $data['utilisateur'][0]; ?>
<form action="" method="post">
    <div class="container-app bg-transparent">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-cog"></i> Général
                            <button type="submit" name="submit" id="submit" value="fermer" class="btn btn-sm btn-dark float-end w-auto">
                                <i class="fas fa-times" aria-hidden="true"></i> Fermer
                            </button>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">informations utilisateur</h6>
                        <hr>
                        <small class="text-muted">Nom</small>
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom']; ?>" required />
                        <small class="text-muted">Prénom</small>
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom']; ?>" required />
                        <small class="text-muted">E-mail</small>
                        <input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail']; ?>" required />
                        <small class="text-muted">Numéro de téléphone</small>
                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone']; ?>" />
                        <hr>
                        <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success">
                            <i class="fas fa-hdd" aria-hidden="true"></i> Enregistrer
                        </button>
                        <button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-danger">
                            <span class="fas fa-trash" aria-hidden="true"></span> Suppression définitive
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-2">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-cog"></i> Accès</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Accès utilisateur</h6>
                        <hr>
                        <small class="text-muted">Etat du compte</small>
                        <select name="etatcompte" class="form-select w-100">
                            <option value="0" <?php if ($u['active'] == '0') echo "selected"; ?>>Compte désactivé</option>
                            <option value="1" <?php if ($u['active'] == '1') echo "selected"; ?>>Compte activé</option>
                        </select>
                        <small class="text-muted">Groupe</small>
                        <?= $this->selects->groupes($u['id_groupe']); ?>
                        <hr>
                        <button type="submit" class="btn btn-primary" name="submit" id="submit" value="acces">
                            <span class="fas fa-edit" aria-hidden="true"></span> Modifier
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-lock"></i> Mot de passe</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Réinitialisation du mot de passe</h6>
                        <hr>
                        <small class="text-muted">Nouveau mot de passe</small>
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe">
                        <small class="text-muted">Confirmation du nouveau mot de passe</small>
                        <input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe">
                        <hr>
                        <button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning">
                            <i class="fas fa-star-of-life" aria-hidden="true"></i> Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-lock"></i> Logs</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Toutes les connexions</h6>
                        <hr>
                        <?php
                        echo "<table class='table table-sm table-striped p-0 m-0'>";
                        echo "<tr>";
                        echo "<th>Date</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        foreach ($data['historique'] as $log) {
                            echo "<tr>";
                            echo "<td>" . $log['date_modification'] . "</td>";
                            echo "<td>" . $log['action'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>