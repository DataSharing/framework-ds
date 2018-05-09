<form action="" method="post">
	<div class="container" style="margin:4.5em auto;">
		<div class="row">
			<div class="col-12">
				<table class="table table-striped">
					<tr>
						<th>Nom</th>
						<th>Version</th>
						<th>Auteur</th>
						<th>Actions</th>
					</tr>
					<?php
					$count = 0;
					echo "<tr>";
					foreach($data['plugins'] as $plugin){
						if($plugin == "." || $plugin == ".."){
							continue;
						}
						echo "<td>";
						echo $plugin['name'];
						echo "</td>";
						echo "<td>";
						echo $plugin['version'];
						echo "</td>";
						echo "<td>";
						echo $plugin['auteur'];
						echo "</td>";
						echo "<td>";
						$name_activer = "activer";
						$text_activer = "Activer";
						if($plugin['is_activated']){
							$name_activer = "desactiver";
							$text_activer = "Désactiver";
						} 
						echo "<button type='submit' class='btn btn-sm btn-warning' name='".$name_activer."' value='".$plugin['name']."'>";
						echo "<i class='fa fa-check'></i> ".$text_activer;
						echo "</button>";
						$name_installer = "installer";
						$text_installer = "Installer";
						if($plugin['is_installed']){
							$name_installer = "desinstaller";
							$text_installer = "Désinstaller";
						} 
						echo "<button type='submit' class='btn btn-sm btn-warning' name='".$name_installer."' value='".$plugin['name']."'>";
						echo "<i class='fa fa-upload'></i> ".$text_installer;
						echo "</button>";
						echo "</td>";
						$count++;
					}
					echo "</tr>";
					if($count == 0){
						echo "<tr>";
							echo "<td colspan=4'>";
							echo "<div class='alert alert-warning'>Aucun plugin de disponible</div>";
							echo "</td>";
						echo "</tr>";
					}
					?>
				</table>
			</div>
		</div>
	</div>
</form>