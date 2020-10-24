<?php
  include "navigation.php";
  $game_defines = new GameDefines();
  echo '<br>';
  echo '<table>
          <tr><th colspan="2">Rune Names</th></tr>
          <tr><th>Id</th><th>Name</th></tr>';
  foreach ($game_defines->gems AS $gem) {
    echo '<tr><td>' . $gem->id . '</td><td>' . $gem->name . '</td></tr>';
  }
  echo '</table>';
  echo '<br>';
  echo '<table>
          <tr><th colspan="2">Rune Effects</th></tr>
          <tr><th>Key</th><th>Effect</th></tr>';
  foreach ($game_defines->hero_gem_effects AS $gem_effects) {
    echo '<tr><td class="' . $gem_effects->key . '">' . $gem_effects->key . '</td><td>' . $gem_effects->effect->effect_string . '</td></tr>';
  }
  echo '</table>';
  echo '<br>';
  echo '<table><tr><th colspan="9">Crusader Rune Effects</th></tr><tr>';
  $i = 0;
  foreach($game_defines->crusaders AS $crusader) {
    if ($i >= 9) {
      echo '</tr><tr>';
      $i = 0;
    }
    echo '<td><b>' . $crusader->name . '</b><br>';
    foreach ($crusader->hero_gem_slots AS $gem_slot) {
      if (isset($gem_slot->effects[0])) {
        $rune_type = strtok($game_defines->gems[$gem_slot->gem_id]->name, " ");
        echo '<div><div style="float: left;clear: left;padding-left: 10px;" >' . $rune_type . '</div><div style="float: right;clear: right; padding-right: 10px;" class="' . $gem_slot->effects[0] . '">' . $gem_slot->effects[0] . '</div></div>';
      }
    }
    $i++;
    echo '</td>';
  }
  echo '</tr></table>';
?>
