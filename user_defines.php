<?php

class UserDefines {
  function __construct($server, $user_id, $user_hash, $raw_user_data = '') {
    if (empty($raw_user_data)) {
      $response = call_cne($server, $user_id, $user_hash, 'getUserDetails', $parameters);
      $json_response = json_decode($response);
      if (empty($json_response) || $json_response->success != true) {
        error_log("curl_error: " . curl_error($ch), 0);
        error_log("json_response: " . $response, 0);
      }
      curl_close($ch);
    } else {
      $json_response = json_decode ("{}");
      $json_response->details = json_decode($raw_user_data);
    }
    $this->user_json = $json_response->details;
    $this->crafting_materials = $this->user_json->crafting_materials;
    $this->reset_currency_spent = $this->user_json->reset_currency_spent;
    $this->reset_currency = $this->user_json->reset_currency;
    $this->taskmasters = $this->get_taskmasters();
    $this->talents = $this->get_talents();
    $this->loot = $this->get_loot();
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
      $loot[$id] = $item;
    }
    return $loot;
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
    $crusaders = array();
    foreach($this->user_json->heroes AS $hero) {
      $crusaders[$hero->hero_id] = $hero;
    }
    return $crusaders;
  }

  public function get_missions() {
    $missions = array();
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

}
?>

