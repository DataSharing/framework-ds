<form action="" method="post">
	<div class="modal fade bs-confirmation-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content col-md-12"><br>
	    	<center>
	      		<p><b>Êtes-vous sûr de vouloir supprimer <?php echo $data['element'];?>?</b></p>
	      	</center><br>
			<center>
				<button type="submit" name="submit" id="submit" value="supprimer" class="btn btn-danger" >Oui</button>
				<button type="submit" name="submit" id="submit" value="" class="btn btn-default" >Non</button>
			</center><br>
	    </div>
	  </div>
	</div>
</form>