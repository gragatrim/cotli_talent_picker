<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data'])) {
  $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
  $user_crusaders = '<table style="float: left; clear:both;"><tr>';
  $rune_level = array();
  for ($i = 1; $i < 21; $i++) {
    if (isset($_POST['level_' . $i])) {
      $rune_level[] = $i;
    }
  }
  //janky but w/e
  if (isset($_POST['fire'])) {
    $rune_types[$_POST['fire']] = $_POST['fire'];
  }
  if (isset($_POST['water'])) {
    $rune_types[$_POST['water']] = $_POST['water'];
  }
  if (isset($_POST['air'])) {
    $rune_types[$_POST['air']] = $_POST['air'];
  }
  if (isset($_POST['earth'])) {
    $rune_types[$_POST['earth']] = $_POST['earth'];
  }
  if (isset($_POST['soul'])) {
    $rune_types[$_POST['soul']] = $_POST['soul'];
  }
  $column_count = 0;
  foreach ($user_info->crusaders AS $id => $crusader) {
    $crusader_name = '';
    if ($crusader->owned == 1) {
      $allowed_crusader = false;
      foreach ($crusader->gems AS $rune_info) {
        //janky, but w/e
        if ($_POST['join_type'] == 'and') {
          $rune_join_check = in_array($rune_info->level, $rune_level) && isset($rune_types[$rune_info->gem_id]);
        } else if ($_POST['join_type'] == 'or') {
          $rune_join_check = in_array($rune_info->level, $rune_level) || isset($rune_types[$rune_info->gem_id]);
        } else {
          $rune_join_check = in_array($rune_info->level, $rune_level) || isset($rune_types[$rune_info->gem_id]);
        }
        if ($rune_join_check) {
          $allowed_crusader = true;
          break;
        }
      }
      if ($allowed_crusader === false) {
        continue;
      }
      $crusader_image_info = get_crusader_image($game_defines->crusaders[$crusader->hero_id]->name);
      $image = $crusader_image_info['image'];
      $crusader_name = $crusader_image_info['name'];
      if ($column_count > 10) {
        $user_crusaders .= '</tr></tr>';
        $column_count = 0;
      }
      $hero_gem_slot_count = count($game_defines->crusaders[1]->hero_gem_slots);
      for ($slot = 1; $slot <= $hero_gem_slot_count; $slot++) {
        if (!empty($crusader->gems->$slot)) {
          $crusader_gems[$slot] = $crusader->gems->$slot;
        } else {
          $crusader_gems[$slot] = new \stdClass();
          if (empty($game_defines->crusaders[$crusader->hero_id]->hero_gem_slots[$slot]->gem_id)) {
            $crusader_gems[$slot]->gem_id = 1;
          } else {
            $crusader_gems[$slot]->gem_id = $game_defines->crusaders[$crusader->hero_id]->hero_gem_slots[$slot]->gem_id;
          }
          $crusader_gems[$slot]->level = 0;
        }
      }
      $crusader_gem_td = '';
      $gem_css = array(1 => 'text-align: center;width: 15px; height: 15px;position: relative;top: 25px;',
                       2 => 'text-align: center;width: 15px; height: 15px;position: relative;top: 30px; left: 10px;',
                       3 => 'text-align: center;width: 15px; height: 15px;position: relative;top: 15px; left: 28px;',
                       4 => 'text-align: center;width: 15px; height: 15px;position: relative;top: -20px; left: 34px;',
                       5 => 'text-align: center;width: 15px; height: 15px;position: relative;top: -52px; left: 18px;');
      foreach ($crusader_gems AS $slot => $crusader_gem) {
        if (!empty($crusader_gem)) {
          $crusader_gem_td .= '<div style="' . $gem_css[$slot] . '" class="' . strtok($game_defines->gems[$crusader_gem->gem_id]->name, " ") . '">' . $crusader_gem->level . '</div>';
        } else {
          $crusader_gem_td .= '<div style="' . $gem_css[$slot] . '">0</div>';
        }
      }
      $user_crusaders .= '<td style="vertical-align: top"><img src="' . $image . '" width="48px" height="48x">' . $crusader_gem_td . '</td>';
      $column_count++;
    }
  }
  $user_crusaders .= '</tr></table>';
}

?>
<div style="color:red;">This will only display your crusaders with runes at the level of your choosing</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" size="1" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="password" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  <div>Fill out the above two, or the one below, not both</div>
  Raw User Data: <input type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
  How to join rune selection(defaults to or): And<input type="radio" id="and" name="join_type" value="and" <?php echo ((isset($_POST['join_type']) && $_POST['join_type'] == 'and') ? 'checked' : ''); ?>> Or<input type="radio" id="or" name="join_type" value="or" <?php echo ((isset($_POST['join_type']) && $_POST['join_type'] == 'or') ? 'checked' : ''); ?>><br>
  Which Rune(s) To Display?: <table>
                            <tr>
                              <th>Type</th><th>View</th>
                            </tr>
                            <tr>
                              <td>Fire</td><td><input type="checkbox" name="fire" value="1" <?php echo ((isset($_POST['fire']) && $_POST['fire'] == 1) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>Water</td><td><input type="checkbox" name="water" value="2" <?php echo ((isset($_POST['water']) && $_POST['water'] == 2) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>Air</td><td><input type="checkbox" name="air" value="3" <?php echo ((isset($_POST['air']) && $_POST['air'] == 3) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>Earth</td><td><input type="checkbox" name="earth" value="4" <?php echo ((isset($_POST['earth']) && $_POST['earth'] == 4) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>Soul</td><td><input type="checkbox" name="soul" value="5" <?php echo ((isset($_POST['soul']) && $_POST['soul'] == 5) ? 'checked' : ''); ?>></td>
                            </tr>
                          </table>
  Which Rune Level To Display?: <table>
                            <tr>
                              <th>Level</th><th>View</th>
                              <th>Level</th><th>View</th>
                              <th>Level</th><th>View</th>
                            </tr>
                            <tr>
                              <td>1</td><td><input type="checkbox" name="level_1" value="1" <?php echo ((isset($_POST['level_1']) && $_POST['level_1'] == 1) ? 'checked' : ''); ?>></td>
                              <td>6</td><td><input type="checkbox" name="level_6" value="6" <?php echo ((isset($_POST['level_6']) && $_POST['level_6'] == 6) ? 'checked' : ''); ?>></td>
                              <td>11</td><td><input type="checkbox" name="level_11" value="11" <?php echo ((isset($_POST['level_11']) && $_POST['level_11'] == 11) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>2</td><td><input type="checkbox" name="level_2" value="2" <?php echo ((isset($_POST['level_2']) && $_POST['level_2'] == 2) ? 'checked' : ''); ?>></td>
                              <td>7</td><td><input type="checkbox" name="level_7" value="7" <?php echo ((isset($_POST['level_7']) && $_POST['level_7'] == 7) ? 'checked' : ''); ?>></td>
                              <td>12</td><td><input type="checkbox" name="level_12" value="12" <?php echo ((isset($_POST['level_12']) && $_POST['level_12'] == 12) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>3</td><td><input type="checkbox" name="level_3" value="3" <?php echo ((isset($_POST['level_3']) && $_POST['level_3'] == 3) ? 'checked' : ''); ?>></td>
                              <td>8</td><td><input type="checkbox" name="level_8" value="8" <?php echo ((isset($_POST['level_8']) && $_POST['level_8'] == 8) ? 'checked' : ''); ?>></td>
                              <td>13</td><td><input type="checkbox" name="level_13" value="13" <?php echo ((isset($_POST['level_13']) && $_POST['level_13'] == 13) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>4</td><td><input type="checkbox" name="level_4" value="4" <?php echo ((isset($_POST['level_4']) && $_POST['level_4'] == 4) ? 'checked' : ''); ?>></td>
                              <td>9</td><td><input type="checkbox" name="level_9" value="9" <?php echo ((isset($_POST['level_9']) && $_POST['level_9'] == 9) ? 'checked' : ''); ?>></td>
                              <td>14</td><td><input type="checkbox" name="level_14" value="14" <?php echo ((isset($_POST['level_14']) && $_POST['level_14'] == 14) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>5</td><td><input type="checkbox" name="level_5" value="5" <?php echo ((isset($_POST['level_5']) && $_POST['level_5'] == 5) ? 'checked' : ''); ?>></td>
                              <td>10</td><td><input type="checkbox" name="level_10" value="10" <?php echo ((isset($_POST['level_10']) && $_POST['level_10'] == 10) ? 'checked' : ''); ?>></td>
                              <td>15</td><td><input type="checkbox" name="level_15" value="15" <?php echo ((isset($_POST['level_15']) && $_POST['level_15'] == 15) ? 'checked' : ''); ?>></td>
                            </tr>
                          </table>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (!empty($user_crusaders)) {
  echo $user_crusaders;
}
?>
</html>
