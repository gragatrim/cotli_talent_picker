<?php
if ($_POST) {
  $talents = array();
  $time_o_rama_talent = new Talent('time_o_rama', 1, 20, 25, 1.25, $_POST['time_o_rama']);
  $talents['time_o_rama'] = $time_o_rama_talent;
  $massive_criticals_talent = new Talent('massive_criticals', 1, 25, 50, 1.25, $_POST['massive_criticals']);
  $talents['massive_criticals'] = $massive_criticals_talent;
  $golden_benefits_talent = new Talent('golden_benefits', 1, -1, 1500, 1.061, $_POST['golden_benefits'], '+', $_POST['golden_items']);
  $talents['golden_benefits'] = $golden_benefits_talent;
  $super_clicks_talent = new Talent('super_clicks', 1, 25, 50, 1.1, $_POST['super_clicks']);
  $talents['super_clicks'] = $super_clicks_talent;
  $endurance_training_talent = new Talent('endurance_training', 2, 20, 50, 1.25, $_POST['endurance_training']);
  $talents['endurance_training'] = $endurance_training_talent;
  $ride_the_storm_talent = new Talent('ride_the_storm', 2, 25, 100,1.15, $_POST['ride_the_storm']);
  $talents['ride_the_storm'] = $ride_the_storm_talent;
  $storms_building_talent = new Talent('storms_building', 2, 15, 100,1.33, $_POST['storms_building']);
  $talents['storms_building'] = $storms_building_talent;
  $the_more_the_merrier_talent = new Talent('the_more_the_merrier', 2, 30, 4500,1.163, $_POST['the_more_the_merrier']);
  $talents['the_more_the_merrier'] = $the_more_the_merrier_talent;
  $gold_o_splosion_talent = new Talent('gold_o_splosion', 3, 25,500, 1.15, $_POST['gold_o_splosion']);
  $talents['gold_o_splosion'] = $gold_o_splosion_talent;
  $speed_runner_talent = new Talent('speed_runner', 3, 10, 1000, 1.63, $_POST['speed_runner']);
  $talents['speed_runner'] = $speed_runner_talent;
  $sniper_talent = new Talent('sniper', 3, 40, 200, 1.1, $_POST['sniper']);
  $talents['sniper'] = $sniper_talent;
  $higher_magnification_talent = new Talent('higher_magnification', 3, 10, 2000, 1.5, $_POST['higher_magnification']);
  $talents['higher_magnification'] = $higher_magnification_talent;
  $extended_spawns_talent = new Talent('extended_spawns', 4, 40, 10000, 1.13, $_POST['extended_spawns']);
  $talents['extended_spawns'] = $extended_spawns_talent;
  $click_tastrophy_talent = new Talent('click_tastrophy', 4, 40, 2500,1.2, $_POST['click_tastrophy']);
  $talents['click_tastrophy'] = $click_tastrophy_talent;
  $instant_satisfaction_talent = new Talent('instant_satisfaction', 4, 21, 7500,1.3333, $_POST['instant_satisfaction']);
  $talents['instant_satisfaction'] = $instant_satisfaction_talent;
  $extra_healthy_talent = new Talent('extra_healthy', 4, 50, 1500,1.305, $_POST['extra_healthy']);
  $talents['extra_healthy'] = $extra_healthy_talent;
  $mission_adrenaline_talent = new Talent('mission_adrenaline', 5, 50, 125000,1.153, $_POST['mission_adrenaline'], '+', 10, $_POST['missions_accomplished']);
  $talents['mission_adrenaline'] = $mission_adrenaline_talent;
  $lingering_buffs_talent = new Talent('lingering_buffs', 5, 10, 1000000,2, $_POST['lingering_buffs']);
  $talents['lingering_buffs'] = $lingering_buffs_talent;
  $omniclicking_talent = new Talent('omniclicking', 5, 25, 75000,1.322, $_POST['omniclicking']);
  $talents['omniclicking'] = $omniclicking_talent;
  $bossing_around_talent = new Talent('bossing_around', 5, 2, 40000000,13999., $_POST['bossing_around']);
  $talents['bossing_around'] = $bossing_around_talent;
  $phase_skip_talent = new Talent('phase_skip', 6, 10, 30000000,1.2, $_POST['phase_skip']);
  $talents['phase_skip'] = $phase_skip_talent;
  $weekend_warrior_talent = new Talent('weekend_warrior', 6, 25, 750000000,1.31, $_POST['weekend_warrior']);
  $talents['weekend_warrior'] = $weekend_warrior_talent;
  $material_goods_talent = new Talent('material_goods', 6, 40, 30000000,1.2, $_POST['material_goods']);
  $talents['material_goods'] = $material_goods_talent;
  $passive_criticals_talent = new Talent('passive_criticals', 1, 50, 10,1.1, $_POST['passive_criticals'], '+', 1, $_POST['critical_chance']);
  $talents['passive_criticals'] = $passive_criticals_talent;
  $set_bonus_talent = new Talent('set_bonus', 1, 50, 25, 1.1, $_POST['set_bonus'], '+', 20);
  $talents['set_bonus'] = $set_bonus_talent;
  $every_last_cent_talent = new Talent('every_last_cent', 1, 20, 50,1.25, $_POST['every_last_cent']);
  $talents['every_last_cent'] = $every_last_cent_talent;
  //Multiplier is 2 due to the fact that fanta reports them as a set since you get them as a set of C/UC with up to speed
  $apprentice_crafter_talent = new Talent('apprentice_crafter', 1, -1, 200,1.1, $_POST['apprentice_crafter'], '+', $_POST['common_and_uncommon_recipies'],  2);
  $talents['apprentice_crafter'] = $apprentice_crafter_talent;
  $overenchanted_talent = new Talent('overenchanted', 2, 50, 100,1.1, $_POST['overenchanted'], '+', $_POST['ep_from_main_dps']);
  $talents['overenchanted'] = $overenchanted_talent;
  $surplus_cooldown_talent = new Talent('surplus_cooldown', 2, 50, 100,1.1, $_POST['surplus_cooldown'], '+', $_POST['cooldown_reduction'] - 50, .25);
  $talents['surplus_cooldown'] = $surplus_cooldown_talent;
  $sharing_is_caring_talent = new Talent('sharing_is_caring', 2, 14, 500,1.25, $_POST['sharing_is_caring']);
  $talents['sharing_is_caring'] = $sharing_is_caring_talent;
  $task_mastery_talent = new Talent('task_mastery', 2, 20, 100,1.32, $_POST['task_mastery']);
  $talents['task_mastery'] = $task_mastery_talent;
  $fast_learners_talent = new Talent('fast_learners', 3, 18, 250,1.2, $_POST['fast_learners']);
  $talents['fast_learners'] = $fast_learners_talent;
  $well_equiped_talent = new Talent('well_equiped', 3, 50, 500,1.075, $_POST['well_equiped'], '+', 20, $_POST['epics_on_main_dps']);
  $talents['well_equiped'] = $well_equiped_talent;
  $swap_day_talent = new Talent('swap_day', 3, 50, 500,1.075, $_POST['swap_day'], '+', 20, $_POST['epics_on_benched_crusaders']);
  $talents['swap_day'] = $swap_day_talent;
  $synergy_talent = new Talent('synergy', 3, 20, 300,1.85, $_POST['synergy']);
  $talents['synergy'] = $synergy_talent;
  $legendary_benefits_talent = new Talent('legendary_benefits', 4, 50, 10000,1.1, $_POST['legendary_benefits'], '+', $_POST['legendaries']);
  $talents['legendary_benefits'] = $legendary_benefits_talent;
  $idols_over_time_talent = new Talent('idols_over_time', 4, 20, 4000,1.4, $_POST['idols_over_time']);
  $talents['idols_over_time'] = $idols_over_time_talent;
  $golden_age_talent = new Talent('golden_age', 4, 50, 7500,1.12, $_POST['golden_age'], '+', $_POST['gold_bonus_provided_by_crusaders']);
  $talents['golden_age'] = $golden_age_talent;
  $journeyman_crafter_talent = new Talent('journeyman_crafter', 4, -1, 200000,1.061, $_POST['journeyman_crafter'], '+', $_POST['rare_recipies']);
  $talents['journeyman_crafter'] = $journeyman_crafter_talent;
  $cheer_squad_talent = new Talent('cheer_squad', 5, 50, 166000,1.165, $_POST['cheer_squad'], '+', ($_POST['crusaders_owned'] - $_POST['crusaders_in_formation']));
  $talents['cheer_squad'] = $cheer_squad_talent;
  $valuable_experience_talent = new Talent('valuable_experience', 5, 45, 500000,1.132, $_POST['valuable_experience']);
  $talents['valuable_experience'] = $valuable_experience_talent;
  $every_little_bit_helps_talent = new Talent('every_little_bit_helps', 5, 500, 25000,1.022, $_POST['every_little_bit_helps'], '*', $_POST['every_little_bit_helps'], 5, 1);
  $talents['every_little_bit_helps'] = $every_little_bit_helps_talent;
  $jeweler_talent = new Talent('jeweler', 5, 20, 80000,1.5, $_POST['jeweler']);
  $talents['jeweler'] = $jeweler_talent;
  $big_earner_talent = new Talent('big_earner', 6, 10, 250000000,1.9, $_POST['big_earner']);
  $talents['big_earner'] = $big_earner_talent;
  $maxed_power_talent = new Talent('maxed_power', 6, 50, 75000000, 1.3, $_POST['maxed_power'], '*', 0, 1);
  $talents['maxed_power'] = $maxed_power_talent;
  $idolatry_talent = new Talent('idolatry', 6, 20, 50000000,1.5, $_POST['idolatry'], '*', floor(log($_POST['total_idols'], 10)), 20);
  $talents['idolatry'] = $idolatry_talent;
  $master_crafter_talent = new Talent('master_crafter', 6, -1, 900000000,1.28, $_POST['master_crafter'], '+', $_POST['epic_recipies']);
  $talents['master_crafter'] = $master_crafter_talent;
  $legendary_friendship_talent = new Talent('legendary_friendship', 7, 25, 7500000000, 1.56, $_POST['legendary_friendship'], '*', $_POST['main_dps_benched_crusaders_legendaries'], 5);
  $talents['legendary_friendship'] = $legendary_friendship_talent;
  $golden_friendship_talent = new Talent('golden_friendship', 7, 25, 8000000000,1.395, $_POST['golden_friendship'], '*', $_POST['main_dps_benched_crusaders_golden_gear'], 5);
  $talents['golden_friendship'] = $golden_friendship_talent;
  $friendly_helpers_talent = new Talent('friendly_helpers', 7, 50, 500000000,1.26, $_POST['friendly_helpers'], '*', $_POST['taskmasters_owned'], 10);
  $talents['friendly_helpers'] = $friendly_helpers_talent;
  $scavenger_talent = new Talent('scavenger', 1, 50, 25, 1.1, $_POST['scavenger']);
  $talents['scavenger'] = $scavenger_talent;
  $impatience_talent = new Talent('impatience', 1, 20, 25, 1.25, $_POST['impatience']);
  $talents['impatience'] = $impatience_talent;
  $level_all_the_way_talent = new Talent('level_all_the_way', 1, 50, 200,1.11, $_POST['level_all_the_way'], '+', 1);
  $talents['level_all_the_way'] = $level_all_the_way_talent;
  $mission_accomplished_talent = new Talent('mission_accomplished', 1, -1, 500,1.19, $_POST['mission_accomplished'], '+', 1, $_POST['missions_accomplished']);
  $talents['mission_accomplished'] = $mission_accomplished_talent;
  $efficient_crusading_talent = new Talent('efficient_crusading', 2, 25, 50,1.1, $_POST['efficient_crusading']);
  $talents['efficient_crusading'] = $efficient_crusading_talent;
  $nurturing_talent = new Talent('nurturing', 2, 20, 1000, 1.06, $_POST['nurturing']);
  $talents['nurturing'] = $nurturing_talent;
  $prospector_talent = new Talent('prospector', 2, 10, 300, 1.6, $_POST['prospector']);
  $talents['prospector'] = $prospector_talent;
  $doing_it_again_talent = new Talent('doing_it_again', 2, 1, 1000,0, $_POST['doing_it_again']);
  $talents['doing_it_again'] = $doing_it_again_talent;
  $deep_idol_scavenger_talent = new Talent('deep_idol_scavenger', 3, 25, 500,1.15, $_POST['deep_idol_scavenger']);
  $talents['deep_idol_scavenger'] = $deep_idol_scavenger_talent;
  $extra_training_talent = new Talent('extra_training', 3, 40, 1000, 1.075, $_POST['extra_training'], '*', $_POST['extra_training'], 300, 1);
  $talents['extra_training'] = $extra_training_talent;
  $head_start_talent = new Talent('head_start', 3, 1, 10000, 0, $_POST['head_start']);
  $talents['head_start'] = $head_start_talent;
  $triple_tier_trouble_talent = new Talent('triple_tier_trouble', 3, 1, 5000, 0, $_POST['triple_tier_trouble']);
  $talents['triple_tier_trouble'] = $triple_tier_trouble_talent;
  $sprint_mode_talent = new Talent('sprint_mode', 4, 10, 25000, 2, $_POST['sprint_mode']);
  $talents['sprint_mode'] = $sprint_mode_talent;
  $superior_training_talent = new Talent('superior_training', 4, 80, 5000, 1.0888, $_POST['superior_training'], '*', $_POST['superior_training'], 300, 1);
  $talents['superior_training'] = $superior_training_talent;
  $kilo_leveling_talent = new Talent('kilo_leveling', 4, 5, 500000, 4, $_POST['kilo_leveling'], '+', 10);
  $talents['kilo_leveling'] = $kilo_leveling_talent;
  $fourth_times_the_charm_talent = new Talent('fourth_times_the_charm', 4, 1, 25000, 0, $_POST['fourth_times_the_charm']);
  $talents['fourth_times_the_charm'] = $fourth_times_the_charm_talent;
  $idol_champions_talent = new Talent('idol_champions', 5, 40, 50000, 1.211, $_POST['idol_champions']);
  $talents['idol_champions'] = $idol_champions_talent;
  $tenk_training_talent = new Talent('tenk_training', 5, 80, 140000, 1.083, $_POST['tenk_training'], '*', $_POST['tenk_training'], 300, 1);
  $talents['tenk_training'] = $tenk_training_talent;
  $bonus_training_talent = new Talent('bonus_training', 5, 33, 225000, 1.31, $_POST['bonus_training']);
  $talents['bonus_training'] = $bonus_training_talent;
  $scrap_hoarder_talent = new Talent('scrap_hoarder', 5, 3, 15000000, 2, $_POST['scrap_hoarder']);
  $talents['scrap_hoarder'] = $scrap_hoarder_talent;
  $marathon_sprint_talent = new Talent('marathon_sprint', 6, 20, 123000000, 1.5, $_POST['marathon_sprint']);
  $talents['marathon_sprint'] = $marathon_sprint_talent;
  $montage_training_talent = new Talent('montage_training', 6, 120, 35000000, 1.065, $_POST['montage_training'], '*', $_POST['montage_training'], 300, 1);
  $talents['montage_training'] = $montage_training_talent;
  $arithmagician_talent = new Talent('arithmagician', 6, 19, 500000000, 'arithmagician', $_POST['arithmagician']);
  $talents['arithmagician'] = $arithmagician_talent;
  $cash_in_hand_talent = new Talent('cash_in_hand', 6, 10, 40000000, 2.5, $_POST['cash_in_hand']);
  $talents['cash_in_hand'] = $cash_in_hand_talent;
  $sprint_for_the_finish_talent = new Talent('sprint_for_the_finish', 7, 30, 200000000000, 1.2275, $_POST['sprint_for_the_finish']);
  $talents['sprint_for_the_finish'] = $sprint_for_the_finish_talent;
  $magical_training_talent = new Talent('magical_training', 7, -1, 20000000000, 1.285, $_POST['magical_training'], '*', $_POST['magical_training'], 300, 1);
  $talents['magical_training'] = $magical_training_talent;
  $user = new User($_POST['total_idols'],
                   $_POST['golden_items'],
                   $_POST['common_and_uncommon_recipies'],
                   $_POST['rare_recipies'],
                   $_POST['epic_recipies'],
                   $_POST['missions_accomplished'],
                   $_POST['legendaries'],
                   $_POST['brass_rings'],
                   $_POST['silver_rings'],
                   $_POST['golden_rings'],
                   $_POST['diamond_rings'],
                   $_POST['average_mission_completion'],
                   $_POST['main_dps_slot'],
                   $_POST['cooldown_reduction'],
                   $_POST['ep_from_main_dps'],
                   $_POST['ep_from_benched_crusaders'],
                   $_POST['epics_on_main_dps'],
                   $_POST['epics_on_benched_crusaders'],
                   $_POST['storm_rider_gear_bonus'],
                   $_POST['main_dps_benched_crusaders_legendaries'],
                   $_POST['main_dps_benched_crusaders_golden_gear'],
                   $_POST['taskmasters_owned'],
                   $_POST['clicks_per_second'],
                   $_POST['crusaders_owned'],
                   $_POST['crusaders_in_formation'],
                   $_POST['critical_chance'],
                   $_POST['click_damage_per_dps'],
                   $_POST['gold_bonus_provided_by_crusaders'],
                   $talents,
                   $_POST['talents_to_recommend'],
                   $_POST['max_level_reached']);
  $user->talents['maxed_power']->damage_base = $user->talents_at_max;
  $user->talents['level_all_the_way']->damage_base = $user->total_talent_levels;
  $user->talents['kilo_leveling']->damage_base = floor($user->main_dps_max_levels/1000);
  $base_damage = 1;
  //echo "Every Little Bit Helps lvl " . $user->talents['every_little_bit_helps']->current_level . " provides " . $user->talents['every_little_bit_helps']->get_current_damage() . " %<br>";
  //echo "maxed power at lvl " . $user->talents['maxed_power']->current_level . " provides " . $user->talents['maxed_power']->get_current_damage() . " %<br>";
  //echo "<br>";
  echo "Final Damage " . $base_damage * $user->get_total_damage() . "<br>";
  //This is here to make a copy of the object so we aren't still accessing things by reference
  $future_talents_user = unserialize(serialize($user));
  for ($i = 0; $i < $user->talents_to_recommend; $i++) {
    $talent_to_buy = $future_talents_user->get_next_talent_to_buy();
    if (empty($talent_to_buy)) {
      echo "No talent found!<br>";
      break;
    } else {
      echo "Talent to buy: " . $talent_to_buy . "<br>";
      $future_talents_user->update($talent_to_buy);
    }
  }
}

class Talent {
  function __construct($name, $tier, $max_level, $base_cost, $level_multiplier, $current_level = 0, $damage_type = '', $damage_base = 0, $damage_base_multiplier = 1, $effect = '') {
    $this->name = $name;
    $this->tier = $tier;
    $this->max_level = $max_level;
    $this->base_cost = $base_cost;
    $this->level_multiplier = $level_multiplier;
    $this->current_level = $current_level;
    $this->damage_type = $damage_type;
    $this->damage_base = $damage_base;
    $this->damage_base_multiplier = $damage_base_multiplier;
    $this->effect = $effect;
  }

  public function get_damage_at_additional_level($levels_to_add) {
    $damage = 0;
    $this->current_level += $levels_to_add;
    $damage = $this->get_current_damage();
    $this->current_level -= $levels_to_add;
    return $damage;
  }

  public function get_current_damage() {
    $damage = 1;
    if ($this->damage_type == '+') {
      $damage = $this->get_additive_damage();
    } else if ($this->damage_type == '*') {
      $damage = $this->get_multiplicative_damage();
    }
    return $damage;
  }

  function get_additive_damage() {
    $damage = 1;
    if ($this->name == 'overenchanted') {
      $damage = ((1+(0.25 + 0.05 * $this->current_level) * $this->damage_base)/(1 + 0.25 * $this->damage_base));
    } else {
      $damage = $this->damage_base * $this->current_level * $this->damage_base_multiplier;
    }
    return $damage;
  }

  function get_multiplicative_damage() {
    $damage = 0;
    if (($this->damage_base_multiplier == 0
     && $this->name != 'every_little_bit_helps')
      || $this->name == 'idolatry') {
      $this->damage_base_multiplier = $this->current_level;
    }
    if ($this->name == 'every_little_bit_helps') {
      $this->stacks = $this->current_level;
    }
    if ($this->name == 'extra_training'
     || $this->name == 'superior_training'
     || $this->name == 'tenk_training'
     || $this->name == 'montage_training'
     || $this->name == 'magical_training') {
      $damage = pow(4, $this->current_level);
    } else {
      $damage = (pow(1 + $this->damage_base / 100 * $this->damage_base_multiplier, $this->stacks) - 1) * 100;
    }
    return $damage;
  }

  public function get_next_level_cost() {
    $next_level_cost = 0;
    if ($this->current_level + 1 <= $this->max_level || $this->max_level == -1) {
      if ($this->level_multiplier != 'arithmagician') {
        $next_level_cost = ceil($this->base_cost * pow($this->level_multiplier, ($this->current_level)));
      } else {
        $arith_cost = [0 => '500000000',
                       1 => '750000000',
                       2 => '1137750000',
                       3 => '1745308500',
                       4 => '2706973483',
                       5 => '4244534422',
                       6 => '6727587059',
                       7 => '10777594469',
                       8 => '17448925445',
                       9 => '28546442028',
                      10 => '47187268627',
                      11 => '78802738681',
                      12 => '132940220156',
                      13 => '226530135145',
                      14 => '389858362585',
                      15 => '677573834173',
                      16 => '1189142078973',
                      17 => '2107159763941',
                      18 => '3769708817690'];
        $next_level_cost = $arith_cost[$this->current_level];
      }
    }
    return $next_level_cost;
  }
}

class User {
  function __construct($total_idols, $golden_items, $common_and_uncommon_recipies, $rare_recipies, $epic_recipies, $missions_accomplished, $legendaries, $brass_rings, $silver_rings, $golden_rings, $diamond_rings, $average_mission_completion, $main_dps_slot, $cooldown_reduction, $ep_from_main_dps, $ep_from_benched_crusaders, $epics_on_main_dps, $epics_on_benched_crusaders, $storm_rider_gear_bonus, $main_dps_benched_crusaders_legendaries, $main_dps_benched_crusaders_golden_gear, $taskmasters_owned, $clicks_per_second, $crusaders_owned, $crusaders_in_formation, $critical_chance, $click_damage_per_dps, $gold_bonus_provided_by_crusaders, $talents, $talents_to_recommend, $max_level_reached) {
    $this->total_idols = $total_idols;
    $this->golden_items = $golden_items;
    $this->common_and_uncommon_recipies = $common_and_uncommon_recipies;
    $this->rare_recipies = $rare_recipies;
    $this->epic_recipies = $epic_recipies;
    $this->missions_accomplished = $missions_accomplished;
    $this->legendaries = $legendaries;
    $this->brass_rings = $brass_rings;
    $this->silver_rings = $silver_rings;
    $this->golden_rings = $golden_rings;
    $this->diamond_rings = $diamond_rings;
    $this->average_mission_completion = $average_mission_completion;
    $this->main_dps_slot = $main_dps_slot;
    $this->cooldown_reduction = $cooldown_reduction;
    $this->ep_from_main_dps = $ep_from_main_dps;
    $this->ep_from_benched_crusaders = $ep_from_benched_crusaders;
    $this->epics_on_main_dps = $epics_on_main_dps;
    $this->epics_on_benched_crusaders = $epics_on_benched_crusaders;
    $this->storm_rider_gear_bonus = $storm_rider_gear_bonus;
    $this->main_dps_benched_crusaders_legendaries = $main_dps_benched_crusaders_legendaries;
    $this->main_dps_benched_crusaders_golden_gear = $main_dps_benched_crusaders_golden_gear;
    $this->taskmasters_owned = $taskmasters_owned;
    $this->clicks_per_second = $clicks_per_second;
    $this->crusaders_owned = $crusaders_owned;
    $this->crusaders_in_formation = $crusaders_in_formation;
    $this->critical_chance = $critical_chance;
    $this->click_damage_per_dps = $click_damage_per_dps;
    $this->gold_bonus_provided_by_crusaders = $gold_bonus_provided_by_crusaders;
    $this->talents = $talents;
    $this->talents_to_recommend = $talents_to_recommend;
    $this->max_level_reached = $max_level_reached;
    $this->talents_at_max = $this->get_max_talents();
    $this->total_talent_levels = $this->get_all_talent_levels();
    $this->main_dps_max_levels = 5000 + $this->talents['extra_training']->current_level * 50 + $this->talents['superior_training']->current_level * 50 + $this->talents['tenk_training']->current_level * 50 + $this->talents['montage_training']->current_level * 50 + $this->talents['magical_training']->current_level * 50 + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot) * 50;
  }

  public function get_all_talent_levels() {
    $total_levels = 0;
    foreach ($this->talents AS $talent_name => $talent) {
      $total_levels += $talent->current_level;
    }
    return $total_levels;
  }

  public function get_max_talents() {
    $max_talents = 0;
    foreach ($this->talents AS $talent_name => $talent) {
      if ($talent->current_level == $talent->max_level) {
        $max_talents++;
      }
    }
    return $max_talents;
  }

  public function get_total_damage() {
    $total_damage = (1 + $this->brass_rings + (2 * $this->silver_rings) + (4 * $this->golden_rings) + (8 * $this->diamond_rings)) * (1 + $this->total_idols * .03);
    foreach ($this->talents AS $talent_name => $talent) {
      $talent_damage = $talent->get_current_damage();
      if ($talent_damage > 0) {
        $total_damage *= $talent_damage;
      }
    }
    return $total_damage;
  }

  public function get_next_talent_to_buy() {
    $talent_to_buy = '';
    $best_dps_diff = 0;
    foreach ($this->talents AS $talent_name => $talent) {
      if (!$this->is_valid_talent($talent)) {
        continue;
      }
      $current_talent_damage = $talent->get_current_damage();
      $next_talent_level_cost = $talent->get_next_level_cost();
      if ($talent->current_level + 1 > $talent->max_level && $talent->max_level != -1) {
        continue;
      }
      $new_talent_damage = $talent->get_damage_at_additional_level(1);
      if ($current_talent_damage == 0) {
        $damage_diff = $new_talent_damage/$next_talent_level_cost;
      } else {
        $damage_diff = ($new_talent_damage - $current_talent_damage)/$current_talent_damage/$next_talent_level_cost;
      }
      //echo "possible talent to buy: " . $talent_name . " DPS diff of " . $damage_diff . " current damage " . $current_talent_damage . " new talent damage " . $new_talent_damage . "<br>";
      if ($damage_diff > $best_dps_diff) {
        $talent_to_buy = $talent_name;
        $best_dps_diff = $damage_diff;
      }
    }
    return $talent_to_buy;
  }

  public function is_valid_talent($talent) {
    $is_valid = false;
    if ($this->max_level_reached < 150) {
      $is_valid = false;
    } else if ($talent->tier <=1 && $this->max_level_reached >= 150) {
      $is_valid = true;
    } else if ($talent->tier <=2 && $this->max_level_reached >= 300) {
      $is_valid = true;
    } else if ($talent->tier <=3 && $this->max_level_reached >= 600) {
      $is_valid = true;
    } else if ($talent->tier <=4 && $this->max_level_reached >= 900) {
      $is_valid = true;
    } else if ($talent->tier <=5 && $this->max_level_reached >= 1500) {
      $is_valid = true;
    } else if ($talent->tier <=6 && $this->max_level_reached >= 1800) {
      $is_valid = true;
    } else if ($talent->tier <=7 && $this->max_level_reached >= 2700) {
      $is_valid = true;
    }
    return $is_valid;
 }

  public function update($talent_to_update) {
    $this->talents[$talent_to_update]->current_level++;
    $this->talents_at_max = $this->get_max_talents();
    $this->total_talent_levels = $this->get_all_talent_levels();
    $this->talents['maxed_power']->damage_base = $this->talents_at_max;
    $this->talents['level_all_the_way']->damage_base = $this->total_talent_levels;
    $this->main_dps_max_levels = 5000 + $this->talents['extra_training']->current_level * 50 + $this->talents['superior_training']->current_level * 50 + $this->talents['tenk_training']->current_level * 50 + $this->talents['montage_training']->current_level * 50 + $this->talents['magical_training']->current_level * 50 + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot) * 50;
    $this->talents['kilo_leveling']->damage_base = floor($this->main_dps_max_levels/1000);
  }
}
