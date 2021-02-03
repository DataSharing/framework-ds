<?php $u = $data['utilisateur'][0]; ?>
<form action="" method="post">
    <div class="container-app bg-transparent">
        <div class="row">
            <!-- INFOS Utilisateur -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header badge-dark">
                        <h5>
                            <i class="fas fa-info" aria-hidden="true"></i> Informations utilisateur
                        </h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom']; ?>" required />
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom']; ?>" required />
                        <input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail']; ?>" required />
                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone']; ?>" />
                    </div>
                    <div class="card-footer">
                        <!-- ACTIONS -->
                        <button type="submit" name="submit" id="submit" value="fermer" class="btn btn-secondary">
                            <span class="fas fa-times" aria-hidden="true"></span> Fermer
                        </button>
                        <span class="float-right">
                            <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success">
                                <span class="fas fa-hdd" aria-hidden="true"></span> Enregistrer
                            </button>
                            <button type="submit" name="submit" id="submit" value="enregistrerEtFermer" class="btn btn-success">
                                <span class="fas fa-hdd" aria-hidden="true"></span> Enregistrer &amp; fermer
                            </button>
                        </span>
                        <!-- END ACTIONS -->
                    </div>
                </div>
            </div>
            <!-- END INFOS Utilisateur -->
            <div class="col-12 col-md-4">
                <div class="card ">
                    <div class="card-header badge-dark">
                        <h5>
                            <i class="fas fa-lock" aria-hidden="true"></i> Mot de passe
                        </h5>
                    </div>
                    <div class="card-body">
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe">
                        <input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe">
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning">
                            <i class="fas fa-star-of-life" aria-hidden="true"></i> Réinitialiser
                        </button>
                    </div>
                </div><br />
                <div class="card ">
                    <div class="card-header badge-dark">
                        <h5>
                            <i class="fa fa-users" aria-hidden="true"></i> Groupe
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php echo $data['nom_groupe']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>