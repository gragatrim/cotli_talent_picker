<?php
include "user.php";
$dungeon_results = array();
if ($_POST) {
  $user = new User($_POST,
                   0,
                   htmlspecialchars($_POST['t2_11ths_completed']),
                   htmlspecialchars($_POST['max_area_reached']),
                   htmlspecialchars($_POST['time_to_complete_fp']),
                   htmlspecialchars($_POST['time_to_complete_sprint']),
                   htmlspecialchars($_POST['areas_sprintable']),
                   htmlspecialchars($_POST['dungeon_areas_per_hour']),
                   htmlspecialchars($_POST['idol_buff']));
  for($i = 500; $i < 14500; $i += 500) {
    $dungeon_results[$i] = $user->get_dungeon_data($i);
  }
}
