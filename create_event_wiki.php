<?php
include "navigation.php";

if ($_POST) {
  if (!empty($_POST['force_refresh'])) {
    $force_refresh = true;
  } else {
    $force_refresh = false;
  }
  if (!empty($_POST['use_dev_info'])) {
    $use_dev_info = true;
  } else {
    $use_dev_info = false;
  }
  $game_defines = new GameDefines($force_refresh, $use_dev_info);
  $campaign_id = htmlspecialchars($_POST['campaign_id']);
  $tier = htmlspecialchars($_POST['tier']);

  $wiki_campaign = [];
  $all_campaigns = [];
  //Not used yet, TODO implement functionality so that normal campaigns can be properly formatted
  $is_event_campaign = false;
  foreach($game_defines->campaigns AS $campaign) {
    if (!empty($campaign->id) && $campaign->id == $campaign_id) {
      $wiki_campaign = $campaign;
    }
    if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id) && $campaign->requirements[0]->event_id == $campaign_id) {
      $is_event_campaign = true;
    }
    $all_campaigns[] = $campaign;
  }
  //This is used for image names
  $event_acronym = '';
  $event_tok = strtok($wiki_campaign->name, ' ');
  while ($event_tok != false) {
    $event_acronym .= strtoupper($event_tok[0]);
    $event_tok = strtok(' ');
  }
  $event_objectives = '';
  $event_objective_header_tier = 0;
  foreach ($game_defines->objectives AS $objective) {
    if (empty($wiki_campaign) || $objective->campaign_id != $wiki_campaign->id || !($objective->tier == $tier || empty($tier))) {
      continue;
    }
    if ($event_objective_header_tier != $objective->tier) {
      $event_objectives .= "=Tier " . $objective->tier . " Objectives=\n[[File:" . $event_acronym . "ObjectivesT" . $objective->tier . ".png|500px]]\n\n";
      $event_objective_header_tier = $objective->tier;
    }
    $event_objectives .= "{{Objective\n";
    $event_objectives .= '|Objective name = ' . $objective->name . "\n";
    $event_objectives .= '|Image T1 = ' . $event_acronym . str_replace(array(" ", ',', "'"), "", ucwords($objective->name)) . ".png\n";
    $event_objectives .= '|Objective T1 = ' . $objective->description . "\n";
    $event_objectives .= '|Restrictions T1 = ' . str_replace("- ", '* ', str_replace("\n-", ':*', $objective->requirements_text)) . "\n";
    if ($objective->rewards[0]->reward == 'claim_crusader') {
      $alt_crusaders = '';
      foreach ($game_defines->crusaders AS $crusader) {
        if ($crusader->seat_id == $game_defines->crusaders[$objective->rewards[0]->crusader_id]->seat_id && $crusader->id != $objective->rewards[0]->crusader_id) {
          $alt_crusaders .= '[[' . $crusader->name . ']], ';
        }
      }
      $event_objectives .= "|Reward T1 = [[" . $game_defines->crusaders[$objective->rewards[0]->crusader_id]->name . "]]";
      if (!empty($alt_crusaders)) {
        $event_objectives .= " swaps with " . substr($alt_crusaders, 0, -2) . "\n";
      }
    } else if ($objective->rewards[0]->reward == 'chest') {
      $objective->requirements_text . "\n";
      if (!empty($objective->rewards[0]->chest_type_id)) {
        $event_objectives .= '|Reward T1 = ' . $game_defines->chests[$objective->rewards[0]->chest_type_id]->name . "\n";
      } else if (!empty($objective->rewards[0]->chest_type_ids)) {
        $event_objectives .= '|Reward T1 = ';
        $chest_rewards = '';
        foreach($objective->rewards[0]->chest_type_ids AS $event_chest) {
          $chest_rewards .= $game_defines->chests[$event_chest]->name . ' or ';
        }
        $event_objectives .= substr($chest_rewards, 0, -4) .  "\n";
      }
    } else if ($objective->rewards[0]->reward == 'hero_skin') {
      $event_objectives .= '|Reward T1 = "' . $game_defines->crusader_skins[$objective->rewards[0]->hero_skin_id]->name . '"' . htmlentities('<br/>') . "\n";
      $event_objectives .= 'Unlocks the ' . $game_defines->crusader_skins[$objective->rewards[0]->hero_skin_id]->name . " skin for [[" . $game_defines->crusaders[$game_defines->crusader_skins[$objective->rewards[0]->hero_skin_id]->hero_id]->name . "]]\n";
    }
    $event_objectives .= "}}\n\n";
  }
}
if (empty($all_campaigns)) {
  $game_defines = new GameDefines();
  $all_campaigns = [];
  foreach($game_defines->campaigns AS $campaign) {
    $all_campaigns[] = $campaign;
  }
}
?>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Campaign Id: <input type="text" name="campaign_id" value="<?php echo (isset($_POST['campaign_id']) ? htmlspecialchars($_POST['campaign_id']) : 0); ?>"><br>
Tier: <input type="text" name="tier" value="<?php echo (isset($_POST['tier']) ? htmlspecialchars($_POST['tier']) : 0); ?>"> (leave this empty for all tiers to be generated)<br>
Force Game Detail Refresh: <input type="checkbox" name="game_details_refresh" value="1" not-checked><br>
Use Dev Info?: <input type="checkbox" name="use_dev_info" value="1" not-checked><br>
<input type="submit">
</form>
<br>
<?php
$all_events = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Event Name</th></tr>';
foreach($all_campaigns AS $campaign) {
  $all_events .= '<tr><td class="borderless">' . $campaign->id . '</td><td class="borderless">' . $campaign->name . '</td></tr>';
}
$all_events .= '</table>';
echo $all_events;
if (!empty($event_objectives)) {
  if (!$is_event_campaign) {
    echo '<div style="color:red;float: left; clear: left;">Not perfectly implemented yet based on what the wiki expects, uses the event format currently</div>';
  }
  echo '<pre style="float: left; clear: left;">' . $event_objectives . '</pre>';
} else {
  echo '<div style="float: left; clear: left;">No event/tier with that ID found';
}
?>

