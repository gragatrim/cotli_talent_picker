<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server']) || !empty($_POST['raw_user_data']) || !empty($_GET['saved_info'])) {
  if (!empty($_GET['saved_info'])) {
    $user_info = unserialize(file_get_contents('user_profiles/' . $_GET['saved_info']));
  } else {
    $user_info = new UserDefines($_POST['server'], $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
    $saved_user_info_filename = md5($_POST['user_id'] . $_POST['user_hash']);
    $shareable_user_info = json_decode("{}");
    $shareable_user_info->crusaders = $user_info->crusaders;
    $shareable_user_info->loot = $user_info->loot;
    $shareable_user_info->crafting_materials = $user_info->crafting_materials;
    file_put_contents('user_profiles/' . $saved_user_info_filename, serialize($shareable_user_info));
  }
  $user_crusaders = '<table style="float: left; clear:both;"><tr>';
  $column_count = 0;
  foreach ($user_info->crusaders AS $id => $crusader) {
    $crusader_name = '';
    if ($crusader->owned == 1) {
      $crusader_image_info = get_crusader_image($game_defines->crusaders[$crusader->hero_id]->name);
      $image = $crusader_image_info['image'];
      $crusader_name = $crusader_image_info['name'];
      $crusader_loot = get_crusader_loot($game_defines->crusaders[$crusader->hero_id], $user_info->loot, $game_defines->crusader_loot, $game_defines->loot);
      if ($column_count > 10) {
        $user_crusaders .= '</tr></tr>';
        $column_count = 0;
      }
      $user_crusaders .= '<td style="height: 48px; width: 48px;background-repeat: no-repeat; background-size: contain;background-image: url(\'' . $image .'\')">' . $crusader_name . '</td><td>' . implode('', $crusader_loot) . '</td>';
      $column_count++;
    }
  }
  $user_crusaders .= '</tr></table>';
  $total_mats = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials);
  $total_mat_div = '<div style="float: left; clear: left;">Total Materials(including epic mats): ' . $total_mats . '</div>';
}

function get_crusader_loot($crusader, $user_loot, $all_crusader_loot, $all_loot) {
  $owned_crusader_gear = array(1 => '<div style="background-color: black;">N</div>',
                               2 => '<div style="background-color: black;">N</div>',
                               3 => '<div style="background-color: black;">N</div>');
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

function get_total_mats($user_loot, $all_crusader_loot, $all_loot, $crafting_materials) {
  $total_mats = 0;
  foreach ($user_loot AS $id => $loot) {
    foreach($all_crusader_loot[$all_loot[$loot->loot_id]->hero_id] AS $slot_id => $crusader_all_slot_loot) {
      foreach ($crusader_all_slot_loot AS $crusader_slot_loot) {
        if ($crusader_slot_loot->id == $loot->loot_id) {
          if ($crusader_slot_loot->rarity == 5) {
            for ($i = 1; $i < $loot->count; $i++) {
              $total_mats += (250 * pow(2, ($i-1)));
            }
          }
        }
      }
    }
  }
  foreach ($crafting_materials AS $id => $material) {
    switch ($id) {
      case 1:
        $total_mats += $material;
        break;
      case 2:
        $total_mats += $material * 2;
        break;
      case 3:
        $total_mats += $material * 4;
        break;
      case 4:
        $total_mats += $material * 8;
        break;
    }
  }
  return $total_mats;
}

?>
<div style="color:red;">This will only display your crusaders and their gear</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? htmlspecialchars($_POST['server']) : ''); ?>"><br>
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (empty($_GET['saved_info']) && !empty($user_crusaders)) {
  echo '<div style="float: left; clear: left;"><a href="?saved_info=' . $saved_user_info_filename . '">Share Profile</a>(Share this link to allow others to see your profile)</div>';
}
if (!empty($total_mat_div)) {
  echo $total_mat_div;
}
if (!empty($user_crusaders)) {
  echo $user_crusaders;
}
?>
</html>
