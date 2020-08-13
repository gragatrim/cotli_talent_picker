<?php
include "navigation.php";
include "dungeon_calc_logic.php";
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Total Idols: <input type="text" name="total_idols" value="<?php echo (isset($user->total_idols) ? $user->total_idols : 0); ?>"><br>
T2 11ths Completed: <input type="text" name="t2_11ths_completed" value="<?php echo (isset($user->t2_11ths_completed) ? $user->t2_11ths_completed : 0); ?>"><br>
Max area completed in FP: <input type="text" name="max_area_reached" value="<?php echo (isset($user->max_area_reached) ? $user->max_area_reached : 0); ?>"><br>
Time to complete FP(in minutes): <input type="text" name="time_to_complete_fp" value="<?php echo (isset($user->time_to_complete_fp) ? $user->time_to_complete_fp : 0); ?>"><br>
Time to complete sprint(in minutes): <input type="text" name="time_to_complete_sprint" value="<?php echo (isset($user->time_to_complete_sprint) ? $user->time_to_complete_sprint : 0); ?>"><br>
Areas sprintable: <input type="text" name="areas_sprintable" value="<?php echo (isset($user->areas_sprintable) ? $user->areas_sprintable : 0); ?>"><br>
FP areas per hour: <input type="text" name="fp_areas_per_hour" value="<?php echo (isset($user->fp_areas_per_hour) ? $user->fp_areas_per_hour : 0); ?>"><br>
Idol Buff(if you have none use 1): <input type="text" name="idol_buff" value="<?php echo (isset($user->idol_buff) ? $user->idol_buff : 1); ?>"><br>
<input type="submit">
</form>
<div>The rows highlighted in green mean running to that area will provide more idols than running a free play(over the same amount of time).</div>
<div>The rows highlighted in red mean running a FP becomes a better use of time.</div>
<table>
  <tr>
    <th>Area reached</th>
    <th>Rough DPS needed</th>
    <th>Total Time to ledge(in minutes)</th>
    <th>Idols Gained</th>
    <th>Idols per Hour</th>
    <th>Idols per FP time</th>
    <th>Idols gained over FP</th>
  <?php
  for ($i = 500; $i <= 10000; $i += 500) {
    if (empty($dungeon_results[$i])) {
    echo '<tr class="red">
            <td>' .  $i . '</td>
            <td>' .  $i / 5.16 . '</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
          </tr>';
    } else {
      echo '<tr class="' . ($dungeon_results[$i]['idol_over_fp'] > 0 ? 'green' : 'red') . '">
              <td>' .  $i . '</td>
              <td>' .  $i / 5.16 . '</td>
              <td>' .  $dungeon_results[$i]['total_time'] . '</td>
              <td>' .  sprintf("%.2E", $dungeon_results[$i]['idols_gained']) . '</td>
              <td>' .  sprintf("%.2E", $dungeon_results[$i]['idols_per_hour']) . '</td>
              <td>' .  sprintf("%.2E", $dungeon_results[$i]['idols_per_fp_time']) . '</td>
              <td>' .  sprintf("%.2E", $dungeon_results[$i]['idol_over_fp']) . '</td>
            </tr>';
    }
  }?>
</table>

