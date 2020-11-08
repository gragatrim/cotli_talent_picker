<?php
include "navigation.php";

$game_defines = new GameDefines();
$game_json = $game_defines->game_json;
if (!empty($_POST['user_id']) && !empty($_POST['user_hash'])) {
  $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash']);
  $crusaders_in_saved_forms = array();
  foreach ($user_info->formation_saves['campaigns'] AS $campaign => $saved_forms) {
    if ($campaign == $user_info->user_json->current_campaign_id) {
      foreach ($saved_forms AS $saved_form_id => $saved_form) {
        foreach ($saved_form[0] AS $crusaders_in_form) {
          $crusaders_in_saved_forms[$crusaders_in_form] = $crusaders_in_form;
        }
      }
    }
  }
  $crusaders_with_skins = array();
  foreach ($user_info->skins AS $crusader_skins) {
    if (isset($game_defines->crusader_skins[$crusader_skins->id]) && $crusader_skins->effects_equipped == 1 && isset($game_defines->crusader_skins[$crusader_skins->id]->properties->tags)) {
      $crusaders_with_skins[$game_defines->crusader_skins[$crusader_skins->id]->hero_id] = $game_defines->crusader_skins[$crusader_skins->id]->properties->tags;
    }
  }
  $crusaders_on_mission = array();
  foreach($user_info->missions['active_missions'] AS $active_mission) {
    foreach ($active_mission->crusaders AS $crusader) {
      $crusaders_on_mission[] = $crusader;
    }
  }
  $available_crusaders = array();
  foreach ($user_info->crusaders AS $crusader) {
    if (!in_array($crusader->hero_id, $crusaders_on_mission) && $crusader->owned == 1 && !in_array($crusader->hero_id, $user_info->user_json->formation) && !in_array($crusader->hero_id, $crusaders_in_saved_forms)) {
      $available_crusaders[$crusader->hero_id] = $user_info->crusaders[$crusader->hero_id];
      $available_crusaders[$crusader->hero_id]->properties = new \stdClass();
      $available_crusaders[$crusader->hero_id]->properties->tags = new \stdClass();
      if (isset($crusaders_with_skins[$crusader->hero_id])) {
        $available_crusaders[$crusader->hero_id]->properties->tags = $crusaders_with_skins[$crusader->hero_id];
      } else {
        $available_crusaders[$crusader->hero_id]->properties->tags = $game_defines->crusaders[$crusader->hero_id]->properties->tags;
      }
    }
  }
  $missions = array();
  foreach ($user_info->missions['available_missions'] as $available_missions) {
    $missions[] = new Mission($game_defines->missions[$available_missions->mission_id]);
  }
  $mission_suggestions = '';
  foreach ($missions AS $mission) {
    $mission_crusaders = array();
    foreach($available_crusaders AS $available_crusader) {
      $tags = array();
      $matching_tags_count = 0;
      foreach ($available_crusader->properties->tags AS $tag) {
        if (in_array($tag, $mission->required_tags)) {
          $tags[] = $tag;
          $matching_tags_count++;
        } else {
          $tags[] = $tag;
        }
      }
      $crusader_loot = array(1=>0, 2=>0, 3=>0);
      $user_info->generate_crusader_loot($game_defines);
      foreach ($user_info->crusader_loot[$available_crusader->hero_id] AS $loot) {
        $crusader_loot[$loot->slot_id] = $loot->rarity;
      }
      $mission_crusaders[$available_crusader->hero_id] = array('matching_tags' => $matching_tags_count,
                                                               'enchantment_points' => $available_crusader->disenchant,
                                                               'crusader' => $available_crusader,
                                                               'id' => $available_crusader->hero_id,
                                                               'loot' => $crusader_loot,
                                                               'tags' => $tags);
    }
    $simulation = new Simulation($mission);
    $runs = $simulation->run_search($mission_crusaders, $_POST['seconds_to_simulate']);
    $crusader_names = array();
    foreach ($simulation->results[0] AS $crusader_id) {
      $crusader_names[] = $game_defines->crusaders[$crusader_id['id']]->name;
    }
    sort($crusader_names);
    $mission_suggestions .= '<div style="float: left; clear: both;"><b>' . $mission->name . '</b> will result in ' . $simulation->high_score . '% chance of success with the following crusaders: ';
    $mission_crusader_names = '';
    foreach ($crusader_names AS $crusader_name) {
      $mission_crusader_names .= $crusader_name . ', ';
    }
    $mission_suggestions .= trim($mission_crusader_names, ', ') . '</div>';
  }
}

class Mission {
  function __construct($mission) {
    $this->id = $mission->id;
    $this->base_success = $mission->base_success;
    $this->name = $mission->name;
    $this->description = $mission->description;
    $this->slots = $mission->slots;
    if (isset($mission->required_tags)) {
      $this->required_tags = $mission->required_tags;
    } else {
      $this->required_tags = array();
    }
    if (isset($mission->reward)) {
      $this->reward = $mission->reward;
    } else {
      $this->reward = array();
    }
    if (isset($mission->properties)) {
      $this->properties = $mission->properties;
    } else {
      $this->properties = array();
    }
    if (isset($mission->properties->gear_check)) {
      $this->gear_check = $mission->properties->gear_check;
    } else {
      $this->gear_check = null;
    }
    if (isset($mission->properties->high_level)) {
      $this->high_level = $mission->properties->high_level;
    } else {
      $this->high_level = null;
    }
    if (isset($mission->properties->required_level)) {
      $this->required_level = $mission->properties->required_level;
    } else {
      $this->required_level = array();
    }
    $success_needed = 100 - $this->base_success;
    $divisor = 1;
    if (isset($this->gear_check) && isset($this->high_level)) {
      $divisor = 3;
    } else if (isset($this->gear_check) || isset($this->high_level)) {
      $divisor = 2;
    }
    $this->tag_success = $success_needed / $divisor / count($this->required_tags);
    if (isset($this->gear_check)) {
      //This is how much a common item gives, will modify it in the score eval to handle higher level gear
      $this->gear_success = $success_needed / $divisor / (3 * $this->slots) / 8;
    }
    if (isset($this->high_level)) {
      $this->level_success = $success_needed / $divisor / $this->slots / $this->required_level;
    }
  }

  public function evaluate_mission_score($crusaders) {
    $score = 100;
    $missing_ep = 0;
    $gear_points = 0;
    $needed_tags = $this->required_tags;
    $crusader_tags = array();
    $needed_tag_count = array();
    foreach ($needed_tags AS $tag) {
      if (!empty($needed_tag_count[$tag])) {
        $needed_tag_count[$tag] += 1;
      } else {
        $needed_tag_count[$tag] = 1;
      }
    }
    foreach ($crusaders AS $crusader) {
      foreach($crusader['tags'] AS $tag) {
        if (!empty($crusader_tags[$tag])) {
          $crusader_tags[$tag] += 1;
        } else {
          $crusader_tags[$tag] = 1;
        }
      }
      if (!empty($this->properties->required_level)) {
        $missing_ep = max(($this->properties->required_level - $crusader['enchantment_points']), 0);
      }
      if (!empty($this->properties->gear_check)) {
        $gear_points = 0;
        foreach ($crusader['loot'] AS $crusader_loot) {
          $gear_points += $this->gear_success * pow(2, min(($crusader_loot - 1), 3));
        }
      }
    }
    //This adjusts the score based on how many tags are missing from the required tags
    $tag_diff = 0;
    foreach ($needed_tag_count AS $needed_tag => $number_of_tag) {
      if (empty($crusader_tags[$needed_tag])) {
        $tag_diff += $number_of_tag;
      } else {
        if ($crusader_tags[$needed_tag] < $number_of_tag) {
          $tag_diff += $number_of_tag - $crusader_tags[$needed_tag];
        }
      }
    }
    $score -= $tag_diff * $this->tag_success;
    //This adjusts the score based on how much ep the crusaders are missing
    if (!empty($this->properties->required_level)) {
      $score -= $missing_ep * $this->level_success;
    }
    //This adjusts the score based on missing gear levels
    if (!empty($this->properties->gear_check)) {
      $score -= ($this->gear_success * 8 * 3) - $gear_points;
    }
    return $score;
  }
}

class Simulation {
  function __construct($mission) {
    $this->mission = $mission;
    $this->results = array();
    $this->high_score = 0;
  }

  /** From given crusaders, repeatedly run simulations until timeout */
  public function run_search($crusaders, $timeout = 1) {
    if ($timeout > 5) {
      $timeout = 5;
    }
    $end = microtime(true) + $timeout;
    $total_sims = 0;
    while (microtime(true) < $end) {
      $test_mission_keys = array_rand($crusaders, $this->mission->slots);
      $test_mission = array();
      foreach ($test_mission_keys AS $id) {
        $test_mission[] = $crusaders[$id];
      }
      $test_mission_score = $this->mission->evaluate_mission_score($test_mission);
      if ($test_mission_score > $this->high_score) {
        $this->results = array();
        $this->results[] = $test_mission;
        $this->high_score = $test_mission_score;
      } else if ($test_mission_score == $this->high_score) {
        $this->results[] = $test_mission;
      }
      $total_sims++;
    }
    return $total_sims;
  }
}

?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="color: red;">This is still in beta! I will be adding more features as time goes on, if you get results that don't make sense please let me know on discord</div>
<div>This will suggest the best options for what crusaders to send out on missions. It currently ignores the crusaders in your saved formations, and who are already on missions. It also should correctly handle the current skins you have equipped.</div>
<div> It's simulating different permutations of crusaders, so if you don't get 100% raise the time to simulate.</div>
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Seconds to Simulate(pick a number <= 5): <input type="text" name="seconds_to_simulate" value="<?php echo (isset($_POST['seconds_to_simulate']) ? htmlspecialchars($_POST['seconds_to_simulate']) : .1); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (!empty($mission_suggestions)) {
  echo $mission_suggestions;
}
?>

