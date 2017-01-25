<form action="" method="post">	
	<div class="container" style="margin:5em auto;">
		<div class="col-md-12">
			<button type="button"  data-toggle="modal" data-target=".bs-ajouter-modal-sm" class="btn btn-primary" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter un utilisateur</button><br><br>
		</div>
		<div class="col-md-12">
			<table class="table table-striped" id="tableau">
				<tr>
					<td><input type="checkbox" name="checkall" id="checkall" /></td>
					<td><b>Etat</b></td>
					<td><b>Nom d'utilisateur</b></td>
					<td><b>Accès</b></td>
				</tr>
				<?php foreach($data['all'] as $utilisateur):?>
					<tr class="zoneClick">
						<td><input type="checkbox" name="utilisateurs[]" value="<?php echo $utilisateur['id'];?>" /></td>
						<?php if($utilisateur['active'] == 1){$color="#5cb85c";$etat='<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';}else{$color="#d9534f";$etat='<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';}?>	
						<td><p style="color:<?php echo $color;?>"><b><?php echo $etat;?></b></p></td>
						<td><a href='<?php echo $this->base_url."utilisateurs/".$utilisateur['id'];?>'><b><?php echo $utilisateur['nom']." ".$utilisateur['prenom'];?></b></a></td>
						<td><p><?php echo $utilisateur['acces'];?></p></td>
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
			<select name="droits" class="form-control">
				<option value="visiteur" >Accès visiteur</option>
				<option value="admin">Accès administrateur</option>
			</select><br>
			<center>
				<button type="submit" name="submit" id="submit" value="AjouterUtilisateur" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter</button>
			</center><br>
	    </div>
	  </div>
	</div>
</form>