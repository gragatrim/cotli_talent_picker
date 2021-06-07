<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data'])) {
  $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
  $user_crusaders = '<table style="float: left; clear:both;"><tr>';
  $gear_level = array();
  for ($i = 1; $i < 21; $i++) {
    if (isset($_POST['level_' . $i])) {
      $gear_level[] = $i;
    }
  }
  $column_count = 0;
  foreach ($user_info->crusaders AS $id => $crusader) {
    $crusader_name = '';
    if ($crusader->owned == 1) {
      $crusader_loot = get_crusader_loot($game_defines->crusaders[$crusader->hero_id], $user_info->loot, $game_defines->crusader_loot, $game_defines->loot);
      $crusader_loot_html[1] = $crusader_loot[1];
      $crusader_loot_html[2] = $crusader_loot[2];
      $crusader_loot_html[3] = $crusader_loot[3];
      $allowed_crusader = false;
      foreach ($crusader_loot AS $loot) {
        if (is_numeric($loot) && in_array($loot, $gear_level)) {
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
      $user_crusaders .= '<td style="height: 48px; width: 48px;background-repeat: no-repeat; background-size: contain;background-image: url(\'' . $image .'\')">' . $crusader_name . '</td><td>' . implode('', $crusader_loot_html) . '</td>';
      $column_count++;
    }
  }
  $user_crusaders .= '</tr></table>';
}

//Copy pasta from user_profiles.php with added stuff, should probably be refactored
function get_crusader_loot($crusader, $user_loot, $all_crusader_loot, $all_loot) {
  $owned_crusader_gear = array(1 => '<div style="background-color: black;">N</div>',
                               2 => '<div style="background-color: black;">N</div>',
                               3 => '<div style="background-color: black;">N</div>',
                               4 => 0,
                               5 => 0,
                               6 => 0);
  foreach ($user_loot AS $id => $loot) {
    if ($all_loot[$loot->loot_id]->hero_id == $crusader->id) {
      foreach($all_crusader_loot[$all_loot[$loot->loot_id]->hero_id] AS $slot_id => $crusader_all_slot_loot) {
        foreach ($crusader_all_slot_loot AS $crusader_slot_loot) {
          if ($crusader_slot_loot->id == $loot->loot_id) {
            $gear_level = '';
            switch ($crusader_slot_loot->rarity) {
              case 1:
                  $gear_level = '<div style="background-color: grey;">C</div>';
                break;
              case 2:
                  $gear_level = '<div style="background-color: green;">U</div>';
                break;
              case 3:
                  $gear_level = '<div style="background-color: #3378fe;">R</div>';
                break;
              case 4:
                if ($crusader_slot_loot->golden == 0) {
                  $gear_level = '<div style="background-color: mediumpurple;">E</div>';
                } else {
                  $gear_level = '<div style="background-color: lightcoral;">GE</div>';
                }
                break;
              case 5:
                if ($crusader_slot_loot->golden == 0) {
                  $gear_level = '<div style="background-color: lightblue;">' . $loot->count . '</div>';
                } else {
                  $gear_level = '<div style="background-color: gold;">' . $loot->count . '</div>';
                }
                $owned_crusader_gear[$crusader_slot_loot->slot_id + 3] = $loot->count;
                break;
            }
            $owned_crusader_gear[$crusader_slot_loot->slot_id] = $gear_level;
          }
        }
      }
    }
  }
  return $owned_crusader_gear;
}

?>
<div style="color:red;">This will only display your crusaders with legendary gear at the level of your choosing</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" size="1" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="password" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  <div>Fill out the above two, or the one below, not both</div>
  Raw User Data: <input type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
  Which Gear To Display?: <table>
                            <tr>
                              <th>Level</th><th>View</th>
                              <th>Level</th><th>View</th>
                              <th>Level</th><th>View</th>
                              <th>Level</th><th>View</th>
                            </tr>
                            <tr>
                              <td>1</td><td><input type="checkbox" name="level_1" value="1" <?php echo ((isset($_POST['level_1']) && $_POST['level_1'] == 1) ? 'checked' : ''); ?>></td>
                              <td>6</td><td><input type="checkbox" name="level_6" value="6" <?php echo ((isset($_POST['level_6']) && $_POST['level_6'] == 6) ? 'checked' : ''); ?>></td>
                              <td>11</td><td><input type="checkbox" name="level_11" value="11" <?php echo ((isset($_POST['level_11']) && $_POST['level_11'] == 11) ? 'checked' : ''); ?>></td>
                              <td>16</td><td><input type="checkbox" name="level_16" value="16" <?php echo ((isset($_POST['level_16']) && $_POST['level_16'] == 16) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>2</td><td><input type="checkbox" name="level_2" value="2" <?php echo ((isset($_POST['level_2']) && $_POST['level_2'] == 2) ? 'checked' : ''); ?>></td>
                              <td>7</td><td><input type="checkbox" name="level_7" value="7" <?php echo ((isset($_POST['level_7']) && $_POST['level_7'] == 7) ? 'checked' : ''); ?>></td>
                              <td>12</td><td><input type="checkbox" name="level_12" value="12" <?php echo ((isset($_POST['level_12']) && $_POST['level_12'] == 12) ? 'checked' : ''); ?>></td>
                              <td>17</td><td><input type="checkbox" name="level_17" value="17" <?php echo ((isset($_POST['level_17']) && $_POST['level_17'] == 17) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>3</td><td><input type="checkbox" name="level_3" value="3" <?php echo ((isset($_POST['level_3']) && $_POST['level_3'] == 3) ? 'checked' : ''); ?>></td>
                              <td>8</td><td><input type="checkbox" name="level_8" value="8" <?php echo ((isset($_POST['level_8']) && $_POST['level_8'] == 8) ? 'checked' : ''); ?>></td>
                              <td>13</td><td><input type="checkbox" name="level_13" value="13" <?php echo ((isset($_POST['level_13']) && $_POST['level_13'] == 13) ? 'checked' : ''); ?>></td>
                              <td>18</td><td><input type="checkbox" name="level_18" value="18" <?php echo ((isset($_POST['level_18']) && $_POST['level_18'] == 18) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>4</td><td><input type="checkbox" name="level_4" value="4" <?php echo ((isset($_POST['level_4']) && $_POST['level_4'] == 4) ? 'checked' : ''); ?>></td>
                              <td>9</td><td><input type="checkbox" name="level_9" value="9" <?php echo ((isset($_POST['level_9']) && $_POST['level_9'] == 9) ? 'checked' : ''); ?>></td>
                              <td>14</td><td><input type="checkbox" name="level_14" value="14" <?php echo ((isset($_POST['level_14']) && $_POST['level_14'] == 14) ? 'checked' : ''); ?>></td>
                              <td>19</td><td><input type="checkbox" name="level_19" value="19" <?php echo ((isset($_POST['level_19']) && $_POST['level_19'] == 19) ? 'checked' : ''); ?>></td>
                            </tr>
                            <tr>
                              <td>5</td><td><input type="checkbox" name="level_5" value="5" <?php echo ((isset($_POST['level_5']) && $_POST['level_5'] == 5) ? 'checked' : ''); ?>></td>
                              <td>10</td><td><input type="checkbox" name="level_10" value="10" <?php echo ((isset($_POST['level_10']) && $_POST['level_10'] == 10) ? 'checked' : ''); ?>></td>
                              <td>15</td><td><input type="checkbox" name="level_15" value="15" <?php echo ((isset($_POST['level_15']) && $_POST['level_15'] == 15) ? 'checked' : ''); ?>></td>
                              <td>20</td><td><input type="checkbox" name="level_20" value="20" <?php echo ((isset($_POST['level_20']) && $_POST['level_20'] == 20) ? 'checked' : ''); ?>></td>
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
