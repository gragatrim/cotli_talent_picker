<?php
  include "navigation.php";
  $game_defines = new GameDefines();
  $rune_text = '';
  if(!empty($_POST)) {
    if ($_POST['desired_rune_level'] >= 2 && $_POST['desired_rune_level'] <= 15) {
      $user_runes = array();
      $user_rune_sum = 0;
      for ($i = 1; $i < 16; $i++) {
        if (is_numeric($_POST['level_' . $i . '_rune'])) {
          $user_rune_sum += pow(2, $i - 1) * $_POST['level_' . $i . '_rune'];
        }
      }
      $rune_text = "<div>You need " . (pow(2,$_POST['desired_rune_level'] - 1) - $user_rune_sum) . " level 1 runes to make a level " . $_POST['desired_rune_level'] . " rune.</div>";
    }
  }
  if (isset($_POST['desired_rune_level'])) {
    $desired_rune_level = $_POST['desired_rune_level'];
  } else {
    $desired_rune_level = '';
  }
  for ($i = 1; $i < 16; $i++) {
    if (isset($_POST['level_' . $i . '_rune'])) {
      ${'level_' . $i . '_rune'} = $_POST['level_' . $i . '_rune'];
    } else {
      ${'level_' . $i . '_rune'} = '';
    }
  }
?>
<form method="POST">
<table>
  <tr>
    <td>Desired Rune level:</td><td><input type="text" name="desired_rune_level" id="desired_rune_level" value="<?php echo $desired_rune_level; ?>"/></td><td>Level 8 runes:</td><td><input type="text" name="level_8_rune" id="level_8_rune" value="<?php echo $level_8_rune;?>" /></td>
  </tr> <tr>
    <td>Level 1 runes:</td><td><input type="text" name="level_1_rune" id="level_1_rune" value="<?php echo $level_1_rune;?>"/></td><td>Level 9 runes:</td><td><input type="text" name="level_9_rune" id="level_9_rune" value="<?php echo $level_9_rune;?>" /></td>
  </tr> <tr>
    <td>Level 2 runes:</td><td><input type="text" name="level_2_rune" id="level_2_rune" value="<?php echo $level_2_rune;?>"/></td><td>Level 10 runes:</td><td><input type="text" name="level_10_rune" id="level_10_rune" value="<?php echo $level_10_rune;?>" /></td>
  </tr> <tr>
    <td>Level 3 runes:</td><td><input type="text" name="level_3_rune" id="level_3_rune" value="<?php echo $level_3_rune;?>"/></td><td>Level 11 runes:</td><td><input type="text" name="level_11_rune" id="level_11_rune" value="<?php echo $level_11_rune;?>" /></td>
  </tr> <tr>
    <td>Level 4 runes:</td><td><input type="text" name="level_4_rune" id="level_4_rune" value="<?php echo $level_4_rune;?>"/></td><td>Level 12 runes:</td><td><input type="text" name="level_12_rune" id="level_12_rune" value="<?php echo $level_12_rune;?>" /></td>
  </tr> <tr>
    <td>Level 5 runes:</td><td><input type="text" name="level_5_rune" id="level_5_rune" value="<?php echo $level_5_rune;?>"/></td><td>Level 13 runes:</td><td><input type="text" name="level_13_rune" id="level_13_rune" value="<?php echo $level_13_rune;?>" /></td>
  </tr> <tr>
    <td>Level 6 runes:</td><td><input type="text" name="level_6_rune" id="level_6_rune" value="<?php echo $level_6_rune;?>"/></td><td>Level 14 runes:</td><td><input type="text" name="level_14_rune" id="level_14_rune" value="<?php echo $level_14_rune;?>" /></td>
  </tr> <tr>
    <td>Level 7 runes:</td><td><input type="text" name="level_7_rune" id="level_7_rune" value="<?php echo $level_7_rune;?>"/></td><td>Level 15 runes:</td><td><input type="text" name="level_15_rune" id="level_15_rune" value="<?php echo $level_15_rune;?>" /></td>
  </tr>
</table>
<input type="submit"/>
</form>
<?php
  if (!empty($rune_text)) {
    echo $rune_text;
  }
  echo '<br><table>
          <tr><th colspan="2">Rune Names</th></tr>
          <tr><th>Id</th><th>Name</th></tr>';
  foreach ($game_defines->gems AS $gem) {
    echo '<tr><td>' . $gem->id . '</td><td>' . $gem->name . '</td></tr>';
  }
  echo '</table><br><table>
          <tr><th colspan="2">Rune Effects</th></tr>
          <tr><th>Key</th><th>Effect</th></tr>';
  foreach ($game_defines->hero_gem_effects AS $gem_effects) {
    echo '<tr><td class="' . $gem_effects->key . '">' . $gem_effects->key . '</td><td>' . $gem_effects->effect->effect_string . '</td></tr>';
  }
  echo '</table><br><table><tr><th colspan="9">Crusader Rune Effects</th></tr><tr>';
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
