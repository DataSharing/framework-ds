<div class="container-app bg-transparent">
    <div class="row">
        <div class="col-12 col-lg-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-search"></i> Rechercher</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Utilisateurs</h6>
                    <hr>
                    <form action="" method="get">
                        <?php if ($this->rewrite == "off") { ?>
                            <input type="hidden" name="p" value="utilisateurs" />
                        <?php } ?>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <a href="<?php echo $this->echoRedirect('utilisateurs'); ?>" class="btn btn-sm btn-danger">
                            <i class="fa fa-times" aria-hidden="true"></i> Effacer
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <form action="" method="post">
                <div class="card">
                    <div class="card-body">
                        <button type="button" data-bs-toggle="modal" data-bs-target=".bs-ajouter-modal-sm" class="btn btn-sm btn-success w-auto">
                            <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un utilisateur
                        </button>
                        <span class="float-end">
                            <?= $data['pagination']; ?>
                        </span>
                        <table class="table table-striped table-sm" id="tableau">
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall" id="checkall" onclick="cocherOuDecocherTout(this)" />
                                    <label for="checkall">
                                        <span></span>
                                        <a href='<?php echo $this->form->searchOrderBy('p.id', 'utilisateurs'); ?>'>
                                            <i class="fas fa-arrows-alt-v"></i>
                                        </a>
                                    </label>
                                </th>
                                <th>
                                    <a href='<?php echo $this->form->searchOrderBy('u.nom', 'utilisateurs'); ?>'>
                                        <i class="fas fa-arrows-alt-v"></i> Nom & prénom
                                    </a>
                                </th>
                            </tr>
                            <?php
                            if (!empty($data['all'])) {
                                foreach ($data['all'] as $utilisateur) :

                            ?>
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" name="utilisateurs[]" id="<?php echo $utilisateur['id']; ?>" value="<?php echo $utilisateur['id']; ?>" />
                                            <label for="<?php echo $utilisateur['id']; ?>">
                                                <span></span><b>#<?php echo $utilisateur['id']; ?></b>
                                            </label>
                                        </td>
                                        <?php if ($utilisateur['active'] == 1) {
                                            $etat = '<span class="badge bg-success">Activé</span> ';
                                        } else {
                                            $etat = '<span class="badge bg-danger">Désactivé</span> ';
                                        } ?>
                                        <td  class="zoneClick">
                                            <?php echo $etat; ?>
                                            <a href='<?php echo $this->echoRedirect("utilisateurs/" . $utilisateur['id']); ?>'>
                                                <?php echo $utilisateur['nom'] . " " . $utilisateur['prenom']; ?>
                                            </a>
                                            <small class="text-muted d-block"><?= $utilisateur['groupe']; ?></small>
                                            <small class="text-muted"><?= $utilisateur['mail']; ?>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            } else {
                                echo "<tr class='bg-warning font-weight-bold text-center'><td colspan=6><h4>Aucun résultat...</h4></td></tr>";
                            }
                            ?>
                        </table>
                        <?= $data['pagination']; ?>
                    </div>
                </div>
        </div>
    </div>
</div>
</form>

<form action="" method="post">
    <!-- MODAL AJOUTER UTILISATEUR -->
    <div class="modal fade bs-ajouter-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small class="text-muted">Nom</small>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" required />
                    <small class="text-muted">Prénom</small>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" required />
                    <small class="text-muted">E-mail</small>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Adresse email" required />
                    <small class="text-muted">Numéro de téléphone</small>
                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" />
                    <small class="text-muted">Groupe</small>
                    <?= $this->selects->groupes(); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" value="AjouterUtilisateur" class="btn btn-success">
                        <i class="fas fa-plus" aria-hidden="true"></i> Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>