<?php
  include "navigation.php";
  $game_defines = new GameDefines();
  echo '</table><br><table><tr><th>Crusader Name</th><th colspan="15">Crusader 5th Rune Scaling</th></tr>';
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
        $i = 0;
        foreach ($crusader->hero_gem_slots[5]->effects[0]->level_amounts AS $level => $amount) {
          $style = '';
          if ($i%5 == 0) {
            $style = 'style="background: lightblue;"';
          }
          $rune_levels .= '<td ' . $style . '>' . sprintf('%.3E', $amount) . '</td>';
          $i++;
        }
      } else {
        $i = 0;
        foreach ($game_defines->hero_gem_scaling[$crusader->hero_gem_slots[5]->effects[0]->level_amounts] AS $amount) {
          $style = '';
          if ($i%5 == 0) {
            $style = 'style="background: lightblue;"';
          }
          $rune_levels .= '<td ' . $style . '>' . sprintf('%.3E', $amount) . '</td>';
          $i++;
        }
      }
    }
    echo $rune_levels . '</tr>';
    $row_number++;
  }
  echo '</table>';
?>
