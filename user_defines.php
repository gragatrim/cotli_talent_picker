<?php

class UserDefines {
  function __construct($server, $user_id, $user_hash, $raw_user_data) {
    if (empty($raw_user_data)) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://" . urlencode($_POST['server']) . ".djartsgames.ca/~idle/post.php?call=getUserDetails&instance_key=0&user_id=" . urlencode($_POST['user_id']) . "&hash=" . urlencode($_POST['user_hash']));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

      $response = curl_exec($ch);
      $json_response = json_decode($response);
      if (!empty($json_response->switch_play_server)) {
        $curl_url = $json_response->switch_play_server;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl_url . "post.php?call=getUserDetails&instance_key=0&user_id=" . urlencode($_POST['user_id']) . "&hash=" . urlencode($_POST['user_hash']));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        $response = curl_exec($ch);
        $json_response = json_decode($response);
      }
      if (empty($json_response) || $json_response->success != true) {
        error_log("curl_error: " . curl_error($ch), 0);
        error_log("json_response: " . $response, 0);
      }
      curl_close($ch);
    } else {
      $json_response = json_decode ("{}");
      $json_response->details = json_decode($raw_user_data);
    }
    debug($json_response);
    die();
    $this->user_json = $json_response->details;
    $this->loot = $this->get_loot();
    $this->taskmasters = $this->get_taskmasters();
    $this->crusaders = $this->get_crusaders();
    $this->unspent_idols = $json_response->reset_currency;
    $this->spent_idols = $json_response->reset_currency_spent;
    $this->generate_crusader_loot();
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
    $this->campaign_formations = $this->generate_campaign_maps();
  }

  public function get_loot() {
    $loot = array();
    foreach($this->user_json->loot AS $id => $item) {
      $loot[$item->id] = $item;
    }
    return $loot;
  }

  public function get_taskmasters() {
    $taskmasters = array();
    foreach($this->user_json->taskmasters->taskmasters AS $id => $taskmaster) {
      $taskmasters[$taskmaster->id] = $taskmaster;
    }
    return $taskmasters;
  }

  public function get_crusaders() {
    $crusaders = array();
    foreach($this->user_json->heroes AS $hero) {
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

