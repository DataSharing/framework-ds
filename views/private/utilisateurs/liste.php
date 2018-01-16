<div class="container" style="margin:3em auto;padding:2em">
    <div class="row">
        <!-- ACTIONS -->
        <div class="col-12 col-md-2" style="margin-bottom: 1em;">
            <button type="button"  data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-xs btn-success" ><i class="fa fa-plus" aria-hidden="true"></i> Utilisateurs</button>
        </div>
        
        <!--RECHERCHE -->
        <div class="col-12 col-md-5">
        <form action="" method="get">
            <?php if ($this->rewrite == "off") { ?>
                <input type="hidden" name="p" value="utilisateurs" />
            <?php } ?>
            
                <input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r']; ?>" />
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i></button>
                <a href="<?php echo $this->echoRedirect('utilisateurs'); ?>" class="btn btn-danger">
                    <i class="fa fa-close" aria-hidden="true"></i></a>
            </div>
        </form>
        <!-- ARCHIVEs -->
        <div class="col-12 col-md-3">
            <?php
            if($data['archives'] == 0){
                echo "<a href='".$this->echoRedirect('utilisateurs/archives')."' class='btn btn-primary' style='float:right;' />";
                    echo '<i class="fa fa-archive" aria-hidden="true"></i> Archives';
                echo "</a>";
            }else{
                echo "<a href='".$this->echoRedirect('utilisateurs')."' class='btn btn-primary' style='float:right;' />";
                    echo '<i class="fa fa-archive" aria-hidden="true"></i> Fermer archives';
                echo "</a>";
            }
            ?>
        </div>
        <div class="col-12 col-md-12">
            <form action="" method="post">	
                <div class="">
                    <?php
                    $count = count($data['all']);
                    if ($count > 1) {
                        echo "<label class='badge badge-secondary'>" . $count . " utilisateur(s)</label><br/><br/>";
                    } elseif ($count == 1) {
                        echo "<label class='badge badge-secondary'>" . $count . " utilisateur(s)</label><br/><br/>";
                    } else {
                        echo "<label class='badge badge-warning'>Aucune utilisateur n'a été trouvé</label><br/><br/>";
                    }
                    ?>
                    <table class="table table-striped" id="tableau">
                        <tr>
                            <td>
                                <input type="checkbox" name="checkall" id="checkall" onclick="cocherOuDecocherTout(this)" />
                                <label for="checkall">
                                    <span></span><b>#id</b>
                                </label>
                            </td>
                            <td><b>Etat</b></td>
                            <td><b>Nom d'utilisateur</b></td>
                            <td><b>Groupe</b></td>
                        </tr>
                        <?php foreach ($data['all'] as $utilisateur): ?>
                            <tr class="">
                                <td>
                                    <input type="checkbox" name="utilisateurs[]" id="<?php echo $utilisateur['id']; ?>" value="<?php echo $utilisateur['id']; ?>" />
                                    <label for="<?php echo $utilisateur['id']; ?>">
                                        <span></span><b>#<?php echo $utilisateur['id']; ?></b>
                                    </label>
                                </td>
                                <?php if ($utilisateur['active'] == 1) {
                                    $color = "#5cb85c";
                                    $etat = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                                } else {
                                    $color = "#d9534f";
                                    $etat = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                                } ?>	
                                <td><p style="color:<?php echo $color; ?>"><b><?php echo $etat; ?></b></p></td>
                                <td><a href='<?php echo $this->echoRedirect("utilisateurs/" . $utilisateur['id']); ?>'><b><?php echo $utilisateur['nom'] . " " . $utilisateur['prenom']; ?></b></a></td>
                                <td><p><?php echo $this->nomGroupe($utilisateur['id_groupe']); ?></p></td>
                            </tr>
        <?php endforeach; ?>
                    </table>
                </div>
        </div>
    </div>
        <!-- MODAL AJOUTER UTILISATEUR -->
        <div class="modal fade bs-ajouter-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content col-md-12"><br>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur"  required/><br>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" required/><br>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Adresse email" required/><br>
                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" /><br>
                    <select name="groupes" class="form-control">
        <?php foreach ($data['groupes'] as $groupe): ?>
                            <option value="<?php echo $groupe['id']; ?>" ><?php echo $groupe['nom']; ?></option>
        <?php endforeach; ?>
                    </select><br>
                    <center>
                        <button type="submit" name="submit" id="submit" value="AjouterUtilisateur" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter</button>
                    </center><br>
                </div>
            </div>
        </div>
    </div>
    </form>
