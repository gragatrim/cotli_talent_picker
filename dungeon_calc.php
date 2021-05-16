<?php
include "navigation.php";
include "dungeon_calc_logic.php";
?>
<div>This is updated to work for Season 3 of the dungeons, aka The Waterways. Also correctly handles the new BI scaling above area 5895.</div>
<div style="color: red;">If you know your actual times, update the default values, the default values assume active/optimal play(and assuming e1100 cap)</div>
<div style="color: red;font-size: 24px;">If your cap is above e1100 YOU WILL NEED TO UPDATE THE DEFAULT TIME VALUES!!!!</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Total Idols: <input type="text" name="total_idols" value="<?php echo (isset($user->total_idols) ? sprintf('%.2e', $user->total_idols) : 0); ?>">(accepts idols using 8.37e15 notation)<br>
T2 11ths Completed: <input type="text" name="t2_11ths_completed" value="<?php echo (isset($user->t2_11ths_completed) ? $user->t2_11ths_completed : 9); ?>"><br>
Max area completed in FP: <input type="text" name="max_area_reached" value="<?php echo (isset($user->max_area_reached) ? $user->max_area_reached : 5761); ?>"><br>
Time to complete FP(in minutes): <input type="text" name="time_to_complete_fp" value="<?php echo (isset($user->time_to_complete_fp) ? $user->time_to_complete_fp : 220); ?>">(Take an average of the time it takes to complete enough FPs + sprints to get back to 100% BI Bonus)<br>
Time to complete sprint(in minutes): <input type="text" name="time_to_complete_sprint" value="<?php echo (isset($user->time_to_complete_sprint) ? $user->time_to_complete_sprint : 37); ?>"><br>
Areas sprintable: <input type="text" name="areas_sprintable" value="<?php echo (isset($user->areas_sprintable) ? $user->areas_sprintable : 3500); ?>"><br>
Dungeon areas per hour: <input type="text" name="dungeon_areas_per_hour" value="<?php echo (isset($user->dungeon_areas_per_hour) ? $user->dungeon_areas_per_hour : 1100); ?>"><br>
Dungeon only Idol Buff(Check your bonuses one is dungeon only for the entire season): <input type="text" name="idol_buff" value="<?php echo (isset($user->idol_buff) ? $user->idol_buff : 1.05); ?>"><br>
<input type="submit">
</form>
<div>The rows highlighted in <span class="colorblindblue">blue</span> mean running to that area will provide more idols than running a free play(over the same amount of time).</div>
<div>The rows highlighted in <span class="colorblindred">red</span> mean running a FP becomes a better use of time.</div>
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
  for ($i = 500; $i <= 15000; $i += 500) {
    if (empty($dungeon_results[$i])) {
    echo '<tr class="colorblindred">
            <td>' .  $i . '</td>
            <td>' .  $i / 5.16 . '</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
          </tr>';
    } else {
      echo '<tr class="' . ($dungeon_results[$i]['idol_over_fp'] > 0 ? 'colorblindblue' : 'colorblindred') . '">
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

