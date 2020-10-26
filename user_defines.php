<?php

class UserDefines {
  function __construct($server, $user_id, $user_hash, $raw_user_data = '') {
    $raw_user_data = trim($raw_user_data);
    if (empty($raw_user_data)) {
      if (empty($server)) {
        $server = 'idlemaster';
      }
      $response = call_cne($server, $user_id, $user_hash, 'getUserDetails', '&instance_key=0');
      $json_response = json_decode($response);
    } else {
      $json_response = json_decode ("{}");
      $json_response->details = json_decode($raw_user_data);
    }
    $this->json_response = $json_response;
    $this->user_json = $json_response->details;
    $this->current_season_count = count(get_object_vars($this->user_json->seasons));
    $this->current_season = $this->user_json->seasons->{$this->current_season_count}->user_data;
    $this->all_season_data = $this->user_json->seasons;
    $this->instance_id = $this->user_json->instance_id;
    $this->crafting_materials = $this->user_json->crafting_materials;
    $this->reset_currency_spent = $this->user_json->reset_currency_spent;
    $this->reset_currency = $this->user_json->reset_currency;
    $this->taskmasters = $this->get_taskmasters();
    $this->talents = $this->get_talents();
    $this->loot = $this->get_loot();
    $this->buffs = $this->get_buffs();
    $this->crusaders = $this->get_crusaders();
    $this->chests = $this->get_chests();
    $this->stats = $this->get_stats();
    $this->skins = $this->get_skins();
    $this->formation_saves = $this->get_formation_saves();
    $this->abilities = $this->get_abilities();
    $this->missions = $this->get_missions();
    $this->owned_crafting_recipes = $this->get_owned_crafting_recipes();
  }

  public function get_loot() {
    $loot = array();
    foreach($this->user_json->loot AS $id => $item) {
      $loot[$item->loot_id] = $item;
    }
    return $loot;
  }

  public function get_buffs() {
    $buffs = array();
    foreach($this->user_json->buffs AS $item) {
      $buffs[$item->buff_id] = $item;
    }
    return $buffs;
  }

  public function get_talents() {
    $talents = array();
    foreach($this->user_json->talents AS $talent_id => $levels) {
      $talents[$talent_id] = $levels;
    }
    return $talents;
  }

  public function get_taskmasters() {
    $taskmasters = array();
    foreach($this->user_json->taskmasters->taskmasters AS $id => $taskmaster) {
      $taskmasters[$taskmaster->id] = $taskmaster;
    }
    return $taskmasters;
  }

  public function get_crusaders() {
    $this->set_assigned_gems();
    $crusaders = array();
    foreach($this->user_json->heroes AS $hero) {
      $crusaders[$hero->hero_id] = $hero;
      if (isset($this->assigned_gems[$hero->hero_id])) {
        $crusaders[$hero->hero_id]->gems = $this->assigned_gems[$hero->hero_id];
      } else {
        $crusaders[$hero->hero_id]->gems = array();
      }
    }
    return $crusaders;
  }

  public function get_missions() {
    $missions = array('available_missions' => []);
    foreach($this->user_json->mission_data AS $id => $mission) {
      if (is_array($mission)) {
        foreach ($mission AS $mission_info) {
          $missions[$id][$mission_info->mission_id] = $mission_info;
        }
      } else {
        $missions[$id] = $mission;
      }
    }
    return $missions;
  }

  public function get_chests() {
    $chests = array();
    $chests[1] = $this->user_json->normal_loot_chests;
    $chests[2] = $this->user_json->rare_loot_chests;
    foreach($this->user_json->chests AS $id => $chest) {
      $chests[$id] = $chest;
    }
    return $chests;
  }

  public function get_stats() {
    $stats = array();
    foreach($this->user_json->stats AS $stat => $value) {
      $stats[$stat] = $value;
    }
    return $stats;
  }

  public function get_formation_saves() {
    $formation_saves = array();
    foreach($this->user_json->formation_saves AS $formation_type => $formation_save) {
      $formation_saves[$formation_type] = $formation_save;
    }
    return $formation_saves;
  }

  public function get_abilities() {
    $abilities = array();
    foreach($this->user_json->abilities AS $ability) {
      $abilities[$ability->ability_id] = $ability;
    }
    return $abilities;
  }

  public function get_owned_crafting_recipes() {
    $owned_crafting_recipes = array();
    foreach($this->user_json->owned_crafting_recipes AS $id => $owned_crafting_recipe) {
      $owned_crafting_recipes[$id] = $owned_crafting_recipe;
    }
    return $owned_crafting_recipes;
  }

  public function get_skins() {
    $skins = array();
    foreach($this->user_json->skins->skins AS $hero_skin) {
      $skins[$hero_skin->id] = $hero_skin;
    }
    return $skins;
  }

  private function set_assigned_gems() {
    $this->assigned_gems = array();
    foreach($this->user_json->gems->assigned AS $crusader_id => $crusader_gems) {
      $this->assigned_gems[$crusader_id] = $crusader_gems;
    }
  }

}
?>

