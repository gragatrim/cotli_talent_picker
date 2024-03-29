<?php

class GameDefines {
  function __construct($force_refresh = false, $use_dev_info = false) {
    if (!file_exists('game_defines') || time() - filemtime('game_defines') > 24 * 3600 || $force_refresh !== false || $use_dev_info !== false) {
      $game_info = call_cne('idlemaster', '', '', 'getDefinitions', '');
      $dev_info = call_cne('dev2', '', '', 'getDefinitions', '');
      file_put_contents('game_defines', $game_info);
      file_put_contents('dev_defines', $dev_info);
    } else {
      $game_info = file_get_contents('game_defines');
      $dev_info = file_get_contents('dev_defines');
    }
    if ($use_dev_info !== false) {
      $game_info = $dev_info;
    }
    $this->game_json = json_decode($game_info);
    $this->loot = $this->get_loot();
    $this->golden_gear = $this->get_golden_gear();
    $this->buffs = $this->get_buffs();
    $this->quests = $this->get_quests();
    $this->generate_crusader_loot();
    $crusader_info = $this->get_crusaders();
    $this->crusaders = $crusader_info['crusaders'];
    $this->crusaders_in_seat_order = $this->sort_crusaders_by_seat();
    $this->max_bonus_training_level = ($crusader_info['max_seat_id'] - 1);
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
    $this->gems = $this->get_gems();
    $this->crafting_materials = $this->get_crafting_materials();
    $this->set_hero_gem_slots();
    $this->hero_gem_effects = $this->get_hero_gem_effects();
    $this->hero_gem_scaling = $this->get_hero_gem_scaling();
  }

  public function get_loot() {
    $loot = array();
    foreach($this->game_json->loot_defines AS $id => $item) {
      $loot[$item->id] = $item;
    }
    return $loot;
  }

  public function get_golden_gear() {
    $golden_gear = array();
    foreach($this->game_json->loot_defines AS $id => $item) {
      if ($item->golden != 0) {
        $golden_gear[$item->hero_id][$item->slot_id][$item->rarity] = $item;
      }
    }
    return $golden_gear;
  }

  public function get_buffs() {
    $buff = array();
    foreach($this->game_json->buff_defines AS $id => $item) {
      $buff[$item->id] = $item;
    }
    return $buff;
  }

  public function get_crusaders() {
    $return = array('crusaders' => array(), 'max_seat_id' => 0);
    $crusaders = array();
    $max_seat_id = 0;
    foreach($this->game_json->hero_defines AS $hero) {
      $crusaders[$hero->id] = $hero;
      if ($max_seat_id < $hero->seat_id) {
        $max_seat_id = $hero->seat_id;
      }
    }
    $return['crusaders'] = $crusaders;
    $return['max_seat_id'] = $max_seat_id;
    return $return;
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
      if (!empty($talent->effects[0]->multiplicative)) {
        $damage_type = '*';
      } else {
        $damage_type = '+';
      }
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
      if ($objective->campaign_order == 100 || $objective->campaign_order == 101) {
        if ($objective->name == 'All the Shapes') {
          $campaign_formations[$objective->id]['name'] = $objective->name;
          foreach ($objective->game_changes[3]->formation AS $id => $node) {
            if ($node->x !== 0 && $node->y != 0) {
              $campaign_formations[$objective->id][$id]['x'] = $node->x;
              $campaign_formations[$objective->id][$id]['y'] = $node->y;
            }
          }
        } else if ($objective->name == 'Top to Bottom') {
          $campaign_formations[$objective->id]['name'] = $objective->name;
          foreach ($objective->game_changes[1]->formation AS $id => $node) {
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

  public function get_crafting_materials() {
    $crafting_materials = array();
    foreach($this->game_json->crafting_material_defines AS $crafting_material) {
      $crafting_materials[$crafting_material->crafting_material_id] = $crafting_material;
    }
    return $crafting_materials;
  }

  public function get_gems() {
    $gems = array();
    if (isset($this->game_json->gem_defines)) {
      foreach($this->game_json->gem_defines AS $gem) {
        $gems[$gem->id] = $gem;
      }
    }
    return $gems;
  }

  public function set_hero_gem_slots() {
    $this->hero_gem_slots = array();
    if (isset($this->game_json->hero_gem_slot_defines)) {
      foreach($this->game_json->hero_gem_slot_defines AS $hero_gem_slot) {
        $this->hero_gem_slots[$hero_gem_slot->hero_gem_slot_id] = $hero_gem_slot;
        $this->crusaders[$hero_gem_slot->hero_id]->hero_gem_slots[$hero_gem_slot->slot_id] = $hero_gem_slot;
      }
    }
  }

  public function get_hero_gem_effects() {
    $hero_gem_effects = array();
    if (isset($this->game_json->hero_gem_effect_defines)) {
      foreach($this->game_json->hero_gem_effect_defines AS $hero_gem_effect) {
        $hero_gem_effects[$hero_gem_effect->id] = $hero_gem_effect;
      }
    }
    return $hero_gem_effects;
  }

  public function get_hero_gem_scaling() {
    $hero_gem_scalings = array();
    if (isset($this->game_json->hero_gem_scaling_defines)) {
      foreach($this->game_json->hero_gem_scaling_defines AS $hero_gem_scaling) {
        $hero_gem_scalings[$hero_gem_scaling->key] = $hero_gem_scaling->scaling;
      }
    }
    return $hero_gem_scalings;
  }

  public function sort_crusaders_by_seat() {
    $sorted_crusaders = array();
    foreach ($this->crusaders AS $crusader) {
      $sorted_crusaders[$crusader->seat_id][] = $crusader;
    }
    return $sorted_crusaders;
  }

  //The array of talents is in talents.php
  public function generate_talent_tree_table($user, $fully_implemented_talents, $partially_implemented_talents) {
    $talent_defines = array();
    $max_trees = 0;
    foreach ($this->talents AS $id => $talent) {
      if (empty($talent->properties->removed)) {
        if ($max_trees < $talent->tree) {
          $max_trees = $talent->tree;
        }
        //Their defines have multiple entries for the same position so these need to be here so that we can see all talents
        if (in_array($id, array(47, 19, 51))) {
          $talent_defines[$talent->tier][$talent->tree][($talent->tier_order - 1)] = $id;
        } else if (in_array($id, array(103, 101, 66, 65, 107, 106, 104))) {
          $talent_defines[$talent->tier][$talent->tree][($talent->tier_order + 1)] = $id;
        } else {
          $talent_defines[$talent->tier][$talent->tree][$talent->tier_order] = $id;
        }
      }
    }
    $talent_html = "<table><tr><th colspan='8'>Active</th> <th colspan='8'>Passive</th> <th colspan='8'>Utility</th></tr>";
    foreach ($talent_defines AS $tier => $talent_trees) {
      $talent_html .= "<tr>";
      for ($tree = 1; $tree <= $max_trees; $tree++) {
        for ($cells = 1; $cells < 5; $cells++) {
          if (!empty($talent_trees[$tree][$cells])) {
            $formatted_talent_name = str_replace(array(' ', '-', "'", '10', '!'), array('_', '_', '', 'ten', ''), strtolower($this->talents[$talent_trees[$tree][$cells]]->name));
            $talent_html .= "<td class='" . get_talent_implemented_css($this->talents[$talent_trees[$tree][$cells]]->id, $fully_implemented_talents, $partially_implemented_talents) . "'>" . $this->talents[$talent_trees[$tree][$cells]]->name . '</td>
            <td><input style="width:50px" type="text" name="' . $formatted_talent_name . '" id="' . $formatted_talent_name . '" value=' . $user->get_talent_value($formatted_talent_name) . '></td>';
          } else {
            $talent_html .= "<td></td><td></td>";
          }
        }
      }
      $talent_html .= "</tr>";
    }
    $talent_html .= "</table>";
    return $talent_html;
  }

  public function get_quests() {
    $quests = array();
    foreach($this->game_json->daily_quest_defines AS $id => $quest) {
      $quests[$quest->id] = $quest;
    }
    return $quests;
  }

}
?>
