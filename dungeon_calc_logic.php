<?php
include "user.php";
$dungeon_results = array();
if ($_POST) {
  $user = new User('',
                   '',
                   $_POST['total_idols'],
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   0,
                   $_POST['t2_11ths_completed'],
                   $_POST['max_area_reached'],
                   $_POST['time_to_complete_fp'],
                   $_POST['time_to_complete_sprint'],
                   $_POST['areas_sprintable'],
                   $_POST['fp_areas_per_hour'],
                   $_POST['idol_buff']);
  for($i = 500; $i < 10500; $i += 500) {
    $dungeon_results[$i] = $user->get_dungeon_data($i);
  }
}
