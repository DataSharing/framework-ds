<form action="" method="post">
	<div class="modal fade bs-confirmation-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content col-md-12"><br>
				<center>
					<p><b>Êtes-vous sûr de vouloir supprimer le groupe?</b></p>
				</center><br>
				<center>
					<button type="submit" name="submit" id="submit" value="supprimer" class="btn btn-danger">Oui</button>
					<button type="submit" name="submit" id="submit" value="" class="btn btn-default">Non</button>
				</center><br>
			</div>
		</div>
	</div>
</form>
<!-- MODAL AJOUTER UTILISATEUR -->
<form action="" method="post">
	<div class="modal fade bs-ajouter-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ajouter un groupe</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<small class="text-muted">Nom du groupe</small>
					<input type="text" class="form-control" name="nom" id="nom" placeholder="Nom du groupe" required />
					<small class="text-muted">Interface</small>
					<select name="interfaces" id="interfaces" class="form-control" required>
						<option value="administrateur">Administrateur</option>
						<option value="moderateur">Modérateur</option>
					</select>
					<small class="text-muted">Groupe référence</small>
					<select name="groupes_reference" id="groupe_reference" class="form-control" required>
						<option value="1">Administrateur</option>
						<option value="2">Modérateur</option>
					</select>
					<small class="text-muted">Description</small>
					<textarea name="description" class="form-control"></textarea>
				</div>
				<div class="card-footer">
					<button type="submit" name="submit" id="submit" value="ajouter" class="btn btn-success float-end">
						<i class="fas fa-plus" aria-hidden="true"></i> Ajouter
					</button>
				</div>
			</div>
		</div>
	</div>
</form>