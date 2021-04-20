<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

$saved_form = array();
if (!empty($_POST) && !empty($_POST['formation_id'])) {
  $saved_form_html = '';
  $saved_form_html .= '<b style="float: left; clear: left;">' . $game_defines->campaign_formations[$_POST['formation_id']]['name'] . '</b><br>';
  if (((!empty($_POST['user_id']) && !empty($_POST['user_hash'])) || !empty($_POST['raw_user_data'])) && !empty($_POST['save_slot'])) {
    $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
    if (!empty($user_info->formation_saves['campaigns']->{$_POST['formation_id']})) {
      $saved_form = $user_info->formation_saves['campaigns']->{$_POST['formation_id']}->{$_POST['save_slot']}[0];
    } else {
      $saved_form = $user_info->formation_saves['challenges']->{$_POST['formation_id']}->{$_POST['save_slot']}[0];
    }
  }
  $saved_form_html .= '<div style="float: left; clear: left; position: relative; height: 400px; width: 500px; background-color: lightgray; border: 1px solid;">';
  $saved_form_html .= generate_formation_image($saved_form, $game_defines->campaign_formations[$_POST['formation_id']]['name'], $game_defines->crusaders, $game_defines->campaign_formations);
  $saved_form_html .= '</div>';
}

$all_crusaders_div = '<div style="float:left; clear: left; width: 80%;">';
foreach($game_defines->crusaders_in_seat_order AS $crusader_seat) {
  $all_crusaders_div .= '<div style="float: left;border: solid 2px; margin: 5px;width: 300px;">';
  foreach($crusader_seat AS $crusader) {
      $crusader_image_info = get_crusader_image($crusader->name);
      $image = $crusader_image_info['image'];
      $draggable = 'draggable="true" ondragstart="drag(event)"';
      if ($image != './images/empty_slot.png') {
        //This has to be in here(as well as the check above to safely not leak new crusaders that get pushed live before they should be
        if (!is_array($saved_form) || in_array($crusader->id, $saved_form)) {
          $image = './images/empty_slot.png';
          $draggable = 'draggable="true"';
        }
        $all_crusaders_div .= '<div id="td_crusader' . $crusader->id . '" style="float: left; padding: 1px;"><img id="crusader' . $crusader->id. '" src="' . $image . '" ' . $draggable . ' width="48px" height="48px"></div>';
      }
  }
  $all_crusaders_div .= '</div>';
}
$all_crusaders_div .= '</div>';
?>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
Formation Id: <input type="text" name="formation_id" value="<?php echo (isset($_POST['formation_id']) ? htmlspecialchars($_POST['formation_id']) : ''); ?>"><br>
User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
Save Slot: <input type="text" name="save_slot" value="<?php echo (isset($_POST['save_slot']) ? htmlspecialchars($_POST['save_slot']) : ''); ?>"><br>
Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php echo $all_crusaders_div; ?>
<?php
echo generate_formation_table($game_defines);
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
<img style="float: left" src="./images/trash_can.jpg" height="100px" width="100px" ondrop="trashDrop(event)" ondragover="allowDrop(event)">
</html>
