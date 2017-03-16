<?php
include_once '../core/Model.php';
$model = New Model();
$model->table = "droits";

if(isset($_POST['controller']) && isset($_POST['id_groupe'])){
	$lecture = array('id_groupe'=>$_POST['id_groupe'],'droit'=>7,'controller'=>$_POST['controller']);
	if($model->count($lecture,'AND') == 0){
		if($model->insertion($lecture)){
			echo '<br/><div id=""notif class="notif" style="border-left:5px solid #5cb85c">';
			 	echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Les droits en lecture ont bien été ajouté';
		        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
		            echo '<span aria-hidden="true">×</span>';
		        echo '</a></p>';
		    echo "</div>";
		}
	}else{
	    echo '<br/><div id=""notif class="notif" style="border-left:5px solid #d9534f">';
	        echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Le controlleur existe déjà!';
	        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo '</div>';
	}
	$droits = array();
	$model->table = "droits_groupes";
	$droits = $model->lecture(array('*'),array('id_groupe'=>$_POST['id_groupe']));

	echo '<table class="table table-striped">';
		echo '<tr>';
			echo '<th>Controller</th>';
			echo '<th>Lecture</th>';
			echo '<th>Modification</th>';
			echo '<th>Suppression/Archivage</th>';
		echo '</tr>';
		foreach($droits as $droit):
			$selectType = strpos($droit['controller'],'type_');
			if($selectType !== FALSE){
				continue;
			}
			$lecture = 0;
			$modification = 0;
			$suppression = 0;
			echo "<tr>";
				echo "<td>".$droit['controller']."</td>";		
				echo "<input type='hidden' name='controllers[]' value='".$droit['controller']."'  />";		
				$droits = explode('+',$droit['droit']);
				$nbDroits = count($droits);

				//LECTURE
				for($i=0;$i<$nbDroits;$i++):
					if($droits[$i] == 7){
						echo "<td>";
							echo "<div class='checkbox checkbox-primary'>";
								echo "<input type='checkbox' name='lecture_".$droit['controller']."' id='lecture_".$droit['controller']."' checked/>";
								echo "<label></label>";
							echo "</div>";
						echo "</td>";
						$lecture = 1;
					}
				endfor;
				if($lecture == 0){
					echo "<td>";
						echo "<div class='checkbox checkbox-primary'>";
							echo "<input type='checkbox' name='lecture_".$droit['controller']."' id='lecture_".$droit['controller']."' />";
							echo "<label></label>";
						echo "</div>";
					echo "</td>";
				}

				//MODIFICATION
				for($i=0;$i<$nbDroits;$i++):
					if($droits[$i] == 77){
						echo "<td>";
							echo "<div class='checkbox checkbox-primary'>";
								echo "<input type='checkbox' name='modification_".$droit['controller']."' id='modification_".$droit['controller']."' checked/>";
								echo "<label></label>";
							echo "</div>";
						echo "</td>";
						$modification = 1;
					}
				endfor;
				if($modification == 0){
					echo "<td>";
						echo "<div class='checkbox checkbox-primary'>";
							echo "<input type='checkbox' name='modification_".$droit['controller']."' id='modification_".$droit['controller']."' />";
							echo "<label></label>";
						echo "</div>";
					echo "</td>";
				}

				//SUPPRESSION
				for($i=0;$i<$nbDroits;$i++):
					if($droits[$i] == 777){
						echo "<td>";
							echo "<div class='checkbox checkbox-primary'>";
								echo "<input type='checkbox' name='suppression_".$droit['controller']."' id='suppression_".$droit['controller']."' checked/>";
								echo "<label></label>";
							echo "</div>";
						echo "</td>";
						$suppression = 1;
					}
				endfor;
				if($suppression == 0){
					echo "<td>";
						echo "<div class='checkbox checkbox-primary'>";
							echo "<input type='checkbox' name='suppression_".$droit['controller']."' id='suppression_".$droit['controller']."' />";
							echo "<label></label>";
						echo "</div>";
					echo "</td>";
				}
			echo "</tr>";
		endforeach;
		echo "</tr>";
	echo "</table>";
} 
//Supprimer le type
if(isset($_POST['nom_type']) && isset($_POST['id_groupe'])){

	if($model->delete(array('controller'=>$_POST['nom_type']))){
		echo '<br/><div id=""notif class="notif" style="border-left:5px solid #5cb85c">';
		 	echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Les droits ont bien été supprimé';
	        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo "</div>";
	}else{
		echo '<br/><div id=""notif class="notif" style="border-left:5px solid #d9534f">';
	        echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Erreur lors de la suppression des droits!';
	        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo '</div>';
	}
	$droits = array();
	$model->table = "droits_groupes";
	$droits = $model->lecture(array('*'),array('id_groupe'=>$_POST['id_groupe']));
	foreach($droits as $droit):
		$selectType = strpos($droit['controller'],'type_');
		if($selectType === FALSE){
			continue;
		}
		echo "<tr>";
		echo "<td><label class='label-type'>".$droit['controller']."</label></td>";
		echo '<td><button type="submit" name="submit" value="supprimer-type_'.$droit['controller'].'" class="btn btn-xs btn-danger" style="padding: 0.3em;width:100%"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
		echo "</tr>";
	endforeach;
}

if(isset($_POST['type']) && isset($_POST['id_groupe'])){
	$lecture = array('id_groupe'=>$_POST['id_groupe'],'droit'=>7,'controller'=>$_POST['type']);
	if($model->count($lecture,'AND') == 0){
		if($model->insertion($lecture)){
			echo '<br/><div id=""notif class="notif" style="border-left:5px solid #5cb85c">';
			 	echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Les drois ont bien été ajouté';
		        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
		            echo '<span aria-hidden="true">×</span>';
		        echo '</a></p>';
		    echo "</div>";
		}
	}else{
	    echo '<br/><div id=""notif class="notif" style="border-left:5px solid #d9534f">';
	        echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">Le type existe déjà!';
	        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo '</div>';
	}
	$droits = array();
	$model->table = "droits_groupes";
	$droits = $model->lecture(array('*'),array('id_groupe'=>$_POST['id_groupe']));
	foreach($droits as $droit):
		$selectType = strpos($droit['controller'],'type_');
		if($selectType === FALSE){
			continue;
		}
		echo "<tr>";
		echo "<td><label class='label-type'>".$droit['controller']."</label></td>";
		echo '<td><button type="submit" name="submit" value="supprimer-type_'.$droit['controller'].'" class="btn btn-xs btn-danger" style="padding: 0.3em;width:100%"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
		echo "</tr>";
	endforeach;
}
?>
