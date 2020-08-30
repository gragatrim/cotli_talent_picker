<?php
include "navigation.php";
include "game_defines.php";
$game_defines = new GameDefines();
if ($_POST) {
  $event_id = htmlspecialchars($_POST['event_id']);

  $crusaders = [];
  foreach($game_defines->crusaders AS $hero) {
    $crusaders[$hero->id] = $hero;
  }

  $wiki_campaign = [];
  $all_campaigns = [];
  foreach($game_defines->campaigns AS $campaign) {
    if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id) && $campaign->requirements[0]->event_id == $event_id) {
      $wiki_campaign = $campaign;
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
  $event_achievements = '';
  $event_achievements_header_tier = 0;
  $achievement_count = 0.1;
  foreach ($game_defines->achievements AS $achievement) {
    if (empty($achievement->properties->for_event) || $achievement->properties->for_event != $event_id) {
      continue;
    }
    if ($event_achievements_header_tier != ceil($achievement_count/6)) {
      $event_achievements_header_tier++;
      $event_achievements .= "==Tier " . $event_achievements_header_tier . "==\n[[File:" . $event_acronym . "AchievementsT" . $event_achievements_header_tier . ".png|400px]]\n\n";
    }
    $event_achievements .= '===' . $achievement->name . "===\n";
    if (!empty($achievement->description)) {
      $event_achievements .= $achievement->description . "\n\n{{IncDPS|All|1%}}\n\n";
    } else if (strpos($achievement->requirements, 'ObjectivesComplete') !== false) {
        $event_achievements .= 'Complete all Tier ' . $event_achievements_header_tier . ' \'' . $wiki_campaign->name . "' Objectives.\n\n{{IncDPS|All|1%}}\n\n";
    } else if (strpos($achievement->requirements, 'Objective') !== false) {
      preg_match('/Objective([\d]+)/', $achievement->requirements, $matches);
      $objective_to_complete = $matches[1];
      $event_achievements .= $achievement->name . ' by completing "' . $game_defines->objectives[$objective_to_complete]->name . "\".\n\n{{IncDPS|All|1%}}\n\n";
    } else if (strpos($achievement->requirements, 'FreePlayHighestArea') !== false) {
      preg_match('/>([\d]+)/', $achievement->requirements, $matches);
      $free_play_highest_area = $matches[1];
      $event_achievements .= 'Beat area ' . $free_play_highest_area . ' in "' . $wiki_campaign->name . "\" Free Play.\n\n{{IncDPS|All|1%}}\n\n";
    } else if (strpos($achievement->requirements, 'Spent') !== false) {
      preg_match('/(.*)>([\d]+)/', $achievement->requirements, $matches);
      $currency_name_chunks = preg_split('/([A-Z]+[^A-Z]*)/', substr($matches[1], 0, -5), -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
      $currency_name = implode(" ", $currency_name_chunks);
      $currency_spent = $matches[2];
      $event_achievements .= 'Spend ' . number_format($currency_spent) . ' ' . $currency_name . ' starting objectives in the \'' . $wiki_campaign->name . "' campaign. " . $currency_name . " spent on purchasing chests don't count!\n\n{{IncDPS|All|1%}}\n\n";
    } else if (strpos($achievement->requirements, 'EquipSlotsFull') !== false) {
      preg_match('/Crusader([\d]+)/', $achievement->requirements, $matches);
      $crusader_id = $matches[1];
      $event_achievements .= 'Get a piece of equipment in all three slots for ' . $crusaders[$crusader_id]->name . ".\n\n{{IncDPS|All|1%}}\n\n";
    }
    $achievement_count++;
  }
}
if (empty($all_campaigns)) {
  $all_campaigns = [];
  foreach($game_defines->campaigns AS $campaign) {
    $all_campaigns[] = $campaign;
  }
}
?>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Event Id: <input type="text" name="event_id" value="<?php echo (isset($_POST['event_id']) ? htmlspecialchars($_POST['event_id']) : 0); ?>"><br>
Force Game Detail Refresh: <input type="checkbox" name="game_details_refresh" value="1" not-checked><br>
<input type="submit">
</form>
<br>
<?php
$all_events = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Event Name</th></tr>';
foreach($all_campaigns AS $campaign) {
  if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id)) {
    $all_events .= '<tr><td class="borderless">' . $campaign->requirements[0]->event_id . '</td><td class="borderless">' . $campaign->name . '</td></tr>';
  }
}
$all_events .= '</table>';
echo $all_events;
if (!empty($event_achievements)) {
  echo '<pre style="float: left; clear: left;">' . $event_achievements . '</pre>';
} else {
  echo '<div style="float: left; clear: left;">No event/tier with that ID found';
}
?>
