<div class="container-app bg-transparent">
    <div class="row">
        <div class="col-12 col-lg-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-search"></i> Rechercher</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Groupes</h6>
                    <hr>
                    <form action="" method="get">
                        <?php if ($this->rewrite == "off") { ?>
                            <input type="hidden" name="p" value="groupes" />
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
                        <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-sm btn-danger">
                            <i class="fa fa-times" aria-hidden="true"></i> Effacer
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <button type="button" data-bs-toggle="modal" data-bs-target=".bs-ajouter-modal-sm" class="btn btn-sm btn-success w-auto">
                        <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un groupe
                    </button>
                    <span class="float-end">
                        <?= $data['pagination']; ?>
                    </span>
                    <table class="table table-sm table-striped" id="tableau">
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall" id="checkall" onclick="cocherOuDecocherTout(this)" />
                                <label for="checkall">
                                    <span></span>
                                    <a href='<?php echo $this->form->searchOrderBy('id', 'groupes'); ?>'>
                                        <i class="fas fa-arrows-alt-v"></i> #id
                                    </a>
                                </label>
                            </th>
                            <th>
                                <a href='<?php echo $this->form->searchOrderBy('Nom', 'groupes'); ?>'>
                                    <i class="fas fa-arrows-alt-v"></i> Nom
                                </a>
                            </th>
                        </tr>
                        <?php
                        if (!empty($data['groupes'])) {
                            foreach ($data['groupes'] as $groupe) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="groupes[]" id="<?php echo $groupe['id']; ?>" value="<?php echo $groupe['id']; ?>" />
                                        <label for="<?php echo $groupe['id']; ?>">
                                            <span></span><b>#<?php echo $groupe['id']; ?></b>
                                        </label>
                                    </td>
                                    <?php
                                    if ($groupe['est_archive'] == 1) {
                                        $getArchive = "?est_archive=1";
                                    } else {
                                        $getArchive = "";
                                    }
                                    ?>
                                    <td>
                                        <a href='<?php echo $this->echoRedirect("groupes/modifier/" . $groupe['id'] . $getArchive); ?>' class="font-weight-bold">
                                            <?php echo $groupe['nom']; ?>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        } else {
                            echo "<tr class='bg-warning font-weight-bold text-center'><td colspan=2><h4>Aucun résultat...</h4></td></tr>";
                        }
                        ?>
                    </table>
                    <?= $data['pagination']; ?>
                </div>
            </div>
        </div>
    </div>
</div>