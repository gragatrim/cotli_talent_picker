<?php
include "user.php";

if (!empty($_POST) || !empty($user)) {
  set_time_limit(600);
  $talents = array();
  //This is an attempt to help with larger idol totals, e17+
  $_POST['idolatry_total_idols'] = 0;
  $game_defines = new GameDefines();
  $game_json = $game_defines->game_json;
  if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server']) || !empty($_POST['raw_user_data'])) {
    $user_info = new UserDefines($_POST['server'], $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
    //This allows for the math functions to work below
    $_POST['cooldown_reduction'] = 0;
    $legendaries = 0;
    $golden_items = 0;
    $loot_definition = array();
    $crusaders_owned = 0;
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
    }
    foreach ($user_info->talents AS $talent_id => $talent_levels) {
      if ($talent_levels > 0) {
        $formatted_talent_name = str_replace(array(' ', '-', "'", '10', '!'), array('_', '_', '', 'ten', ''), strtolower($talent_definition[$talent_id]));
        $_POST[$formatted_talent_name] = $talent_levels;
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

    $_POST['missions_accomplished'] = $user_info->stats['missions_completed'];
    $_POST['total_idols'] = sprintf('%.0f', $user_info->reset_currency) + sprintf('%.0f', $user_info->reset_currency_spent);
    $_POST['idolatry_total_idols'] = $_POST['total_idols'];
    $_POST['common_and_uncommon_recipes'] = $common_and_uncommon_recipes/2;
    $_POST['rare_recipes'] = $rare_recipes;
    $_POST['epic_recipes'] = $epic_recipes;
    $_POST['legendaries'] = $legendaries;
    $_POST['golden_items'] = $golden_items;
    $_POST['max_level_reached'] = $max_level_reached;
    $_POST['taskmasters_owned'] = count($user_info->taskmasters);
    $_POST['crusaders_owned'] = $crusaders_owned;
    $total_mats = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials);
    $total_mat_div = '<div style="float: left; clear: left;">Total Materials(including epic mats): ' . $total_mats . '</div>';
    $total_mats_with_chests = get_total_mats($user_info->loot, $game_defines->crusader_loot, $game_defines->loot, $user_info->crafting_materials, true, $user_info->chests, $game_defines->chests);
    $total_mat_div_with_chests = '<div style="float: left; clear: left;">Total Materials(including epic mats and all unopened chests): ' . $total_mats_with_chests . '</div>';
  }
  $time_o_rama_talent = new Talent('time_o_rama', 1, 20, 25, 1.25, htmlspecialchars($_POST['time_o_rama']));
  $talents['time_o_rama'] = $time_o_rama_talent;
  $massive_criticals_talent = new Talent('massive_criticals', 1, 25, 50, 1.25, htmlspecialchars($_POST['massive_criticals']));
  $talents['massive_criticals'] = $massive_criticals_talent;
  $golden_benefits_talent = new Talent('golden_benefits', 1, -1, 1500, 1.061, htmlspecialchars($_POST['golden_benefits']), '+', .01, htmlspecialchars($_POST['golden_items']));
  $talents['golden_benefits'] = $golden_benefits_talent;
  $super_clicks_talent = new Talent('super_clicks', 1, 25, 50, 1.1, htmlspecialchars($_POST['super_clicks']));
  $talents['super_clicks'] = $super_clicks_talent;
  $endurance_training_talent = new Talent('endurance_training', 2, 20, 50, 1.25, htmlspecialchars($_POST['endurance_training']));
  $talents['endurance_training'] = $endurance_training_talent;
  $ride_the_storm_talent = new Talent('ride_the_storm', 2, 25, 100,1.15, htmlspecialchars($_POST['ride_the_storm']));
  $talents['ride_the_storm'] = $ride_the_storm_talent;
  $storms_building_talent = new Talent('storms_building', 2, 15, 100,1.33, htmlspecialchars($_POST['storms_building']));
  $talents['storms_building'] = $storms_building_talent;
  $the_more_the_merrier_talent = new Talent('the_more_the_merrier', 2, 30, 4500,1.163, htmlspecialchars($_POST['the_more_the_merrier']));
  $talents['the_more_the_merrier'] = $the_more_the_merrier_talent;
  $gold_o_splosion_talent = new Talent('gold_o_splosion', 3, 25,500, 1.15, htmlspecialchars($_POST['gold_o_splosion']));
  $talents['gold_o_splosion'] = $gold_o_splosion_talent;
  $speed_runner_talent = new Talent('speed_runner', 3, 10, 1000, 1.63, htmlspecialchars($_POST['speed_runner']));
  $talents['speed_runner'] = $speed_runner_talent;
  $sniper_talent = new Talent('sniper', 3, 40, 200, 1.1, htmlspecialchars($_POST['sniper']));
  $talents['sniper'] = $sniper_talent;
  $higher_magnification_talent = new Talent('higher_magnification', 3, 10, 2000, 1.5, htmlspecialchars($_POST['higher_magnification']));
  $talents['higher_magnification'] = $higher_magnification_talent;
  $extended_spawns_talent = new Talent('extended_spawns', 4, 40, 10000, 1.13, htmlspecialchars($_POST['extended_spawns']));
  $talents['extended_spawns'] = $extended_spawns_talent;
  $click_tastrophe_talent = new Talent('click_tastrophe', 4, 40, 2500,1.2, htmlspecialchars($_POST['click_tastrophe']));
  $talents['click_tastrophe'] = $click_tastrophe_talent;
  $instant_satisfaction_talent = new Talent('instant_satisfaction', 4, 21, 7500,1.3333, htmlspecialchars($_POST['instant_satisfaction']));
  $talents['instant_satisfaction'] = $instant_satisfaction_talent;
  $extra_healthy_talent = new Talent('extra_healthy', 4, 50, 1500,1.305, htmlspecialchars($_POST['extra_healthy']));
  $talents['extra_healthy'] = $extra_healthy_talent;
  $mission_adrenaline_talent = new Talent('mission_adrenaline', 5, 50, 125000,1.153, htmlspecialchars($_POST['mission_adrenaline']), '+', .10, htmlspecialchars($_POST['missions_accomplished']));
  $talents['mission_adrenaline'] = $mission_adrenaline_talent;
  $lingering_buffs_talent = new Talent('lingering_buffs', 5, 10, 1000000,2, htmlspecialchars($_POST['lingering_buffs']));
  $talents['lingering_buffs'] = $lingering_buffs_talent;
  $omniclicking_talent = new Talent('omniclicking', 5, 25, 75000,1.322, htmlspecialchars($_POST['omniclicking']));
  $talents['omniclicking'] = $omniclicking_talent;
  $bossing_around_talent = new Talent('bossing_around', 5, 2, 40000000, 1399999, htmlspecialchars($_POST['bossing_around']));
  $talents['bossing_around'] = $bossing_around_talent;
  $phase_skip_talent = new Talent('phase_skip', 6, 10, 30000000,1.2, htmlspecialchars($_POST['phase_skip']));
  $talents['phase_skip'] = $phase_skip_talent;
  $weekend_warrior_talent = new Talent('weekend_warrior', 6, 25, 750000000,1.31, htmlspecialchars($_POST['weekend_warrior']));
  $talents['weekend_warrior'] = $weekend_warrior_talent;
  $material_goods_talent = new Talent('material_goods', 6, 40, 300000000,1.2, htmlspecialchars($_POST['material_goods']));
  $talents['material_goods'] = $material_goods_talent;
  $passive_criticals_talent = new Talent('passive_criticals', 1, 50, 10,1.1, htmlspecialchars($_POST['passive_criticals']), '+', .01, htmlspecialchars($_POST['critical_chance']));
  $talents['passive_criticals'] = $passive_criticals_talent;
  $set_bonus_talent = new Talent('set_bonus', 1, 50, 25, 1.1, htmlspecialchars($_POST['set_bonus']), '+', .20);
  $talents['set_bonus'] = $set_bonus_talent;
  $every_last_cent_talent = new Talent('every_last_cent', 1, 20, 50,1.25, htmlspecialchars($_POST['every_last_cent']));
  $talents['every_last_cent'] = $every_last_cent_talent;
  //Multiplier is .02 due to the fact that fanta reports them as a set since you get them as a set of C/UC with up to speed
  $apprentice_crafter_talent = new Talent('apprentice_crafter', 1, -1, 200,1.1, htmlspecialchars($_POST['apprentice_crafter']), '+', htmlspecialchars($_POST['common_and_uncommon_recipes']),  .02);
  $talents['apprentice_crafter'] = $apprentice_crafter_talent;
  $overenchanted_talent = new Talent('overenchanted', 2, 50, 100,1.1, htmlspecialchars($_POST['overenchanted']), '+', htmlspecialchars($_POST['ep_from_main_dps']), .05);
  $talents['overenchanted'] = $overenchanted_talent;
  $surplus_cooldown_talent = new Talent('surplus_cooldown', 2, 50, 100, 1.1, htmlspecialchars($_POST['surplus_cooldown']), '+', .0025, (htmlspecialchars($_POST['cooldown_reduction']) - 50));
  $talents['surplus_cooldown'] = $surplus_cooldown_talent;
  $sharing_is_caring_talent = new Talent('sharing_is_caring', 2, 14, 500,1.25, htmlspecialchars($_POST['sharing_is_caring']));
  $talents['sharing_is_caring'] = $sharing_is_caring_talent;
  $task_mastery_talent = new Talent('task_mastery', 2, 20, 100,1.32, htmlspecialchars($_POST['task_mastery']));
  $talents['task_mastery'] = $task_mastery_talent;
  $fast_learners_talent = new Talent('fast_learners', 3, 18, 250,1.2, htmlspecialchars($_POST['fast_learners']));
  $talents['fast_learners'] = $fast_learners_talent;
  $well_equipped_talent = new Talent('well_equipped', 3, 50, 500,1.075, htmlspecialchars($_POST['well_equipped']), '+', .20, htmlspecialchars($_POST['epics_on_main_dps']));
  $talents['well_equipped'] = $well_equipped_talent;
  $swap_day_talent = new Talent('swap_day', 3, 50, 500,1.075, htmlspecialchars($_POST['swap_day']), '+', .20, htmlspecialchars($_POST['epics_on_benched_crusaders']));
  $talents['swap_day'] = $swap_day_talent;
  $synergy_talent = new Talent('synergy', 3, 20, 300,1.85, htmlspecialchars($_POST['synergy']));
  $talents['synergy'] = $synergy_talent;
  $legendary_benefits_talent = new Talent('legendary_benefits', 4, 50, 10000,1.1, htmlspecialchars($_POST['legendary_benefits']), '+', htmlspecialchars($_POST['legendaries']), .01);
  $talents['legendary_benefits'] = $legendary_benefits_talent;
  $idols_over_time_talent = new Talent('idols_over_time', 4, 20, 4000,1.4, htmlspecialchars($_POST['idols_over_time']));
  $talents['idols_over_time'] = $idols_over_time_talent;
  $golden_age_talent = new Talent('golden_age', 4, 50, 7500,1.12, htmlspecialchars($_POST['golden_age']), '+', htmlspecialchars($_POST['gold_bonus_provided_by_crusaders']));
  $talents['golden_age'] = $golden_age_talent;
  $journeyman_crafter_talent = new Talent('journeyman_crafter', 4, -1, 200000,1.061, htmlspecialchars($_POST['journeyman_crafter']), '+', htmlspecialchars($_POST['rare_recipes']), .01);
  $talents['journeyman_crafter'] = $journeyman_crafter_talent;
  $cheer_squad_talent = new Talent('cheer_squad', 5, 50, 166000,1.165, htmlspecialchars($_POST['cheer_squad']), '+', (htmlspecialchars($_POST['crusaders_owned']) - htmlspecialchars($_POST['crusaders_in_formation'])), .01);
  $talents['cheer_squad'] = $cheer_squad_talent;
  $valuable_experience_talent = new Talent('valuable_experience', 5, 45, 500000, 1.132, htmlspecialchars($_POST['valuable_experience']));
  $talents['valuable_experience'] = $valuable_experience_talent;
  $every_little_bit_helps_talent = new Talent('every_little_bit_helps', 5, 500, 25000,1.022, htmlspecialchars($_POST['every_little_bit_helps']), '*', 5, 1, htmlspecialchars($_POST['every_little_bit_helps']));
  $talents['every_little_bit_helps'] = $every_little_bit_helps_talent;
  $jeweler_talent = new Talent('jeweler', 5, 20, 80000,1.5, htmlspecialchars($_POST['jeweler']));
  $talents['jeweler'] = $jeweler_talent;
  $big_earner_talent = new Talent('big_earner', 6, 10, 250000000,1.9, htmlspecialchars($_POST['big_earner']));
  $talents['big_earner'] = $big_earner_talent;
  $maxed_power_talent = new Talent('maxed_power', 6, 50, 75000000, 1.3, htmlspecialchars($_POST['maxed_power']), '*', 1, htmlspecialchars($_POST['maxed_power']));
  $talents['maxed_power'] = $maxed_power_talent;
  $idolatry_talent = new Talent('idolatry', 6, 20, 50000000,1.5, htmlspecialchars($_POST['idolatry']), '*', 20, htmlspecialchars($_POST['idolatry']), floor(log(htmlspecialchars($_POST['idolatry_total_idols']), 10)));
  $talents['idolatry'] = $idolatry_talent;
  $master_crafter_talent = new Talent('master_crafter', 6, -1, 900000000,1.28, htmlspecialchars($_POST['master_crafter']), '+', .01, htmlspecialchars($_POST['epic_recipes']));
  $talents['master_crafter'] = $master_crafter_talent;
  $legendary_friendship_talent = new Talent('legendary_friendship', 7, 25, 7500000000, 1.56, htmlspecialchars($_POST['legendary_friendship']), '*', 5, htmlspecialchars($_POST['legendary_friendship']), htmlspecialchars($_POST['main_dps_benched_crusaders_legendaries']));
  $talents['legendary_friendship'] = $legendary_friendship_talent;
  $golden_friendship_talent = new Talent('golden_friendship', 7, 25, 8000000000, 1.395, htmlspecialchars($_POST['golden_friendship']), '*', 5, htmlspecialchars($_POST['golden_friendship']), htmlspecialchars($_POST['main_dps_benched_crusaders_golden_gear']));
  $talents['golden_friendship'] = $golden_friendship_talent;
  $friendly_helpers_talent = new Talent('friendly_helpers', 7, 50, 500000000,1.26, htmlspecialchars($_POST['friendly_helpers']), '*', 10, htmlspecialchars($_POST['friendly_helpers']), htmlspecialchars($_POST['taskmasters_owned']));
  $talents['friendly_helpers'] = $friendly_helpers_talent;
  $scavenger_talent = new Talent('scavenger', 1, 50, 25, 1.1, htmlspecialchars($_POST['scavenger']));
  $talents['scavenger'] = $scavenger_talent;
  $impatience_talent = new Talent('impatience', 1, 20, 25, 1.25, htmlspecialchars($_POST['impatience']));
  $talents['impatience'] = $impatience_talent;
  $level_all_the_way_talent = new Talent('level_all_the_way', 1, 50, 200, 1.11, htmlspecialchars($_POST['level_all_the_way']), '+', .011);
  $talents['level_all_the_way'] = $level_all_the_way_talent;
  $mission_accomplished_talent = new Talent('mission_accomplished', 1, -1, 500,1.19, htmlspecialchars($_POST['mission_accomplished']), '+', .01, htmlspecialchars($_POST['missions_accomplished']));
  $talents['mission_accomplished'] = $mission_accomplished_talent;
  $efficient_crusading_talent = new Talent('efficient_crusading', 2, 25, 50,1.1, htmlspecialchars($_POST['efficient_crusading']));
  $talents['efficient_crusading'] = $efficient_crusading_talent;
  $nurturing_talent = new Talent('nurturing', 2, 20, 1000, 1.06, htmlspecialchars($_POST['nurturing']));
  $talents['nurturing'] = $nurturing_talent;
  $prospector_talent = new Talent('prospector', 2, 10, 300, 1.6, htmlspecialchars($_POST['prospector']));
  $talents['prospector'] = $prospector_talent;
  $doing_it_again_talent = new Talent('doing_it_again', 2, 1, 1000, 1, htmlspecialchars($_POST['doing_it_again']));
  $talents['doing_it_again'] = $doing_it_again_talent;
  $deep_idol_scavenger_talent = new Talent('deep_idol_scavenger', 3, 25, 500,1.15, htmlspecialchars($_POST['deep_idol_scavenger']));
  $talents['deep_idol_scavenger'] = $deep_idol_scavenger_talent;
  $extra_training_talent = new Talent('extra_training', 3, 40, 1000, 1.075, htmlspecialchars($_POST['extra_training']), '*');
  $talents['extra_training'] = $extra_training_talent;
  $head_start_talent = new Talent('head_start', 3, 1, 10000, 1, htmlspecialchars($_POST['head_start']));
  $talents['head_start'] = $head_start_talent;
  $triple_tier_trouble_talent = new Talent('triple_tier_trouble', 3, 1, 5000, 1, htmlspecialchars($_POST['triple_tier_trouble']));
  $talents['triple_tier_trouble'] = $triple_tier_trouble_talent;
  $sprint_mode_talent = new Talent('sprint_mode', 4, 10, 25000, 2, htmlspecialchars($_POST['sprint_mode']));
  $talents['sprint_mode'] = $sprint_mode_talent;
  $superior_training_talent = new Talent('superior_training', 4, 80, 5000, 1.0888, htmlspecialchars($_POST['superior_training']), '*');
  $talents['superior_training'] = $superior_training_talent;
  $kilo_leveling_talent = new Talent('kilo_leveling', 4, 5, 500000, 4, htmlspecialchars($_POST['kilo_leveling']), '*', 10, htmlspecialchars($_POST['kilo_leveling']));
  $talents['kilo_leveling'] = $kilo_leveling_talent;
  $fourth_times_the_charm_talent = new Talent('fourth_times_the_charm', 4, 1, 25000, 1, htmlspecialchars($_POST['fourth_times_the_charm']));
  $talents['fourth_times_the_charm'] = $fourth_times_the_charm_talent;
  $idol_champions_talent = new Talent('idol_champions', 5, 40, 50000, 1.211, htmlspecialchars($_POST['idol_champions']));
  $talents['idol_champions'] = $idol_champions_talent;
  $tenk_training_talent = new Talent('tenk_training', 5, 80, 140000, 1.083, htmlspecialchars($_POST['tenk_training']), '*');
  $talents['tenk_training'] = $tenk_training_talent;
  $bonus_training_talent = new Talent('bonus_training', 5, $game_defines->max_bonus_training_level, 225000, 1.31, htmlspecialchars($_POST['bonus_training']), '*', 1, 1, 1, htmlspecialchars($_POST['main_dps_slot']));
  $talents['bonus_training'] = $bonus_training_talent;
  $scrap_hoarder_talent = new Talent('scrap_hoarder', 5, 3, 15000000, 2, htmlspecialchars($_POST['scrap_hoarder']));
  $talents['scrap_hoarder'] = $scrap_hoarder_talent;
  $marathon_sprint_talent = new Talent('marathon_sprint', 6, 20, 123000000, 1.5, htmlspecialchars($_POST['marathon_sprint']));
  $talents['marathon_sprint'] = $marathon_sprint_talent;
  $montage_training_talent = new Talent('montage_training', 6, 120, 35000000, 1.065, htmlspecialchars($_POST['montage_training']), '*');
  $talents['montage_training'] = $montage_training_talent;
  $arithmagician_talent = new Talent('arithmagician', 6, 19, 500000000, 'arithmagician', htmlspecialchars($_POST['arithmagician']));
  $talents['arithmagician'] = $arithmagician_talent;
  $cash_in_hand_talent = new Talent('cash_in_hand', 6, 10, 40000000, 2.5, htmlspecialchars($_POST['cash_in_hand']));
  $talents['cash_in_hand'] = $cash_in_hand_talent;
  $sprint_for_the_finish_talent = new Talent('sprint_for_the_finish', 7, 30, 200000000000, 1.2275, htmlspecialchars($_POST['sprint_for_the_finish']));
  $talents['sprint_for_the_finish'] = $sprint_for_the_finish_talent;
  $magical_training_talent = new Talent('magical_training', 7, -1, 20000000000, 1.285, htmlspecialchars($_POST['magical_training']), '*');
  $talents['magical_training'] = $magical_training_talent;
  $user = new User(htmlspecialchars($_POST['user_id']),
                   htmlspecialchars($_POST['user_hash']),
                   htmlspecialchars($_POST['server']),
                   htmlspecialchars($_POST['total_idols']),
                   htmlspecialchars($_POST['golden_items']),
                   htmlspecialchars($_POST['common_and_uncommon_recipes']),
                   htmlspecialchars($_POST['rare_recipes']),
                   htmlspecialchars($_POST['epic_recipes']),
                   htmlspecialchars($_POST['missions_accomplished']),
                   htmlspecialchars($_POST['legendaries']),
                   htmlspecialchars($_POST['brass_rings']),
                   htmlspecialchars($_POST['silver_rings']),
                   htmlspecialchars($_POST['golden_rings']),
                   htmlspecialchars($_POST['diamond_rings']),
                   htmlspecialchars($_POST['average_mission_completion']),
                   htmlspecialchars($_POST['main_dps_slot']),
                   htmlspecialchars($_POST['cooldown_reduction']),
                   htmlspecialchars($_POST['ep_from_main_dps']),
                   htmlspecialchars($_POST['ep_from_benched_crusaders']),
                   htmlspecialchars($_POST['epics_on_main_dps']),
                   htmlspecialchars($_POST['epics_on_benched_crusaders']),
                   htmlspecialchars($_POST['storm_rider_gear_bonus']),
                   htmlspecialchars($_POST['main_dps_benched_crusaders_legendaries']),
                   htmlspecialchars($_POST['main_dps_benched_crusaders_golden_gear']),
                   htmlspecialchars($_POST['taskmasters_owned']),
                   htmlspecialchars($_POST['clicks_per_second']),
                   htmlspecialchars($_POST['crusaders_owned']),
                   htmlspecialchars($_POST['crusaders_in_formation']),
                   htmlspecialchars($_POST['critical_chance']),
                   htmlspecialchars($_POST['click_damage_per_dps']),
                   htmlspecialchars($_POST['gold_bonus_provided_by_crusaders']),
                   $talents,
                   htmlspecialchars($_POST['talents_to_recommend']),
                   htmlspecialchars($_POST['max_level_reached']),
                   (isset($_POST['debug']) ? true: false));
  $user->talents['maxed_power']->stacks = $user->talents_at_max;
  $user->talents['level_all_the_way']->damage_base_multiplier = $user->total_talent_levels;
  $user->talents['kilo_leveling']->stacks = floor($user->main_dps_max_levels/1000);
  $base_damage = 1;
  echo "total idols spent " . number_format($user->get_total_talent_cost()) . " total idols remaining: " . number_format($user->total_idols - $user->get_total_talent_cost()) . "<br>";
  if (!empty($total_mat_div)) {
    echo $total_mat_div;
  }
  if (!empty($total_mat_div_with_chests)) {
    echo $total_mat_div_with_chests;
  }
  $results_legend = '<div class="green">Green means you can afford it</div><div class="yellow">Yellow means your leftover idols can afford it</div><div class="red">Red means you can\'t afford it</div>';
  $results_to_print = '<div style="float: right;clear: both;">Final damage is current damage + green suggestions, future damage adds the increase from yellow talent suggestions</div>';
  $results_to_print .= '<div style="float: right; clear: right;">' . $results_legend;
  $results_to_print .= '<div style="float: right;clear: both;">';
  $results_to_print .= "Final Damage " . format(bcsub($user->get_total_damage(), 40)) . "% Increase<br>";
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
        $future_damage = bcmul(bcdiv($future_damage, $future_talents_user->talents[$talent_to_buy]->get_current_damage()), $future_talents_user->talents[$talent_to_buy]->get_damage_at_additional_level(1));
      } else if ($next_talent_cost <= $leftover_idols) {
        $color = "yellow";
        $leftover_idols -= $next_talent_cost;
        $future_damage = bcmul(bcdiv($future_damage, $future_talents_user->talents[$talent_to_buy]->get_current_damage()), $future_talents_user->talents[$talent_to_buy]->get_damage_at_additional_level(1));
      }
      $talents_to_buy .= '<div style="clear: right; background: ' . $color . ';">Talent to buy: ' . $talent_to_buy . '</div>';
    }
  }
  $results_to_print .= "Future Damage " . format(bcsub($future_damage, 40)) . "% Increase<br>";
  $results_to_print .= $talents_to_buy;
  $results_to_print .= '</div></div>';
} else {
  $user = new User();
}

class Talent {
  function __construct($name, $tier, $max_level, $base_cost, $level_multiplier, $current_level = 0, $damage_type = '', $damage_base = 0, $damage_base_multiplier = 1, $stacks = 1, $main_dps_slot = 0) {
    $this->name = $name;
    $this->tier = $tier;
    $this->max_level = $max_level;
    $this->base_cost = $base_cost;
    $this->level_multiplier = $level_multiplier;
    $this->current_level = $current_level;
    $this->damage_type = $damage_type;
    $this->damage_base = $damage_base;
    $this->damage_base_multiplier = $damage_base_multiplier;
    $this->stacks = $stacks;
    $this->main_dps_slot = $main_dps_slot;
    $this->arith_cost = [0 => '500000000',
                         1 => '750000000',
                         2 => '1137750000',
                         3 => '1745308500',
                         4 => '2706973483',
                         5 => '4244534422',
                         6 => '6727587059',
                         7 => '10777594469',
                         8 => '17448925445',
                         9 => '28546442028',
                        10 => '47187268672',
                        11 => '78802738681',
                        12 => '132940220156',
                        13 => '226530135145',
                        14 => '389858362585',
                        15 => '677573834173',
                        16 => '1189142078973',
                        17 => '2107159763941',
                        18 => '3769708817690'];
  }

  public function get_damage_at_additional_level($levels_to_add) {
    $damage = '0';
    $this->current_level += $levels_to_add;
    $damage = $this->get_current_damage();
    $this->current_level -= $levels_to_add;
    return $damage;
  }

  public function get_current_damage() {
    $damage = '1';
    if ($this->damage_type == '+') {
      $damage = $this->get_additive_damage();
    } else if ($this->damage_type == '*') {
      $damage = $this->get_multiplicative_damage();
    }
    return $damage;
  }

  function get_additive_damage() {
    $damage = '0';
    if ($this->name == 'overenchanted') {
      $damage = bcadd(1, bcadd(0.25, bcmul(bcmul($this->damage_base_multiplier, $this->current_level, 40), $this->damage_base, 40), 40), 40);
    } else {
      $damage = bcadd(1, bcmul(bcmul($this->damage_base, $this->current_level, 40), $this->damage_base_multiplier, 40), 40);
    }
    return $damage;
  }

  function get_multiplicative_damage() {
    $damage = '0';
    //All other talents use current level as the multiplier, just every little bit helps use it as the stack
    if ($this->name != 'every_little_bit_helps'
      && $this->current_level != $this->damage_base_multiplier) {
      $this->damage_base_multiplier = $this->current_level;
    }
    if ($this->name == 'every_little_bit_helps') {
      $this->stacks = $this->current_level;
    }
    if ($this->name == 'extra_training'
     || $this->name == 'superior_training'
     || $this->name == 'tenk_training'
     || ($this->name == 'bonus_training' && $this->current_level >= $this->main_dps_slot)
     || $this->name == 'montage_training'
     || $this->name == 'magical_training') {
      if ($this->main_dps_slot == 27) {
        $level_multiplier = '4.25';
      } else {
        $level_multiplier = '4';
      }
      $damage = bcpow($level_multiplier, $this->current_level);
    } else if ($this->name == 'kilo_leveling') {
      $damage = bcpow(bcmul($this->damage_base, $this->damage_base_multiplier), $this->stacks);
    } else {
      $damage = bcpow(bcadd('1', bcmul(bcdiv($this->damage_base, '100', 20), $this->damage_base_multiplier, 20), 20), $this->stacks, 20);
    }
    return $damage;
  }

  public function get_cost_at_level($level) {
    $level_cost = '0';
    if ($level < $this->max_level || $this->max_level == -1) {
      if ($this->level_multiplier != 'arithmagician') {
        $unrounded_level_cost = bcmul($this->base_cost, bcpow($this->level_multiplier, $level, 40), 40);
        if (strpos($unrounded_level_cost, '.' !== false)) {
          $unrounded_level_cost_floored = substr($unrounded_level_cost, 0, strpos($unrounded_level_cost, '.'));
        } else {
          $unrounded_level_cost_floored = $unrounded_level_cost;
        }
        if (bccomp($unrounded_level_cost, $unrounded_level_cost_floored, 2) === 1) {
          $level_cost = bcadd($unrounded_level_cost_floored, 1);
        } else {
          $level_cost = $unrounded_level_cost;
        }
      } else {
        $level_cost = $this->arith_cost[$level];
      }
    }
    return $level_cost;
  }

  public function get_total_cost() {
    $total_cost = '0';
      for ($i = 0; $i < $this->current_level; $i++) {
        if ($this->level_multiplier != 'arithmagician') {
          $total_cost = bcadd($this->get_cost_at_level($i), $total_cost);
        } else {
          $total_cost = bcadd($total_cost, $this->arith_cost[$i]);
        }
      }
    return $total_cost;
  }
}

