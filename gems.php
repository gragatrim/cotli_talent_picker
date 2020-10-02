<?php
  include "navigation.php";
  $game_defines = new GameDefines(true, true);
  echo '<br>';
  echo '<table>
          <tr><th colspan="2">Gem Names</th></tr>
          <tr><th>Id</th><th>Name</th></tr>';
  foreach ($game_defines->gems AS $gem) {
    echo '<tr><td>' . $gem->id . '</td><td>' . $gem->name . '</td></tr>';
  }
  echo '</table>';
  echo '<br>';
  echo '<table>
          <tr><th colspan="2">Gem Effects</th></tr>
          <tr><th>Key</th><th>Effect</th></tr>';
  foreach ($game_defines->hero_gem_effects AS $gem_effects) {
    echo '<tr><td>' . $gem_effects->key . '</td><td>' . $gem_effects->effect->effect_string . '</td></tr>';
  }
  echo '</table>';
  echo '<br>';
  echo '<table><tr><th colspan="9">Crusader Gem Effects</th></tr><tr>';
  $i = 0;
  foreach($game_defines->crusaders AS $crusader) {
    if ($i >= 9) {
      echo '</tr><tr>';
      $i = 0;
    }
    echo '<td><b>' . $crusader->name . '</b><br>';
    foreach ($crusader->hero_gem_slots AS $gem_slot) {
      if (isset($gem_slot->effects[0])) {
        echo 'slot:' . $gem_slot->slot_id . ' effect: ' . $gem_slot->effects[0] . '<br>';
      }
    }
    $i++;
    echo '</td>';
  }
  echo '</tr></table>';
?>
