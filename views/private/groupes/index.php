<div class="container" style="margin:3em auto;padding:2em">
    <div class="row">
        <!-- ACTIONS -->
        <div class="col-12 col-md-2" style="margin-bottom: 1em;">
            <button type="button"  data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-xs btn-success" ><i class="fa fa-plus" aria-hidden="true"></i> Groupe</button>
        </div>
        <!--RECHERCHE -->
        <div class="col-12 col-md-5">
        <form action="" method="get">
            <?php if ($this->rewrite == "off") { ?>
                <input type="hidden" name="p" value="groupes" />
            <?php } ?>
                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
                <a href="<?php echo $this->echoRedirect('groupes'); ?>" class="btn btn-danger">
                   <i class="fa fa-close" aria-hidden="true"></i></a>
            </div>
        </form>
        <!-- ARCHIVEs -->
        <div class="col-12 col-md-3">
            <?php
            if($data['archives'] == 0){
                echo "<a href='".$this->echoRedirect('groupes/archives')."' class='btn btn-primary' style='float:right;' />";
                    echo '<i class="fa fa-archive" aria-hidden="true"></i> Archives';
                echo "</a>";
            }else{
                echo "<a href='".$this->echoRedirect('groupes')."' class='btn btn-primary' style='float:right;' />";
                    echo '<i class="fa fa-archive" aria-hidden="true"></i> Fermer archives';
                echo "</a>";
            }
            ?>
        </div>
        
        <!-- form for massives actions -->
        <form></form>
        <div class="col-12 col-md-12" >
            <?php
            $count = count($data['groupes']);
            if ($count > 1) {
                echo "<label class='badge badge-secondary'>" . $count . " groupe(s)</label><br/><br/>";
            } elseif ($count == 1) {
                echo "<label class='badge badge-secondary'>" . $count . " groupe(s)</label><br/><br/>";
            } else {
                echo "<label class='badge badge-warning'>Aucune groupe n'a été trouvé</label><br/><br/>";
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
</div>
