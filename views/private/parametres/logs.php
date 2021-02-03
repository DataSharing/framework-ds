<?php
echo '<div class="d-flex justify-content-center mt-2">';
echo $data['pagination'];
echo "</div>";
echo "<table class='table table-sm table-striped p-0 m-0'>";
echo "<tr>";
echo "<th>Id element</th>";
echo "<th>Controller</th>";
echo "<th>Modifié par</th>";
echo "<th>Date modification</th>";
echo "<th>Action</th>";
echo "</tr>";
foreach ($data['logs'] as $log) {
    echo "<tr>";
    echo "<td>";
    if ($log['id_element'] == 0) {
        echo "index";
    } else {
        echo $log['id_element'];
    }
    echo "</td>";
    echo "<td>" . $log['controller'] . "</td>";
    echo "<td>" . $log['modifie_par'] . "</td>";
    echo "<td>" . $log['date_modification'] . "</td>";
    echo "<td>" . $log['action'] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<hr class='mt-0 mb-0'>";
echo '<div class="d-flex justify-content-center mt-2">';
echo $data['pagination'];
echo "</div>";
