<div class="container" style="margin:4em auto">
	<button type="button" onClick="test();" >Test</button>
	<table class="table table-striped">
		<tr>
			<th>Name</th>
		</tr>
		<?php foreach($data['links'] as $link){
			echo "<tr>";
			echo "<td>";
			echo "<a href='".$this->echoRedirect("plugins/example/index&id=1")."'>".$link."</a>";
			echo "</td>";
			echo "</tr>";
		}
		?>
	</table>
</div>