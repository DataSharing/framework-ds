<form action="" method="post">
	<div class="modal fade bs-confirmation-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content col-md-12"><br>
	    	<center>
	      		<p><b>Êtes-vous sûr de vouloir supprimer le groupe?</b></p>
	      	</center><br>
			<center>
				<button type="submit" name="submit" id="submit" value="supprimer" class="btn btn-danger" >Oui</button>
				<button type="submit" name="submit" id="submit" value="" class="btn btn-default" >Non</button>
			</center><br>
	    </div>
	  </div>
	</div>
</form>
<!-- MODAL AJOUTER UTILISATEUR -->
<form action="" method="post">	
	<div class="modal fade bs-ajouter-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content col-md-12"><br>
	      	<input type="text" class="form-control" name="nom" id="nom" placeholder="Nom du groupe"  required/><br>
			<center>
				<button type="submit" name="submit" id="submit" value="ajouter" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter</button>
			</center><br>
	    </div>
	  </div>
	</div>
</form>	