<div class="container-app bg-transparent">
    <div class="row">
        <!-- ACTIONS -->
        <div class="col-12 col-lg-2">
            <button type="button" data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-success w-100">
                <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un groupe
            </button>
        </div>

        <!--RECHERCHE -->
        <div class="col-12 col-lg-8">
            <form action="" method="get">
                <?php if ($this->rewrite == "off") { ?>
                    <input type="hidden" name="p" value="groupes" />
                <?php } ?>
                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
        </div>

        <div class="col-12 col-lg-2">
            <button type="submit" class="btn btn-secondary">
                <i class="fa fa-search" aria-hidden="true"></i> Rechercher
            </button>
            <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i> Reset
            </a>
        </div>

        </form>
        <!-- ARCHIVEs 
        <div class="col-12 col-md-3">
            <?php
            /*
            if ($data['archives'] == 0) {
                echo "<a href='" . $this->echoRedirect('groupes/archives') . "' class='btn btn-primary' style='float:right;' />";
                echo '<i class="fa fa-archive" aria-hidden="true"></i> Archives';
                echo "</a>";
            } else {
                echo "<a href='" . $this->echoRedirect('groupes') . "' class='btn btn-primary' style='float:right;' />";
                echo '<i class="fa fa-archive" aria-hidden="true"></i> Fermer archives';
                echo "</a>";
            }*/
            ?>
        </div>-->

        <!-- form for massives actions -->
        <form></form>
        <div class="col-12 col-md-12">
            <hr>
            <span class="float-right">
                <?= $data['pagination']; ?>
            </span>
            <table class="table table-sm table-striped bg-white  border" id="tableau" style="box-shadow:0 1px 8px #ddd;">
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