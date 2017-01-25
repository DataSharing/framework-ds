<?php $u = $data['utilisateur'][0];?>
<form action="" method="post">
	<div class="container" style="margin:5em auto;">
		<div class="col-md-12">
			<!-- INFOS Utilisateur -->
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Informations utilisateur</b></div>
					<div class="panel-body">
						<!-- ACTIONS -->
						<button type="submit" name="submit" id="submit" value="enregistrer" class="btn btn-success" ><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Enregistrer</button>
						<button type="submit" name="submit" id="submit" value="enregistrerEtFermer" class="btn btn-success" ><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Enregistrer &amp; fermer</button>
						<button type="submit" name="submit" id="submit" value="fermer" class="btn btn-default" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fermer</button><br><br>
						<!-- END ACTIONS -->
						<input type="text" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur" value="<?php echo $u['nom'];?>" required/><br>
						<input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom de l'utilisateur" value="<?php echo $u['prenom'];?>" required/><br>
						<input type="mail" class="form-control" name="email" id="email" placeholder="Adresse email" value="<?php echo $u['mail'];?>" required /><br>
						<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?php echo $u['telephone'];?>" /><br>
						<h3><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Mot de passe</h3><br>
						<input type="password" class="form-control" name="pwd" id="pwd" placeholder="Saisir le nouveau mot de passe" ><br>
						<input type="password" class="form-control" name="pwd2" id="pwd2" placeholder="Confirmer le nouveau mot de passe" ><br>
						<center><button type="submit" id="submit" name="submit" value="reinitialiser" class="btn btn-warning"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Réinitialiser</button></center>
					</div>
				</div>
			</div>
		
		<!-- END INFOS Utilisateur -->
		<!-- ACCES Utilisateur -->
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Accès utilisateur</b></div>
					<div class="panel-body">
						<select name="etatcompte" class="form-control">
							<option value="0" <?php if($u['active'] == '0') echo "selected";?>>Compte désactivé</option>
							<option value="1" <?php if($u['active'] == '1') echo "selected";?>>Compte activé</option>
						</select><br>
						<select name="droits" class="form-control">
							<option value="visiteur" <?php if($u['acces'] == 'visiteur') echo "selected";?>>Accès visiteur</option>
							<option value="admin" <?php if($u['acces'] == 'admin') echo "selected";?>>Accès administrateur</option>
						</select><br>
						<button type="submit" class="btn btn-success" name="submit" id="submit" value="acces" style="width: 100%"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Appliquer</button>
					</div>
				</div>
			</div>
		<!-- END ACCES Utilisateur -->
		<!-- HISTORIQUE -->	
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Historique de connexion</b></div>
					<div class="panel-body">
						<p><i>les 5 dernières activitées</i></p>
						<?php foreach($data['historique'] as $h):?>
							<p><?php echo $this->form->afficher_date($h['date_modification'],'dateheure');?></p>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		<!-- END HISTORIQUE -->
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Supprimer l'utilisateur</b></div>
					<div class="panel-body">
						<button type="button" data-toggle="modal" data-target=".bs-confirmation-modal-sm" class="btn btn-danger" style="width:100%"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>