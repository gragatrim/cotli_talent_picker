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
    $this->crusaders = $this->get_crusaders();
    $this->missions = $this->get_missions();
    $this->chests = $this->get_chests();
    $this->crusader_upgrades = $this->get_crusader_upgrades();
    $this->campaigns = $this->get_campaigns();
    $this->formation_abilities = $this->get_formation_abilities();
    $this->achievements = $this->get_achievements();
    $this->objectives = $this->get_objectives();
    $this->crusader_skins = $this->get_crusader_skins();
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
}

function debug($value) {
  echo '<pre>' . print_r($value, true) . '</pre>';
}
?>
