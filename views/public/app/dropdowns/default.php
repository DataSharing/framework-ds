<div class="input-group" style="margin-bottom: 1em">
	<span id="basic-addon1" class="input-group-addon mobile-hidden">
		<b><?php echo $data['titre'];?></b>
	</span>
	<select name="<?php echo $data['name'];?>" class="form-control">
		<?php
		echo "<option value='0'>- ".$data['titre']." -</option>";
		foreach($data['select'] as $select){
			if($select['id'] = $data['id_selected']){
				$selected = "selected";
			}else{ $selected = "";}
			echo "<option value='".$select['id']."' ".$selected.">".$select['nom']."</option>";
		}
		?>
	</select>
</div>