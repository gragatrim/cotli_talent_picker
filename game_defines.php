<?php

class GameDefines {
  function __construct($force_refresh = false, $use_dev_info = false) {
    if (!file_exists('game_defines') || time() - filemtime('game_defines') > 24 * 3600 || $force_refresh !== false || $use_dev_info !== false) {
      $game_definitions_ch = curl_init();
      curl_setopt($game_definitions_ch, CURLOPT_URL, "http://idleps19.djartsgames.ca/~idle/post.php?call=getDefinitions");
      curl_setopt($game_definitions_ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($game_definitions_ch, CURLOPT_RETURNTRANSFER, true );

      $game_info = curl_exec($game_definitions_ch);
      file_put_contents('game_defines', $game_info);
      curl_close($game_definitions_ch);

      $dev_definitions_ch = curl_init();
      curl_setopt($dev_definitions_ch, CURLOPT_URL, "http://dev2.djartsgames.ca/~idle/post.php?call=getDefinitions");
      curl_setopt($dev_definitions_ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($dev_definitions_ch, CURLOPT_RETURNTRANSFER, true );

      $dev_info = curl_exec($dev_definitions_ch);
      file_put_contents('dev_defines', $dev_info);
      curl_close($dev_definitions_ch);
    } else {
      $game_info = file_get_contents('game_defines');
      $dev_info = file_get_contents('dev_defines');
    }
    if ($use_dev_info !== false) {
      $game_info = $dev_info;
    }
    $this->game_json = json_decode($game_info);
    $this->loot = $this->get_loot();
    $this->generate_crusader_loot();
    $this->crusaders = $this->get_crusaders();
    $this->missions = $this->get_missions();
    $this->chests = $this->get_chests();
    $this->crusader_upgrades = $this->get_crusader_upgrades();
    $this->campaigns = $this->get_campaigns();
    $this->formation_abilities = $this->get_formation_abilities();
    $this->achievements = $this->get_achievements();
    $this->objectives = $this->get_objectives();
    $this->crusader_skins = $this->get_crusader_skins();
    $this->taskmasters = $this->get_taskmasters();
    $this->abilities = $this->get_abilities();
    $this->talents = $this->get_talents();
    $this->campaign_formations = $this->generate_campaign_maps();
  }

  public function get_loot() {
    $loot = array();
    foreach($this->game_json->loot_defines AS $id => $item) {
      $loot[$item->id] = $item;
    }
    return $loot;
  }

  public function get_crusaders() {
    $crusaders = array();
    foreach($this->game_json->hero_defines AS $hero) {
      $crusaders[$hero->id] = $hero;
    }
    return $crusaders;
  }

  public function get_missions() {
    $missions = array();
    foreach($this->game_json->mission_defines AS $mission) {
      $missions[$mission->id] = $mission;
    }
    return $missions;
  }

  public function get_chests() {
    $chests = array();
    foreach($this->game_json->chest_type_defines AS $chest) {
      $chests[$chest->id] = $chest;
    }
    return $chests;
  }

  public function get_crusader_upgrades() {
    $crusader_upgrades = array();
    foreach($this->game_json->upgrade_defines AS $upgrade) {
      $crusader_upgrades[$upgrade->id] = $upgrade;
    }
    return $crusader_upgrades;
  }

  public function get_campaigns() {
    $campaigns = array();
    foreach($this->game_json->campaign_defines AS $campaign) {
      $campaigns[$campaign->id] = $campaign;
    }
    return $campaigns;
  }

  public function get_formation_abilities() {
    $formation_abilities = array();
    foreach($this->game_json->formation_ability_defines AS $formation_ability) {
      $formation_abilities[$formation_ability->id] = $formation_ability;
    }
    return $formation_abilities;
  }

  public function get_achievements() {
    $achievements = array();
    foreach($this->game_json->achievement_defines AS $achievement) {
      $achievements[$achievement->id] = $achievement;
    }
    return $achievements;
  }

  public function get_objectives() {
    $objectives = array();
    foreach($this->game_json->objective_defines AS $objective) {
      $objectives[$objective->id] = $objective;
    }
    return $objectives;
  }

  public function get_crusader_skins() {
    $crusader_skins = array();
    foreach($this->game_json->hero_skin_defines AS $hero_skin) {
      $crusader_skins[$hero_skin->id] = $hero_skin;
    }
    return $crusader_skins;
  }

  public function generate_crusader_loot() {
    foreach ($this->loot AS $loot) {
      $this->crusader_loot[$loot->hero_id][$loot->slot_id][] = $loot;
    }
  }

  public function get_taskmasters() {
    $taskmasters = array();
    foreach($this->game_json->taskmaster_defines AS $taskmaster) {
      $taskmasters[$taskmaster->taskmaster_id] = $taskmaster;
    }
    return $taskmasters;
  }

  public function get_abilities() {
    $abilities = array();
    foreach($this->game_json->ability_defines AS $ability) {
      $abilities[$ability->id] = $ability;
    }
    return $abilities;
  }

  public function get_talents() {
    $talents = array();
    foreach($this->game_json->talent_defines AS $talent) {
      $talents[$talent->id] = $talent;
    }
    return $talents;
  }

  public function generate_campaign_maps() {
    $campaign_formations = array();
    foreach($this->campaigns AS $campaign) {
      if ($campaign->name == 'World\'s Wake') {
				//For some reason this form isn't in the defines, so I had to manually create it
        $campaign_formations[$campaign->id]['name'] =  $campaign->name;
				$campaign_formations[$campaign->id][0]['x'] = 289;
				$campaign_formations[$campaign->id][0]['y'] = 151;
				$campaign_formations[$campaign->id][1]['x'] = 203;
				$campaign_formations[$campaign->id][1]['y'] = 118;
				$campaign_formations[$campaign->id][2]['x'] = 203;
				$campaign_formations[$campaign->id][2]['y'] = 184;
				$campaign_formations[$campaign->id][3]['x'] = 123;
				$campaign_formations[$campaign->id][3]['y'] = 85;
				$campaign_formations[$campaign->id][4]['x'] = 123;
				$campaign_formations[$campaign->id][4]['y'] = 151;
				$campaign_formations[$campaign->id][5]['x'] = 123;
				$campaign_formations[$campaign->id][5]['y'] = 217;
				$campaign_formations[$campaign->id][6]['x'] = 43;
				$campaign_formations[$campaign->id][6]['y'] = 52;
				$campaign_formations[$campaign->id][7]['x'] = 43;
				$campaign_formations[$campaign->id][7]['y'] = 118;
				$campaign_formations[$campaign->id][8]['x'] = 43;
				$campaign_formations[$campaign->id][8]['y'] = 184;
				$campaign_formations[$campaign->id][9]['x'] = 43;
				$campaign_formations[$campaign->id][9]['y'] = 250;
      } else if ($campaign->name != 'The Dungeons') {
        $campaign_formations[$campaign->id]['name'] =  $campaign->name;
        foreach ($campaign->game_changes[0]->formation AS $id => $node) {
          $campaign_formations[$campaign->id][$id]['x'] = $node->x;
          $campaign_formations[$campaign->id][$id]['y'] = $node->y;
        }
      }
    }
    foreach($this->objectives AS $objective) {
      if ($objective->campaign_order == 100) {
        if ($objective->name == 'All the Shapes') {
          $campaign_formations[$objective->id]['name'] = $objective->name;
          foreach ($objective->game_changes[3]->formation AS $id => $node) {
            if ($node->x !== 0 && $node->y != 0) {
              $campaign_formations[$objective->id][$id]['x'] = $node->x;
              $campaign_formations[$objective->id][$id]['y'] = $node->y;
            }
          }
        } else {
          //These all use campaign maps, so grab the format based on campaign_id
          $campaign_formations[$objective->id]['name'] = $objective->name;
          foreach ($campaign_formations[$objective->campaign_id] AS $id => $node) {
            if ($id !== 'name') {
              $campaign_formations[$objective->id][$id]['x'] = $node['x'];
              $campaign_formations[$objective->id][$id]['y'] = $node['y'];
            }
          }
        }
      } else if ($objective->campaign_id == 29) {
        $campaign_formations[$objective->id]['name'] = $objective->name;
        foreach ($objective->game_changes[2]->formation AS $id => $node) {
          $campaign_formations[$objective->id][$id]['x'] = $node->x;
          $campaign_formations[$objective->id][$id]['y'] = $node->y;
        }
      }
    }
    return $campaign_formations;
  }
}
?>
