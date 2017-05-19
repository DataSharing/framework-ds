<div class="container" style="margin:3em auto;padding:2em">
    <!-- ACTIONS -->
    <div class="col-md-12" style="background:#f1f1f1;padding:1em">
        <div class="col-md-10">
            <button type="button"  data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-xs btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Groupe</button>
        </div>
        <div class="col-md-2" style="float:right">
            <div class="btn-group btn-toggle"> 
                <a href="<?php echo $this->echoRedirect('groupes/archives'); ?>" class="btn btn-default <?php if ($data['archives'] == 1) echo 'active'; ?>" alt="Archives"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span></a>
                <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-default <?php if ($data['archives'] == 0) echo 'active'; ?>"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></a>
            </div>
        </div>
    </div>
    <!--RECHERCHE -->
    <form action="" method="get">
        <?php if ($this->rewrite == "off") { ?>
            <input type="hidden" name="p" value="groupes" />
        <?php } ?>
        <div class="col-md-12" style="background:#ddd;padding:1em">
            <div class="col-md-9">
                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Rechercher</button>
                <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </div>
        </div>
    </form>
    <!-- form for massives actions -->
    <form></form>
    <div class="" >
        <?php
        $count = count($data['groupes']);
        if ($count > 1) {
            echo "<label class='label label-default'>" . $count . " groupe(s)</label><br/><br/>";
        } elseif ($count == 1) {
            echo "<label class='label label-default'>" . $count . " groupe(s)</label><br/><br/>";
        } else {
            echo "<label class='label label-warning'>Aucune groupe n'a été trouvé</label><br/><br/>";
        }
        ?>
        <table class="table table-striped" id="tableau">
            <tr>
                <td>
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" name="checkall" id="checkall" onclick="cocherOuDecocherTout(this)" />
                        <label for="checkall">
                            <b>#id</b>
                        </label>
                </td>
                <td><b>Nom</b></td>
            </tr>
            <?php foreach ($data['groupes'] as $groupe): ?>
                <tr>
                    <td>		
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="groupes[]" id="<?php echo $groupe['id']; ?>" value="<?php echo $groupe['id']; ?>" />
                            <label for="<?php echo $groupe['id']; ?>">
                                <b>#<?php echo $groupe['id']; ?></b>
                            </label>
                    </td>
                    <?php
                    if ($groupe['est_archive'] == 1) {
                        $getArchive = "?est_archive=1";
                    } else {
                        $getArchive = "";
                    }
                    ?>
                    <td><a href='<?php echo $this->echoRedirect("groupes/modifier/" . $groupe['id'] . $getArchive); ?>'><b><?php echo $groupe['nom']; ?></b></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
