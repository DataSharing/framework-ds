<?php $u = $data['utilisateur'][0]; ?>
<form action="" method="post">
    <div class="container-app bg-transparent">
        <div class="row">
            <div class="col-12 col-md-8 mb-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-circle"></i> Mon profil
                            <button type="submit" name="submit" id="submit" value="fermer" class="btn btn-sm btn-dark w-auto float-end">
                                <span class="fas fa-times" aria-hidden="true"></span> Fermer
                            </button>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $data['nom_groupe']; ?></h6>
                        <hr>
                        <small class="text-muted">Votre nom</small>
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom']; ?>" required />
                        <small class="text-muted">Votre prénom</small>
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom']; ?>" required />
                        <small class="text-muted">Votre adresse email</small>
                        <input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail']; ?>" required />
                        <small class="text-muted">Votre numéro de téléphone</small>
                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone']; ?>" />
                        <hr>
                        <span class="float-right">
                            <button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success w-25">
                                <span class="fas fa-hdd" aria-hidden="true"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-lock" aria-hidden="true"></i> Mot de passe</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Réinitialiser votre mot de passe</h6>
                        <hr>
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe">
                        <input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe">
                        <hr>
                        <button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning">
                            <i class="fas fa-star-of-life" aria-hidden="true"></i> Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>