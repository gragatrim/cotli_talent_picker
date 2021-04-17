<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data']) || !empty($_GET['saved_info'])) {
  if (!empty($_GET['saved_info'])) {
    if (file_exists('user_profiles/' . $_GET['saved_info'])) {
      $user_info = unserialize(file_get_contents('user_profiles/' . $_GET['saved_info']));
      $saved_form_html = $user_info->saved_form_html;
    } else {
      die();
    }
  } else {
    $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
    if (empty($_POST['user_id']) || empty($_POST['user_hash'])) {
      $identifier = md5($user_info->user_json->challenge_details->last_challenge_started->user_id);
      $salt = $user_info->user_json->challenge_details->last_challenge_started->user_id;
    } else {
      $identifier = $_POST['user_hash'];
      $salt = $_POST['user_id'];
    }
    $saved_form_html = generate_saved_forms($user_info->formation_saves['campaigns'], $game_defines);
    $saved_form_html .= generate_saved_forms($user_info->formation_saves['challenges'], $game_defines);
    //The salt needs to be 22 characters long users ID should be at least 7 characters, so I repeat it a few times to be sure that we should get it over 22 chars
    $saved_user_info_filename = md5(crypt($identifier, '$2y$10$' . substr(str_repeat($salt, 22), 0, 22) . '$'));
    $shareable_user_info = json_decode("{}");
    $shareable_user_info->crusaders = $user_info->crusaders;
    $shareable_user_info->total_ep = $user_info->total_ep;
    $shareable_user_info->number_owned_crusaders = $user_info->number_owned_crusaders;
    $shareable_user_info->reset_currency = $user_info->reset_currency;
    $shareable_user_info->reset_currency_spent = $user_info->reset_currency_spent;
    $shareable_user_info->loot = $user_info->loot;
    $shareable_user_info->total_gems = $user_info->total_gems;
    $shareable_user_info->total_gems_available = $user_info->total_gems_available;
    $shareable_user_info->buffs = $user_info->buffs;
    $shareable_user_info->crafting_materials = $user_info->crafting_materials;
    $shareable_user_info->chests = $user_info->chests;
    $shareable_user_info->stats = $user_info->stats;
    $shareable_user_info->crafting_materials = $user_info->crafting_materials;
    $shareable_user_info->saved_form_html = $saved_form_html;
    $shareable_user_info->all_season_data = new \stdClass();
    foreach ($user_info->all_season_data AS $season_id => $season_info) {
      $shareable_user_info->all_season_data->$season_id = new \stdClass();
      $shareable_user_info->all_season_data->$season_id->user_data = new \stdClass();
      $shareable_user_info->all_season_data->$season_id->user_data->season_id = $season_info->user_data->season_id;
      $shareable_user_info->all_season_data->$season_id->user_data->points = $season_info->user_data->points;
    }
    file_put_contents('user_profiles/' . $saved_user_info_filename, serialize($shareable_user_info));
  }
  $user_buffs = '<table style="float: left; clear:both;"><tr><th>Buff</th><th>Amount</th><th>Buff</th><th>Amount</th><th>Buff</th><th>Amount</th><th>Buff</th><th>Amount</th></tr>';
  $user_buff_table_array = array(0 => array());
  $column = 0;
  $row = 0;
  foreach ($user_info->buffs AS $id => $buff) {
    if ($column > 3) {
      $row++;
      $user_buff_table_array[$row] = array();
      $column = 0;
    }
    if ($buff->inventory_amount > 0) {
      //There is no common warp, so this leaves the cells empty
      if ($game_defines->buffs[$id]->name == 'Delorean') {
        $user_buff_table_array[$row][] = '<td></td><td></td>';
        $column++;
      }
      $user_buff_table_array[$row][] .= '<td>' . $game_defines->buffs[$id]->name . '</td><td>' . $buff->inventory_amount . '</td>';
      $column++;
    }
  }
  //To make the buffs display in the same order as in game I need to reverse the array
  $user_buff_table_array_reverse = array_reverse($user_buff_table_array);
  foreach ($user_buff_table_array_reverse AS $row) {
    $user_buffs .='</tr><tr>';
    foreach ($row AS $td) {
      $user_buffs .= $td;
    }
  }
  $user_buffs .= '</tr></table>';
  $user_trinkets = '<table style="float: left; clear:both;"><tr><th>Trinket</th><th>Amount</th><th>Buff</th><th>Amount</th><th>Buff</th><th>Amount</th><th>Buff</th><th>Amount</th></tr>';
  $column = 0;
  foreach ($user_info->loot AS $id => $loot) {
    if ($column > 3) {
      $user_trinkets .='</tr><tr>';
      $column = 0;
    }
    if ($game_defines->loot[$id]->hero_id == 0) {
      $user_trinkets .= '<td>' . $game_defines->loot[$id]->name . '</td><td>' . $loot->count . '</td>';
      $column++;
    }
  }
  $user_trinkets .= '</tr></table>';
  $user_crusaders = '<table style="float: left; clear:both;"><tr>';
  $crafting_materials_table = '<table style="float: left; clear:both;"><tr><th>Crafting Material</th><th>Amount</th></tr>';
  foreach ($game_defines->crafting_materials AS $crafting_material) {
    $crafting_materials_table .= '<tr><td>' . $crafting_material->name . '</td><td>' .  $user_info->crafting_materials->{$crafting_material->crafting_material_id} . '</td></tr>';
  }
  $crafting_materials_table .= '</table>';
  $column_count = 0;
  $hero_gem_slot_count = count($game_defines->crusaders[1]->hero_gem_slots);
  foreach ($user_info->crusaders AS $id => $crusader) {
    $unowned_crusader_img = '';
    $crusader_image_info = get_crusader_image($game_defines->crusaders[$crusader->hero_id]->name);
    $image = $crusader_image_info['image'];
    if ($crusader->owned !== 1) {
      $unowned_crusader_img = '<img src="./images/empty_slot.png" width="48px" height="48x" style="margin-left: -48px; opacity: 0.7;">';
    }
    $crusader_loot = get_crusader_loot($crusader, $user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $crusader);
    for ($slot = 1; $slot <= $hero_gem_slot_count; $slot++) {
      if (!empty($crusader->gems->$slot)) {
        $crusader_gems[$slot] = $crusader->gems->$slot;
      } else {
        $crusader_gems[$slot] = new \stdClass();
        $crusader_gems[$slot]->gem_id = $game_defines->crusaders[$crusader->hero_id]->hero_gem_slots[$slot]->gem_id;
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
    if ($column_count > 10) {
      $user_crusaders .= '</tr></tr>';
      $column_count = 0;
    }
    $user_crusaders .= '<td style="vertical-align: top"><img src="' . $image . '" width="48px" height="48x">' . $unowned_crusader_img . $crusader_gem_td . '</td><td style="text-align: center; width: 15px;">' . implode('', $crusader_loot) . '</td>';
    $column_count++;
  }
  $user_crusaders .= '</tr></table>';
  $total_mats = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials);
  $total_mats_with_chests = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials, true, $user_info->chests, $game_defines->chests);
  $total_mat_div = '<div style="float: left; clear: left;">Total Materials(including epic mats): ' . $total_mats . '</div>';
  $total_mat_div_with_chests = '<div style="float: left; clear: left;">Total Materials(including epic mats and all unopened chests): ' . $total_mats_with_chests . '</div>';
  $chests_opened = '<div style="float: left; clear: left;">Total normal silver chests opened: ' . $user_info->stats['normal_chests_opened'] . '</div>';
  $chests_opened .= '<div style="float: left; clear: left;">Total normal jeweled chests opened: ' . $user_info->stats['rare_chests_opened'] . '</div>';
  $gold_missions_completed = '<div style="float: left; clear: left;">Total gold missions completed: ' . $user_info->stats['gold_missions_completed'] . '</div>';
  $ep_info = '<div style="float: left; clear: left;">Total EP among all crusaders: ' . $user_info->total_ep . '</div>';
  $ep_info .= '<div style="float: left; clear: left;">Average EP among all crusaders: ' . ($user_info->total_ep / $user_info->number_owned_crusaders) . '</div>';
  $total_idols_div = '<div style="float: left; clear: left;">Total Idols: ' . (sprintf('%.0f', $user_info->reset_currency) + sprintf('%.0f', $user_info->reset_currency_spent)) . '</div>';
  $all_season_points_div = '';
  foreach ($user_info->all_season_data AS $season) {
    $all_season_points_div .= '<div style="float: left; clear: left;">Season ' . $season->user_data->season_id . ' Dungeon Points: ' . $season->user_data->points . '</div>';
  }
  $base_gem_total = '<div style="float: left;clear: left;">';
  foreach ($user_info->total_gems AS $gem_id => $gem_count) {
    $base_gem_total .= 'You have the equivalent of ' . $gem_count . ' lvl 1 ' . $game_defines->gems[$gem_id]->name .'s, and ' . $user_info->total_gems_available[$gem_id] . ' available <br>';
  }
  $base_gem_total .= '</div>';
}

//TODO this function is horrible it needs to be refactored, aka just removed and done better
function get_crusader_loot($crusader, $user_loot, $all_crusader_loot, $all_loot) {
  $owned_crusader_gear = array(1 => '<div style="background-color: black;">N</div>',
                               2 => '<div style="background-color: black;">N</div>',
                               3 => '<div style="background-color: black;">N</div>');
  foreach ($user_loot AS $id => $loot) {
    if ($all_loot[$loot->loot_id]->hero_id == $crusader->hero_id) {
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
<div style="color:red;">This will display all crusaders(unowned will have a light red X over their image) and their gear. It also displays mats/buffs/trinkets/dungeon points/runes/total & average ep/chests opened count.</div>
<div style="color:red;">This also displays your saved formations as well. Due to how the raw user data is saved, they will appear out of order if you use it.</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (empty($_GET['saved_info']) && !empty($user_crusaders)) {
  echo '<div style="float: left; clear: left;"><a href="?saved_info=' . $saved_user_info_filename . '">Share Profile</a>(Share this link to allow others to see your profile)</div>';
}
if (!empty($total_idols_div)) {
  echo $total_idols_div;
}
if (!empty($base_gem_total)) {
  echo $base_gem_total;
}
if (!empty($all_season_points_div)) {
  echo $all_season_points_div;
}
if (!empty($total_mat_div)) {
  echo $total_mat_div;
}
if (!empty($total_mat_div_with_chests)) {
  echo $total_mat_div_with_chests;
}
if (!empty($chests_opened)) {
  echo $chests_opened;
}
if (!empty($gold_missions_completed)) {
  echo $gold_missions_completed;
}
if (!empty($ep_info)) {
  echo $ep_info;
}
if (!empty($user_crusaders)) {
  echo $user_crusaders;
}
if (!empty($user_buffs)) {
  echo $user_buffs;
}
if (!empty($user_trinkets)) {
  echo $user_trinkets;
}
if (!empty($crafting_materials_table)) {
  echo $crafting_materials_table;
}
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
</html>
