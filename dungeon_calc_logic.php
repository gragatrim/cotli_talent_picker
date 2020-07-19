<?php
include "user.php";
if ($_POST) {
  $user = new User($_POST['total_idols'],
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
                   $_POST['fp_idol_average'],
                   $_POST['time_to_complete_fp'],
                   $_POST['time_to_complete_sprint'],
                   $_POST['areas_sprintable'],
                   $_POST['fp_areas_per_hour']);
  for($i = 500; $i <= 10500; $i += 500) {
    $dungeon_results[$i] = $user->get_dungeon_data($i);
  }
}
