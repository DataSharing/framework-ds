<?php
echo '<div id="notif-block">';
	if(is_array($data)){
		$i = 0;
		foreach($data as $notif){
			echo '<br><div id=""notif class="notif'.$i.'" style="border-left:5px solid #5cb85c">';
			 	echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">'.$notif;
		        echo '<a class="close notif-close" onclick="NotifClose('.$i.')" aria-label="Close" data-dismiss="modal" type="button">';
		            echo '<span aria-hidden="true">×</span>';
		        echo '</a></p>';
		    echo "</div>";
		    $i++;
		}
	}else{
		$i = 0;
		echo '<div id=""notif class="notif'.$i.'" style="border-left:5px solid #5cb85c">';
	        echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">'.$data;
	        echo '<a class="close notif-close" onclick="NotifClose('.$i.')" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo "</div>";
    }
    echo '</div>';
echo '</div>';
