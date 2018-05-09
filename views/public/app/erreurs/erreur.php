<?php
echo '<div id="notif-block">';
$i = 0;
echo '<div id="notif" class="notif notif' . $i . '" style="background:#d9534f">';
echo '<p style="color:#FFF;margin:0;padding: 1em">' . $data;
echo '<a class="close notif-close" onclick="NotifClose(' . $i . ')" aria-label="Close" data-dismiss="modal" type="button">';
echo '<span aria-hidden="true">×</span>';
echo '</a></p>';
echo '</div>';
echo '</div>';
