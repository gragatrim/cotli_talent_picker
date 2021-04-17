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
    if (!empty($this->json_response->failure_reason)) {
      echo "You most likely entered an incorrect userid/hash, please go back and confirm your entry<br>";
      die();
    }
    $this->user_json = $json_response->details;
    $this->all_season_data = $this->user_json->seasons;
    $this->instance_id = $this->user_json->instance_id;
    $this->crafting_materials = $this->user_json->crafting_materials;
    $this->reset_currency_spent = $this->user_json->reset_currency_spent;
    $this->reset_currency = $this->user_json->reset_currency;
    $this->taskmasters = $this->get_taskmasters();
    $this->talents = $this->get_talents();
    //For some reason the raw json and the data pulled directly from CNE differs.......
    if (!empty($raw_user_data)) {
      $this->can_buy_olympian = $this->user_json->objective_status[852]->complete;
    } else {
      $this->can_buy_olympian = $this->user_json->objective_status[825]->complete;
    }
    if (!empty($raw_user_data)) {
      $this->can_buy_newt = $this->user_json->objective_status[854]->complete;
    } else {
      $this->can_buy_newt = $this->user_json->objective_status[827]->complete;
    }
    $this->loot = $this->get_loot();
    $this->buffs = $this->get_buffs();
    $crusader_info = $this->get_crusaders();
    $this->crusaders = $crusader_info['crusaders'];
    $this->total_ep = $crusader_info['total_ep'];
    $this->number_owned_crusaders = $crusader_info['number_owned_crusaders'];
    $this->chests = $this->get_chests();
    $this->stats = $this->get_stats();
    $this->skins = $this->get_skins();
    $this->formation_saves = $this->get_formation_saves();
    $this->abilities = $this->get_abilities();
    $this->missions = $this->get_missions();
    $this->owned_crafting_recipes = $this->get_owned_crafting_recipes();
    $this->total_gems = $this->get_total_level_one_gem_value();
    $this->total_gems_available = $this->get_total_level_one_gem_value_available();
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
    $return = array();
    $return['total_ep'] = 0;
    $return['number_owned_crusaders'] = 0;
    $return['crusaders'] = array();
    foreach($this->user_json->heroes AS $hero) {
      $return['crusaders'][$hero->hero_id] = $hero;
      if (isset($this->assigned_gems[$hero->hero_id])) {
        $return['crusaders'][$hero->hero_id]->gems = $this->assigned_gems[$hero->hero_id];
      } else {
        $return['crusaders'][$hero->hero_id]->gems = array();
      }
      if ($hero->owned == 1) {
        $return['total_ep'] += $hero->disenchant;
        $return['number_owned_crusaders'] += 1;
      }
    }
    return $return;
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

  public function get_total_level_one_gem_value() {
    $total_gems = array();
    foreach ($this->user_json->gems->owned AS $gem_id => $gem_info) {
      $total_gems[$gem_id] = 0;
      foreach ($gem_info AS $level => $gems) {
        $total_gems[$gem_id] += pow(2, ($level - 1)) * $gems;
      }
    }
    return $total_gems;
  }

  public function get_total_level_one_gem_value_available() {
    $total_gems_available = $this->total_gems;
    foreach ($this->user_json->gems->assigned AS $hero_id => $runes_info) {
      foreach ($runes_info AS $rune_slot => $gem_data) {
          $total_gems_available[$gem_data->gem_id] -= pow(2, ($gem_data->level - 1));
      }
    }
    return $total_gems_available;
  }

  public function generate_crusader_loot($game_defines) {
    $this->crusader_loot = array();
    foreach ($this->crusaders AS $crusader) {
      if (empty($game_defines->crusader_loot[$crusader->hero_id])) {
        continue;
      }
      foreach ($game_defines->crusader_loot[$crusader->hero_id] AS $crusader_loot_slot) {
        foreach ($crusader_loot_slot AS $slot_id => $crusader_loot) {
          if (!empty($this->loot[$crusader_loot->id])) {
            $this->crusader_loot[$crusader->hero_id][$crusader_loot->slot_id] = $crusader_loot;
          }
        }
      }
    }
  }
}
?>

