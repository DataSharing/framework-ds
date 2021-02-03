<div class="container-app bg-transparent">
    <div class="row">
        <!-- ACTIONS -->
        <div class="col-12 col-lg-2">
            <button type="button" data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-success w-100">
                <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un utilisateurs
            </button>
        </div>

        <!--RECHERCHE -->
        <div class="col-12 col-lg-8">
            <form action="" method="get">
                <?php if ($this->rewrite == "off") { ?>
                    <input type="hidden" name="p" value="utilisateurs" />
                <?php } ?>
                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
        </div>

        <div class="col-12 col-lg-2">
            <button type="submit" class="btn btn-secondary">
                <i class="fa fa-search" aria-hidden="true"></i> Rechercher
            </button>
            <a href="<?php echo $this->echoRedirect('utilisateurs'); ?>" class="btn btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i> Reset
            </a>
        </div>
        </form>

        <!-- ARCHIVEs 
        <div class="col-12 col-lg-1">
            <?php
            /*
            if ($data['archives'] == 0) {
                echo "<a href='" . $this->echoRedirect('utilisateurs/archives') . "' class='btn btn-primary' style='float:right;' />";
                echo '<i class="fa fa-archive" aria-hidden="true"></i> Archives';
                echo "</a>";
            } else {
                echo "<a href='" . $this->echoRedirect('utilisateurs') . "' class='btn btn-primary' style='float:right;' />";
                echo '<i class="fa fa-archive" aria-hidden="true"></i> Fermer archives';
                echo "</a>";
            }*/
            ?>
        </div>
        -->
        <div class="col-12 col-md-12">
            <hr>
            <form action="" method="post">
                <div class="">
                    <span class="float-right">
                        <?= $data['pagination']; ?>
                    </span>
                    <table class="table table-sm table-striped bg-white  border" id="tableau" style="box-shadow:0 1px 8px #ddd;">
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall" id="checkall" onclick="cocherOuDecocherTout(this)" />
                                <label for="checkall">
                                    <span></span>
                                    <a href='<?php echo $this->form->searchOrderBy('p.id', 'utilisateurs'); ?>'>
                                        <i class="fas fa-arrows-alt-v"></i> #id
                                    </a>
                                </label>
                            </th>
                            <th>
                                <a href='<?php echo $this->form->searchOrderBy('u.active', 'utilisateurs'); ?>'>
                                    <i class="fas fa-arrows-alt-v"></i> Etat
                                </a>
                            </th>
                            <th>
                                <a href='<?php echo $this->form->searchOrderBy('u.nom', 'utilisateurs'); ?>'>
                                    <i class="fas fa-arrows-alt-v"></i> Nom & prénom
                                </a>
                            </th>
                            <th>
                                <a href='<?php echo $this->form->searchOrderBy('g.nom', 'utilisateurs'); ?>'>
                                    <i class="fas fa-arrows-alt-v"></i> Groupe
                                </a>
                            </th>
                            <th>e-mail</th>
                            <th>
                                <a href='<?php echo $this->form->searchOrderBy('u.date_creation', 'utilisateurs'); ?>'>
                                    <i class="fas fa-arrows-alt-v"></i> Date création
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
                                        $etat = '<span class="badge badge-success">Activé</span>';
                                    } else {
                                        $etat = '<span class="badge badge-danger">Désactivé</span>';
                                    } ?>
                                    <td>
                                        <?php echo $etat; ?>
                                    </td>
                                    <td>
                                        <a href='<?php echo $this->echoRedirect("utilisateurs/" . $utilisateur['id']); ?>' class='font-weight-bold'>
                                            <?php echo $utilisateur['nom'] . " " . $utilisateur['prenom']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $utilisateur['groupe']; ?>
                                    </td>
                                    <td>
                                        <?= $utilisateur['mail']; ?>
                                    </td>
                                    <td>
                                        <?= $utilisateur['date_creation']; ?>
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
</form>

<form action="" method="post">
    <!-- MODAL AJOUTER UTILISATEUR -->
    <div class="modal fade bs-ajouter-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" name="submit" id="submit" value="AjouterUtilisateur" class="btn btn-success">
                        <i class="fas fa-plus" aria-hidden="true"></i> Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>