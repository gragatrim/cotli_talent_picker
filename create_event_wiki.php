<?php

//No need to hammer the server all the time, an update a day should be acceptable
if (!file_exists('game_defines') || time() - filemtime('game_defines') > 24 * 3600 || !empty($_POST['game_details_refresh'])) {
  $game_definitions_ch = curl_init();
  curl_setopt($game_definitions_ch, CURLOPT_URL, "http://idleps19.djartsgames.ca/~idle/post.php?call=getDefinitions");
  curl_setopt($game_definitions_ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($game_definitions_ch, CURLOPT_RETURNTRANSFER, true );

  $game_info = curl_exec($game_definitions_ch);
  file_put_contents('game_defines', $game_info);
  curl_close($game_definitions_ch);
} else {
  $game_info = file_get_contents('game_defines');
}
$game_json = json_decode($game_info);
if ($_POST) {
  $event_id = $_POST['event_id'];
  $tier = $_POST['tier'];

  $crusaders = [];
  foreach($game_json->hero_defines AS $hero) {
    $crusaders[$hero->id] = $hero;
  }
  $crusader_skins = [];
  foreach($game_json->hero_skin_defines AS $hero_skin) {
    $crusader_skins[$hero_skin->id] = $hero_skin;
  }

  $wiki_campaign = [];
  $all_campaigns = [];
  foreach($game_json->campaign_defines AS $campaign) {
    if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id) && $campaign->requirements[0]->event_id == $event_id) {
      $wiki_campaign = $campaign;
    }
    $all_campaigns[] = $campaign;
  }
  $objectives = array();
  foreach($game_json->objective_defines AS $objective) {
    if (!empty($wiki_campaign) && $objective->campaign_id == $wiki_campaign->id && ($objective->tier == $tier || empty($tier))) {
      $objectives[$objective->id] = $objective;
    }
  }
  $chests = [];
  foreach($game_json->chest_type_defines AS $chest) {
    $chests[$chest->id] = $chest;
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
  foreach ($objectives AS $objective) {
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
      foreach ($crusaders AS $crusader) {
        if ($crusader->seat_id == $crusaders[$objective->rewards[0]->crusader_id]->seat_id && $crusader->id != $objective->rewards[0]->crusader_id) {
          $alt_crusaders .= '[[' . $crusader->name . ']], ';
        }
      }
      $event_objectives .= "|Reward T1 = [[" . $crusaders[$objective->rewards[0]->crusader_id]->name . "]]";
      if (!empty($alt_crusaders)) {
        $event_objectives .= " swaps with " . substr($alt_crusaders, 0, -2) . "\n";
      }
    } else if ($objective->rewards[0]->reward == 'chest') {
      $objective->requirements_text . "\n";
      if (!empty($objective->rewards[0]->chest_type_id)) {
        $event_objectives .= '|Reward T1 = ' . $chests[$objective->rewards[0]->chest_type_id]->name . "\n";
      } else if (!empty($objective->rewards[0]->chest_type_ids)) {
        $event_objectives .= '|Reward T1 = ';
        $chest_rewards = '';
        foreach($objective->rewards[0]->chest_type_ids AS $event_chest) {
          $chest_rewards .= $chests[$event_chest]->name . ' or ';
        }
        $event_objectives .= substr($chest_rewards, 0, -4) .  "\n";
      }
    } else if ($objective->rewards[0]->reward == 'hero_skin') {
      $event_objectives .= '|Reward T1 = "' . $crusader_skins[$objective->rewards[0]->hero_skin_id]->name . '"' . htmlentities('<br/>') . "\n";
      $event_objectives .= 'Unlocks the ' . $crusader_skins[$objective->rewards[0]->hero_skin_id]->name . " skin for [[" . $crusaders[$crusader_skins[$objective->rewards[0]->hero_skin_id]->hero_id]->name . "]]\n";
    }
    $event_objectives .= "}}\n\n";
  }
}
if (empty($all_campaigns)) {
  $all_campaigns = [];
  foreach($game_json->campaign_defines AS $campaign) {
    $all_campaigns[] = $campaign;
  }
}
?>
<html>
<head>
<style>
</style>
</head>
<body>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Event Id: <input type="text" name="event_id" value="<?php echo (isset($_POST['event_id']) ? $_POST['event_id'] : 0); ?>"><br>
Tier: <input type="text" name="tier" value="<?php echo (isset($_POST['tier']) ? $_POST['tier'] : 0); ?>"> (leave this empty for all tiers to be generated)<br>
Force Game Detail Refresh: <input type="checkbox" name="game_details_refresh" value="1" not-checked><br>
<input type="submit">
</form>
<br>
<?php
$all_events = '<table style="float:right;"><tr><th>Id</th><th>Event Name</th></tr>';
foreach($all_campaigns AS $campaign) {
  if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id)) {
    $all_events .= '<tr><td>' . $campaign->requirements[0]->event_id . '</td><td>' . $campaign->name . '</td></tr>';
  }
}
$all_events .= '</table>';
echo $all_events;
if (!empty($event_objectives)) {
  echo '<pre style="float: left; clear: left;">' . $event_objectives . '</pre>';
} else {
  echo '<div style="float: left; clear: left;">No event/tier with that ID found';
}
?>

