<?php
include "navigation.php";

$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server'])) {
  $user_info = new UserDefines($_POST['server'], $_POST['user_id'], $_POST['user_hash']);
  $crusaders_in_saved_forms = array();
  foreach ($user_info->formation_saves['campaigns'] AS $campaign => $saved_forms) {
    if ($campaign == $user_info->user_json->current_campaign_id) {
      foreach ($saved_forms AS $saved_form_id => $saved_form) {
        if ($saved_form_id != 2 && $saved_form_id != 4) {
          foreach ($saved_form[0] AS $crusaders_in_form) {
            $crusaders_in_saved_forms[$crusaders_in_form] = $crusaders_in_form;
          }
        }
      }
    }
  }
  //This is the start of something that will allow for starting missions
  $available_crusaders = array();
  foreach ($user_info->crusaders AS $crusader) {
    if ($crusader->owned == 1 && !in_array($crusader->hero_id, $user_info->user_json->formation) && !in_array($crusader->hero_id, $crusaders_in_saved_forms)) {
      $available_crusaders[$crusader->hero_id] = $game_defines->crusaders[$crusader->hero_id];
    }
  }
  $duration = 99999999999999;
  foreach ($user_info->missions['available_missions'] as $available_missions) {
    if ($game_defines->missions[$available_missions->mission_id]->duration < $duration) {
      $fastest_mission = $available_missions;
      $duration = $game_defines->missions[$available_missions->mission_id]->duration;
    }
  }
  //foreach($available_crusaders AS $available_crusader) {
  //  debug($available_crusader, 'available_crusader');
  //  foreach ($available_crusader->properties->tags AS $tag) {
  //    $matching_tags = 0;
  //    if (in_array($tag, $game_defines->missions[$fastest_mission->mission_id]->required_tags)) {
  //      //$matched_tags
  //      $matching_tags++;
  //    }
  //    if ($matching_tags > 0)
  //    $matching_tags = 0;
  //  }
  //}
  foreach($user_info->missions['active_missions'] AS $active_mission) {
    $mission_crusaders = '109,1,60,111,7';
    $parameters = "&instance_id=" . $user_info->instance_id . "&crusaders=" . $mission_crusaders . "&mission_id=171";
    $mission_response = call_cne($_POST['server'], $_POST['user_id'], $_POST['user_hash'], 'startmission', $parameters);
    debug($mission_response, 'mission_response');
  }
}

?>
<div style="color: red;">This will complete all mission that you have that are ready to be complete. You will need to restart the game for the changes to take effect</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? htmlspecialchars($_POST['server']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>

