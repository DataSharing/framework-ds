	<div class="container" style="margin:3em auto;padding:2em">
		<!-- ACTIONS -->
		<div class="col-md-12" style="background:#f1f1f1;padding:1em">
			<div class="col-md-10">
				<button type="button"  data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-xs btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Utilisateurs</button>
			</div>
			<div class="col-md-2">
				<div class="btn-group btn-toggle"> 
				    <a href="<?php echo $this->echoRedirect('utilisateurs/archives');?>" class="btn btn-default <?php if($data['archives']==1)echo 'active';?>" alt="Archives"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span></a>
				    <a href="<?php echo $this->echoRedirect('utilisateurs');?>" class="btn btn-default <?php if($data['archives']==0)echo 'active';?>"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></a>
			  	</div>
			</div>
		</div>
		<!--RECHERCHE -->
		<form action="" method="get">
			<?php if($this->rewrite == "off"){?>
            <input type="hidden" name="p" value="utilisateurs" />
            <?php }?>
			<div class="col-md-12" style="background:#ddd;padding:1em;margin-bottom: 2em">
				<div class="col-md-9">
					<input type="text" class="form-control" name="r" id="r" value="<?php echo $data['r'];?>" />
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Rechercher</button>
					<a href="<?php echo $this->echoRedirect('groupes');?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
				</div>
			</div>
		</form>
<form action="" method="post">	
		<div class="">
			<?php
			$count = count($data['all']);
			if($count > 1){
				echo "<label class='label label-default'>".$count. " utilisateur(s)</label><br/><br/>";
			}elseif ($count == 1) {
				echo "<label class='label label-default'>".$count. " utilisateur(s)</label><br/><br/>";
			}else{
				echo "<label class='label label-warning'>Aucune utilisateur n'a été trouvé</label><br/><br/>";
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
					<td><b>Etat</b></td>
					<td><b>Nom d'utilisateur</b></td>
					<td><b>Groupe</b></td>
				</tr>
				<?php foreach($data['all'] as $utilisateur):?>
					<tr class="">
						<td>
                                                    <div class="checkbox checkbox-primary">
                                                    <input type="checkbox" name="utilisateurs[]" id="<?php echo $utilisateur['id'];?>" value="<?php echo $utilisateur['id'];?>" />
                                                    <label for="<?php echo $utilisateur['id'];?>">
                                                        <b>#<?php echo $utilisateur['id'];?></b>
                                                    </label>
						</td>
						<?php if($utilisateur['active'] == 1){$color="#5cb85c";$etat='<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';}else{$color="#d9534f";$etat='<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';}?>	
						<td><p style="color:<?php echo $color;?>"><b><?php echo $etat;?></b></p></td>
						<td><a href='<?php echo $this->echoRedirect("utilisateurs/".$utilisateur['id']);?>'><b><?php echo $utilisateur['nom']." ".$utilisateur['prenom'];?></b></a></td>
						<td><p><?php echo $this->nomGroupe($utilisateur['id_groupe']);?></p></td>
					</tr>
				<?php endforeach;?>
			</table>
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
			<?php foreach($data['groupes'] as $groupe):?>
				<option value="<?php echo $groupe['id'];?>" ><?php echo $groupe['nom'];?></option>
			<?php endforeach;?>
			</select><br>
			<center>
				<button type="submit" name="submit" id="submit" value="AjouterUtilisateur" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter</button>
			</center><br>
	    </div>
	  </div>
	</div>
</form>