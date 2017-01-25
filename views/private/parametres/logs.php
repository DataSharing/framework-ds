<?php
echo "<table class='table striped'>";
    
    foreach($data['logs'] as $log){
        echo "<tr>";
            echo "<td>#".$log['id']."</td>";
            echo "<td>".$log['id_element']."</td>";
            echo "<td>".$log['controller']."</td>";
            echo "<td>".$log['modifie_par']."</td>";
            echo "<td>".$log['date_modification']."</td>";
            echo "<td>".$log['action']."</td>";
        echo "</tr>";
    }
    
echo "</table>";
    
