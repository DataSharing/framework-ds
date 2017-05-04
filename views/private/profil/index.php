<?php $u = $data['utilisateur'][0];?>
<form action="" method="post">
	<div class="container" style="margin:3em auto;background: white; padding: 2em">
		<div class="col-md-14">
			<!-- INFOS Utilisateur -->
			<div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading"><b><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Informations utilisateur</b></div>
					<div class="panel-body">
						<!-- ACTIONS -->
						<button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success" ><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Enregistrer</button>
						<button type="submit" name="submit" id="submit" value="enregistrerEtFermer" class="btn btn-success" ><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Enregistrer &amp; fermer</button>
						<button type="submit" name="submit" id="submit" value="fermer" class="btn btn-default" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fermer</button><br/><br/>
						<!-- END ACTIONS -->
						<input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom'];?>" required/>
						<input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom'];?>" required/>
						<input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail'];?>" required />
						<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone'];?>" />
					</div>
				</div>
			</div>
			<!-- END INFOS Utilisateur -->
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Mot de passe</b>
					</div>
					<div class="panel-body">
						<input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe" >
						<input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe" >
						<center><button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Réinitialiser</button></center>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b><span class="fa fa-users" aria-hidden="true"></span> Groupe</b>
					</div>
					<div class="panel-body">
						<?php echo $data['nom_groupe'];?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>