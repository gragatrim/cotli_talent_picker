<?php
include "user.php";
$user = new User();
$game_defines = new GameDefines();
if (!empty($_POST)) {
  if ($_POST['total_idols'] < 1 && (empty($_POST['user_id']) && empty($_POST['user_hash']) && empty($_POST['raw_user_data']))) {
  $user = new User();
  } else {
    set_time_limit(600);
    $talents = array();
    if (!isset($_POST['hitting_level_cap'])) {
      $_POST['hitting_level_cap'] = false;
    }
    if (!isset($_POST['ignore_impatience'])) {
      $_POST['ignore_impatience'] = false;
    }
    if (!isset($_POST['ignore_must_be_magic'])) {
      $_POST['ignore_must_be_magic'] = false;
    }
    if (!isset($_POST['ignore_front_line_fire'])) {
      $_POST['ignore_front_line_fire'] = false;
    }
    if (!isset($_POST['ignore_backline_defensive'])) {
      $_POST['ignore_backline_defensive'] = false;
    }
    $game_json = $game_defines->game_json;
    if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data'])) {
      $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
      //This allows for the math functions to work below
      $_POST['cooldown_reduction'] = 0;
      $legendaries = 0;
      $golden_items = 0;
      $loot_definition = array();
      $crusaders_owned = 0;
      $skins_owned = count($user_info->skins);
      $max_level_reached = 0;
      $common_and_uncommon_recipes = 0;
      $rare_recipes = 0;
      $epic_recipes = 0;
      $unknown_recipe = 0;
      $talent_definition = array();

      foreach($game_defines->loot AS $id => $loot) {
        if ($loot->hero_id != 0) {
          $loot_definition[$loot->id] = $loot;
        }
      }
      foreach($game_defines->talents AS $id => $talent) {
        $talent_definition[$talent->id] = $talent->name;
      }

      $loweset_epic_trinket_count = INF;
      foreach ($user_info->loot AS $loot) {
        //1 is brass rings, 245 primitive amulet, 249 wooden horn, 253 wooden lucky coin
        switch ($loot->loot_id) {
          case 1:
            $_POST['brass_rings'] = $loot->count;
            break;
          case 2:
            $_POST['silver_rings'] = $loot->count;
            break;
          case 3:
            $_POST['golden_rings'] = $loot->count;
            break;
          case 4:
            $_POST['diamond_rings'] = $loot->count;
            break;
          case 249:
            $_POST['cooldown_reduction'] += ($loot->count * .5);
            break;
          case 250:
            $_POST['cooldown_reduction'] += $loot->count;
            break;
          case 251:
            $_POST['cooldown_reduction'] += ($loot->count * 1.5);
            break;
          case 252:
            $_POST['cooldown_reduction'] += ($loot->count * 2);
            break;
        }
        if (!empty($loot_definition[$loot->loot_id]) && $loot_definition[$loot->loot_id]->rarity == 5) {
          $legendaries++;
        }
        if (!empty($loot_definition[$loot->loot_id]) && $loot_definition[$loot->loot_id]->golden == 1) {
          $golden_items++;
        }
        if (in_array($loot->loot_id, array(4, 248, 252, 256))) {
          if ($loweset_epic_trinket_count > $loot->count) {
            $loweset_epic_trinket_count = $loot->count;
          }
        }
      }

      foreach ($user_info->owned_crafting_recipes AS $recipes_key => $recipes_value) {
        if ($loot_definition[$recipes_value]->rarity < 3) {
          $common_and_uncommon_recipes++;
        } else if ($loot_definition[$recipes_value]->rarity == 3) {
          $rare_recipes++;
        } else if ($loot_definition[$recipes_value]->rarity == 4 && $loot_definition[$recipes_value]->golden == 0) {
          $epic_recipes++;
        } else if($loot_definition[$recipes_value]->rarity == 5) {
          $legendaries++;
        } else {
          //Not used, maybe do something with this in the future? Should never really be reached
          $unknown_recipe++;
        }
      }
      foreach ($user_info->stats AS $stat_name => $stat_value) {
        if (strpos($stat_name, 'highest_area_completed_ever_c') !== false) {
          if ($max_level_reached < $stat_value) {
            $max_level_reached = $stat_value;
          }
        }
      }
      foreach ($user_info->crusaders AS $hero) {
        if ($hero->owned == 1) {
          $crusaders_owned++;
        }
      }

      $_POST['missions_accomplished'] = 0;
      if (!empty($user_info->stats['missions_completed'])) {
        $_POST['missions_accomplished'] = $user_info->stats['missions_completed'];
      }
      $_POST['total_idols'] = sprintf('%.0f', $user_info->reset_currency) + sprintf('%.0f', $user_info->reset_currency_spent);
      $_POST['common_and_uncommon_recipes'] = $common_and_uncommon_recipes/2;
      $_POST['rare_recipes'] = $rare_recipes;
      $_POST['epic_recipes'] = $epic_recipes;
      $_POST['legendaries'] = $legendaries;
      $_POST['golden_items'] = $golden_items;
      $_POST['max_level_reached'] = $max_level_reached;
      $_POST['taskmasters_owned'] = count($user_info->taskmasters);
      $_POST['crusaders_owned'] = $crusaders_owned;
      $_POST['skins_owned'] = $skins_owned;
      $_POST['lowest_epic_trinket_count'] = $loweset_epic_trinket_count;
      $material_info = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials);
      $total_mats = $material_info[0];
      //If they are passing in their user data, we should reset this and regenerate it
      $_POST['total_legendary_levels_on_all_gear'] = 0;
      foreach ($material_info[1] AS $gear_level => $levels) {
        $_POST['total_legendary_levels_on_all_gear'] += ($levels * $gear_level);
      }
      $total_mat_div = '<div style="float: left; clear: left;">Total Materials(including epic mats): ' . $total_mats . '</div>';
      $material_info_with_chests = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials, true, $user_info->chests, $game_defines->chests);
      $total_mats_with_chests = $material_info_with_chests[0];
      $total_mat_div_with_chests = '<div style="float: left; clear: left;">Total Materials(including epic mats and all unopened chests): ' . $total_mats_with_chests . '</div>';
    }
    $talents_to_generate = array();
    foreach ($game_defines->talents AS $id => $talent) {
      if (!empty($talent->properties->removed)) {
        continue;
      }
      if (!empty($user_info->talents[$id])) {
        $talents_to_generate[$id] = $user_info->talents[$id];
      } else {
        $formatted_talent_name = str_replace(array(' ', '-', "'", '10', '!'), array('_', '_', '', 'ten', ''), strtolower($talent->name));
        //If they are using userid/hash, so we should 0 out all talents and ignore the post data
        $user_talent_levels = 0;
        if (empty($user_info->talents)) {
          //They aren't using user_id/hash, so lets use the data they entered in
          if (!empty($_POST[$formatted_talent_name])) {
            $user_talent_levels = $_POST[$formatted_talent_name];
          }
        }
        $talents_to_generate[$id] = $user_talent_levels;
      }
    }
    foreach ($talents_to_generate AS $talent_id => $talent_levels) {
      if (!isset($game_defines->talents[$talent_id])
       || !empty($game_defines->talents[$talent_id]->properties->removed)) {
        continue;
      }
      $talent = $game_defines->talents[$talent_id];
      $formatted_talent_name = str_replace(array(' ', '-', "'", '10', '!'), array('_', '_', '', 'ten', ''), strtolower($game_defines->talents[$talent_id]->name));
      $_POST[$formatted_talent_name] = $talent_levels;
      $damage_type = '+';
      $level_multiplier = 1;
      $damage_base_multiplier = 0;
      $damage_base = 0;
      $stacks = 0;
      $main_dps_slot = 0;
      if (!empty($talent->effects[0]->base_amount)){
        $damage_base = $talent->effects[0]->base_amount;
        $damage_base_multiplier = $talent->effects[0]->per_level;
      } else if(!empty($talent->effects[0]->per_level)) {
        $damage_base = $talent->effects[0]->per_level;
        $damage_base_multiplier = $damage_base;
      }
      //Just bossing around
      if (empty($talent->cost->base_cost)) {
        $base_cost = $talent->cost->level_costs[1];
        $level_costs = $talent->cost->level_costs;
      } else {
        $base_cost = $talent->cost->base_cost;
        $level_costs = array();
      }
      if (!empty($talent->cost->factor)) {
        $level_multiplier = $talent->cost->factor;
      }
      if ((!empty($talent->effects) && !empty($talent->effects[0]->multiplicative))
        || in_array($formatted_talent_name, array('dressing_for_success', 'trinket_hoarder', 'synergy', 'kilo_leveling', 'idolatry', 'maxed_power', 'legendary_friendship', 'golden_friendship', 'friendly_helpers', 'extra_training', 'superior_training', 'tenk_training', 'bonus_training', 'montage_training', 'magical_training', 'olympian_training', 'legendary_hoards'))){
        $damage_type = '*';
      }
      //I'm using a hardcoded table of costs to deal with arith
      if ($formatted_talent_name == 'arithmagician') {
        $level_multiplier = 'arithmagician';
      }
      if ($formatted_talent_name == 'bonus_training') {
        $main_dps_slot = htmlspecialchars($_POST['main_dps_slot']);
      }
      if ($talent_levels > 0) {
        $stacks = $talent_levels;
        if ($formatted_talent_name == 'trinket_hoarder') {
          //need 1 more than trinket sets for this for the math to check out
          $stacks = floor($_POST['lowest_epic_trinket_count']/20) + 1;
          $damage_base_multiplier = $talent_levels;
        }
        if ($formatted_talent_name == 'legendary_hoards') {
          $stacks = $_POST['total_legendary_levels_on_all_gear'];
        }
        if ($formatted_talent_name == 'dressing_for_success') {
          if (!empty($user_info->skins)) {
            $skins_owned = count($user_info->skins);
          } else {
            $skins_owned = htmlspecialchars($_POST['skins_owned']);
          }
          //need 1 more than skins owned for this for the math to check out
          $stacks = $skins_owned + 1;
        }
        if ($formatted_talent_name == 'legendary_benefits') {
          $stacks = htmlentities($_POST['legendaries']);
        }
        if ($formatted_talent_name == 'legendary_friendship') {
          $damage_base_multiplier = htmlentities($_POST['legendary_friendship']);
          $stacks = htmlentities($_POST['main_dps_benched_crusaders_legendaries']);
        }
        if ($formatted_talent_name == 'golden_friendship') {
          $damage_base_multiplier = htmlentities($_POST['golden_friendship']);
          $stacks = htmlentities($_POST['main_dps_benched_crusaders_golden_gear']);
        }
        if ($formatted_talent_name == 'friendly_helpers') {
          $damage_base_multiplier = htmlentities($_POST['friendly_helpers']);
          $stacks = htmlentities($_POST['taskmasters_owned']);
        }
        if ($formatted_talent_name == 'mission_adrenaline') {
          $damage_base_multiplier = htmlspecialchars($_POST['missions_accomplished']) / 100;
        }
        if ($formatted_talent_name == 'cheer_squad') {
          $stacks = htmlspecialchars($_POST['crusaders_owned']) - htmlspecialchars($_POST['crusaders_in_formation']);
        }
        if ($formatted_talent_name == 'every_little_bit_helps') {
          $damage_base_multiplier = 1;
        }
        if ($formatted_talent_name == 'surplus_cooldown') {
          $damage_base /= 100;
          $damage_base_multiplier = (htmlspecialchars($_POST['cooldown_reduction']) - 50);
        }
        if ($formatted_talent_name == 'idolatry') {
          $damage_base_multiplier = htmlspecialchars($_POST['idolatry']);
          $stacks = floor(log(htmlspecialchars($_POST['total_idols']), 10));
        }
        if ($formatted_talent_name == 'maxed_power') {
          $damage_base_multiplier = htmlspecialchars($_POST['maxed_power']);
        }
        if ($formatted_talent_name == 'apprentice_crafter') {
          $stacks = htmlspecialchars($_POST['common_and_uncommon_recipes']) * 2;
        }
        if ($formatted_talent_name == 'golden_benefits') {
          $stacks = htmlspecialchars($_POST['golden_items']);
        }
        if ($formatted_talent_name == 'journeyman_crafter') {
          $stacks = htmlspecialchars($_POST['rare_recipes']);
        }
        if ($formatted_talent_name == 'master_crafter') {
          $stacks = htmlspecialchars($_POST['epic_recipes']);
        }
        if ($formatted_talent_name == 'passive_criticals') {
          $stacks = htmlspecialchars($_POST['critical_chance']);
        }
        if ($formatted_talent_name == 'overenchanted') {
          $stacks = htmlspecialchars($_POST['ep_from_main_dps']);
          $damage_base_multiplier = .05;
        }
        if ($formatted_talent_name == 'well_equipped') {
          $stacks = htmlspecialchars($_POST['epics_on_main_dps']);
        }
        if ($formatted_talent_name == 'swap_day') {
          $stacks = htmlspecialchars($_POST['epics_on_benched_crusaders']);
        }
        if ($formatted_talent_name == 'golden_age') {
          $stacks = exp2int($_POST['gold_bonus_provided_by_crusaders']);
        }
        if ($formatted_talent_name == 'set_bonus') {
          $stacks = 1;
        }
        if ($formatted_talent_name == 'mission_accomplished') {
          $stacks = htmlspecialchars($_POST['missions_accomplished']);
        }
      }
      $talent_object = new Talent($talent_id, $formatted_talent_name, $talent->tier, $talent->num_levels, $base_cost, $level_multiplier, $talent_levels,
                                  $damage_type, $damage_base, $damage_base_multiplier, $stacks, $main_dps_slot, $level_costs);
      $talents[$formatted_talent_name] = $talent_object;
    }

    if (!empty($user_info)) {
      $_POST['can_buy_olympian'] = $user_info->can_buy_olympian;
      $_POST['can_buy_newt'] = $user_info->can_buy_newt;
    } else {
      $_POST['can_buy_olympian'] = 0;
      $_POST['can_buy_newt'] = 0;
    }
    $user = new User($_POST, $talents);
    $user->talents['maxed_power']->stacks = $user->talents_at_max;
    $user->talents['level_all_the_way']->stacks = $user->total_talent_levels;
    if ($user->hitting_level_cap != false) {
      $user->talents['kilo_leveling']->stacks = floor($user->main_dps_max_levels/1000);
    }
    $base_damage = 1;
    if (!empty($user_info)) {
      echo "total idols spent " . number_format(sprintf('%.0f', $user_info->reset_currency_spent)) . " total idols remaining: " . number_format(sprintf('%.0f', $user_info->reset_currency)) . "<br>";
    }
    if (!empty($total_mat_div)) {
      echo $total_mat_div;
    }
    if (!empty($total_mat_div_with_chests)) {
      echo $total_mat_div_with_chests;
    }
    $results_legend = '<div class="green">Green means you can afford it</div><div class="yellow">Yellow means your leftover idols can afford it</div><div class="red">Red means you can\'t afford it</div>';
    $results_to_print = '<div style="float: right;clear: both;">Final damage is current damage + green suggestions, future damage adds the increase from yellow talent suggestions</div><div style="float: right; clear: right;">' . $results_legend . '<div style="float: right;clear: both;">Final Damage ' . format(bcsub($user->get_total_damage(), 40)) . "% Increase<br>";
    //This is here to make a copy of the object so we aren't still accessing things by reference
    
    $future_talents_user = unserialize(serialize($user));
    $talents_to_buy = '';
    $future_damage = $future_talents_user->get_total_damage();
    for ($i = 0; $i < $user->talents_to_recommend; $i++) {
      $talent_to_buy = $future_talents_user->get_next_talent_to_buy();
      $future_idols_remaining = bcsub($future_talents_user->total_idols, $future_talents_user->get_total_talent_cost());
      //Going to use this to keep track of leftover idols after making the larger idol purchases so you can spend the remainder if you want
      if (!isset($leftover_idols)) {
        $leftover_idols = $future_idols_remaining;
      } else if ($future_idols_remaining >= 0) {
        $leftover_idols = $future_idols_remaining;
      }
      if (empty($talent_to_buy)) {
        $talents_to_buy .= "No talent found!<br>";
        break;
      } else {
        $color = "red";
        $next_talent_cost = $future_talents_user->talents[$talent_to_buy]->get_cost_at_level($future_talents_user->talents[$talent_to_buy]->current_level);
        $future_talents_user->update($talent_to_buy);
        if ($next_talent_cost <= ($future_idols_remaining)) {
          $color = "green";
          $future_damage = $future_talents_user->get_total_damage();
        } else if ($next_talent_cost <= $leftover_idols) {
          $color = "yellow";
          $leftover_idols -= $next_talent_cost;
          $future_damage = $future_talents_user->get_total_damage();
        }
        $talents_to_buy .= '<div style="clear: right; background: ' . $color . ';">Talent to buy: ' . $talent_to_buy . '</div>';
      }
    }
    $results_to_print .= "Future Damage " . format(bcsub($future_damage, 40)) . "% Increase<br>" . $talents_to_buy . '</div></div>';
  }
}
