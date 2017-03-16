<?php
if(isset($_SERVER['HTTP_REFERER'])){
	$referer = $_SERVER['HTTP_REFERER'];
}else{
	$referer = $this->echoRedirect();
}
echo "<center>";
echo "<div class='alert alert-danger' style='margin:5em auto;'>".$data;
echo "<br/><a href='".$referer."'><b>cliquez ici</b></a> pour revenir sur la page précédente";
echo "</div>";
echo "</center>";
