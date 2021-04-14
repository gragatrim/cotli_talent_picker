<?php
  include "navigation.php";
  $game_defines = new GameDefines();
  echo '<table style="margin-left: auto; margin-right: auto"><tr><th colspan="16">Crusader 5th Rune Scaling(all numbers are percentages)</th></tr><tr><th>Crusader Name</th>
  <th> Lvl 1</th>
  <th> Lvl 2</th>
  <th> Lvl 3</th>
  <th> Lvl 4</th>
  <th> Lvl 5</th>
  <th> Lvl 6</th>
  <th> Lvl 7</th>
  <th> Lvl 6</th>
  <th> Lvl 9</th>
  <th> Lvl 10</th>
  <th> Lvl 11</th>
  <th> Lvl 12</th>
  <th> Lvl 13</th>
  <th> Lvl 14</th>
  <th> Lvl 15</th>
  </tr>';
  $row_number = 0;
  foreach($game_defines->crusaders AS $crusader) {
    if (empty($crusader->hero_gem_slots) || empty($crusader->name)) {
      continue;
    }
    if (isset($crusader->hero_gem_slots[5]->properties->coming_soon) && $crusader->hero_gem_slots[5]->properties->coming_soon == true) {
      continue;
    }
    if ($row_number%2 == 0) {
      $row_style = '';
    } else {
      $row_style = 'style="background: #7d7;"';
    }
    echo '<tr ' . $row_style . '><td><b>' . $crusader->name . '</b></td>';
    $rune_levels = '';
    if ($crusader->hero_gem_slots[5]->slot_id == 5) {
      if (is_array($crusader->hero_gem_slots[5]->effects[0]->level_amounts)) {
        $i = 1;
        foreach ($crusader->hero_gem_slots[5]->effects[0]->level_amounts AS $level => $amount) {
          $style = '';
          if ($i%5 == 0) {
            $style = 'style="background: lightblue;"';
          }
          $rune_levels .= '<td ' . $style . '>' . sprintf('%.2E', $amount) . '</td>';
          $i++;
        }
      } else {
        $i = 1;
        foreach ($game_defines->hero_gem_scaling[$crusader->hero_gem_slots[5]->effects[0]->level_amounts] AS $amount) {
          $style = '';
          if ($i%5 == 0) {
            $style = 'style="background: lightblue;"';
          }
          $rune_levels .= '<td ' . $style . '>' . sprintf('%.2E', $amount) . '</td>';
          $i++;
        }
      }
    }
    echo $rune_levels . '</tr>';
    $row_number++;
  }
  echo '</table>';
?>
