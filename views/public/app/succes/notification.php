<?php
echo '<div id="notif-block">';
	if(is_array($data)){
		foreach($data as $notif){
			echo '<br><div id=""notif class="notif" style="border-left:5px solid #5cb85c">';
			 	echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">'.$notif;
		        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
		            echo '<span aria-hidden="true">×</span>';
		        echo '</a></p>';
		    echo "</div>";
		}
	}else{
		echo '<div id=""notif class="notif" style="border-left:5px solid #5cb85c">';
	        echo '<p style="color:#FFF;margin-top: -17px;padding: 0.5em">'.$data;
	        echo '<a class="close notif-close" onclick="NotifClose()" aria-label="Close" data-dismiss="modal" type="button">';
	            echo '<span aria-hidden="true">×</span>';
	        echo '</a></p>';
	    echo "</div>";
    }
    echo '</div>';
echo '</div>';
