<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;


if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data'])) {
  $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
  foreach ($user_info->user_json->event_details AS $event) {
    if ($event->event_id == 273 && $event->active == 1) {
      $ge_ids = $event->details->flash_sale_loot_ids;
      $ge_id_flip = array_flip($ge_ids);
    }
  }
  $missing_ge = '';
  if (!empty($ge_ids)) {
    foreach ($user_info->loot AS $loot_id => $loot_info) {
      //Loops over all crusaders so you can look at their gear
      foreach ($game_defines->crusader_loot AS $crusder_loot_id => $crusader_loot) {
        //Loops over all gear slots
        foreach($crusader_loot AS $gear_slot_id => $gear_slot_loot) {
          //Loops over each of the gear in each slot
          foreach($gear_slot_loot AS $id => $gear) {
            //If you don't own the crusader, you can't get thier GE in the flash sale
            if (empty($user_info->crusaders[$gear->hero_id]) || $user_info->crusaders[$gear->hero_id]->owned == 0) {
              unset($ge_id_flip[$gear->id]);
              continue;
            }
            if ($gear->id == $loot_id && isset($ge_id_flip[$loot_id])
            || (isset($gear_slot_loot[($id-1)]) && $gear_slot_loot[($id-1)]->id == ($loot_id - 1) && isset($ge_id_flip[$gear_slot_loot[($id-1)]->id]))) {
              unset($ge_id_flip[$loot_id]);
              unset($ge_id_flip[$gear_slot_loot[($id-1)]->id]);
            }
            //Billy's GL is 1151 while the GE is 610, breaking the standard that all other items use
            if ($loot_id == 1151) {
              unset($ge_id_flip[610]);
            }
          }
        }
      }
    }
    foreach ($ge_id_flip AS $id => $value) {
      $missing_ge .= '<b>' . $game_defines->crusaders[$game_defines->loot[$id]->hero_id]->name . '</b>:' . $game_defines->loot[$id]->name . '<br>';
    }
  } else {
      $missing_ge .= '<b>No current flash sale active!</b><br>';
  }
}
?>
<div style="color: red;">This page will show you what GEs you are missing in the current flash sale frenzy!(Assuming one is running)</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" size="1" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="password" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
  if (!empty($missing_ge)) {
    echo '<div style="clear: left;padding-top: 10px;">' . $missing_ge . '</div>';
  }
?>
