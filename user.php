<?php

class User {
  function __construct($total_idols = 0, $golden_items = 0, $common_and_uncommon_recipies = 0, $rare_recipies = 0, $epic_recipies = 0, $missions_accomplished = 0, $legendaries = 0, $brass_rings = 0, $silver_rings = 0, $golden_rings = 0, $diamond_rings = 0, $average_mission_completion = 0, $main_dps_slot = 0, $cooldown_reduction = 0, $ep_from_main_dps = 0, $ep_from_benched_crusaders = 0, $epics_on_main_dps = 0, $epics_on_benched_crusaders = 0, $storm_rider_gear_bonus = 0, $main_dps_benched_crusaders_legendaries = 0, $main_dps_benched_crusaders_golden_gear = 0, $taskmasters_owned = 0, $clicks_per_second = 0, $crusaders_owned = 0, $crusaders_in_formation = 0, $critical_chance = 0, $click_damage_per_dps = 0, $gold_bonus_provided_by_crusaders = 0, $talents = 0, $talents_to_recommend = 0, $max_level_reached = 0, $debug = false, $fp_idol_average = 0, $time_to_complete_fp = 0, $time_to_complete_sprint = 0, $areas_sprintable = 0, $fp_areas_per_hour = 0) {
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
    $this->debug = $debug;
    $this->fp_idol_average = $fp_idol_average;
    $this->time_to_complete_fp = $time_to_complete_fp;
    $this->time_to_complete_sprint = $time_to_complete_sprint;
    $this->areas_sprintable = $areas_sprintable;
    $this->fp_areas_per_hour = $fp_areas_per_hour;
    if (!empty($this->talents)) {
      $this->talents_at_max = $this->get_max_talents();
      $this->total_talent_levels = $this->get_all_talent_levels();
      $this->main_dps_max_levels = 5000 + ($this->talents['extra_training']->current_level + $this->talents['superior_training']->current_level + $this->talents['tenk_training']->current_level + $this->talents['montage_training']->current_level + $this->talents['magical_training']->current_level + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot)) * 25;
    }
    $this->dungeon_level_increment = 500;
    $this->dungeon_idol_increment = 0.0015;
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
    $total_damage = bcmul(bcmul(bcadd(1, bcadd(bcadd(bcadd(bcmul(.01, $this->brass_rings), bcmul(.02, $this->silver_rings)), bcmul(.04, $this->golden_rings)), bcmul(.08, $this->diamond_rings))), bcadd(1, bcmul($this->total_idols, .03))), ($this->total_idols < 1 ? 1 : 100));
    foreach ($this->talents AS $talent_name => $talent) {
      $talent_damage = $talent->get_current_damage();
      if ($talent->current_level > 0 && $talent_damage > 0) {
        $total_damage = bcmul($total_damage, $talent_damage, 40);
      }
    }
    return $total_damage;
  }

  public function get_total_talent_cost() {
    $total_cost = '0';
    foreach ($this->talents AS $talent_name => $talent) {
      $total_cost = bcadd($talent->get_total_cost(), $total_cost, 2);
    }
    return $total_cost;
  }

  public function get_next_talent_to_buy() {
    $talent_to_buy = '';
    $best_dps_diff = 0;
    foreach ($this->talents AS $talent_name => $talent) {
      if (!$this->is_valid_talent($talent)) {
        continue;
      }
      $current_talent_damage = $talent->get_current_damage();
      $current_total_damage = $this->get_total_damage();
      $next_talent_level_cost = $talent->get_cost_at_level($talent->current_level);
      if (($talent->current_level + 1 > $talent->max_level && $talent->max_level != -1) || bccomp($next_talent_level_cost, bcdiv($this->total_idols, 3, 40)) == 1) {
        continue;
      }
      $future_talents_user = unserialize(serialize($this));
      $future_talents_user->update($talent_name);
      $future_total_damage = $future_talents_user->get_total_damage();
      $damage_diff = bcdiv(bcdiv(bcsub($future_total_damage, $current_total_damage, 40), $current_total_damage, 40), $next_talent_level_cost, 40);
      if ($this->debug) {
        echo $talent_name . " DPS diff of " . $damage_diff . " current damage " . format($current_total_damage) . " new talent damage " . format($future_total_damage) . "<br>";
        echo "<br>future_total_damage: " . format($future_total_damage) . " current_total_damage: " . format($current_total_damage) . " next_talent_level_cost: " . format($next_talent_level_cost) . " damage_diff: " . format($damage_diff) . "<br>";
        echo "<br>";
      }
      if ($damage_diff > $best_dps_diff) {
        $talent_to_buy = $talent_name;
        $best_dps_diff = $damage_diff;
      }
    }
    if ($this->debug) {
      echo "================== end of talents to buy ===================<br>";
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
    $this->talents['maxed_power']->stacks = $this->talents_at_max;
    $this->talents['level_all_the_way']->damage_base_multiplier = $this->total_talent_levels;
    $this->main_dps_max_levels = 5000 + ($this->talents['extra_training']->current_level + $this->talents['superior_training']->current_level + $this->talents['tenk_training']->current_level + $this->talents['montage_training']->current_level + $this->talents['magical_training']->current_level + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot)) * 25;
    $this->talents['kilo_leveling']->stacks = floor($this->main_dps_max_levels/1000);
  }

  public function get_dungeon_data($ledge) {
    $results = array();
    $next_highest_idol_ledge = $ledge / $this->dungeon_level_increment * $this->dungeon_idol_increment;
    if ($ledge < $this->areas_sprintable) {
      $total_time = $this->time_to_complete_sprint / $this->areas_sprintable * $ledge;
    } else {
      $total_time = $this->time_to_complete_sprint + 60 * ($ledge - $this->areas_sprintable) / $this->fp_areas_per_hour;
    }
    $idols_gained = $this->total_idols * $next_highest_idol_ledge;
    $idols_per_hour = $idols_gained / $total_time * 60;
    $idols_per_fp_time = $idols_per_hour / 60 * $this->time_to_complete_fp;
    $idol_over_fp = $idols_per_fp_time - $this->fp_idol_average;
    //echo $total_time . " idols gained: " . $idols_gained . " idols_per_hour: " . $idols_per_hour . " idols_per_fp_time: " . $idols_per_fp_time . " idol_over_fp: " . $idol_over_fp . "<br>";
    $results['total_time'] = $total_time;
    $results['idols_gained'] = $idols_gained;
    $results['idols_per_hour'] = $idols_per_hour;
    $results['idols_per_fp_time'] = $idols_per_fp_time;
    $results['idol_over_fp'] = $idol_over_fp;
    return $results;
  }
  public function get_talent_value($value) {
    if (!empty($this->talents[$value]->current_level)) {
      return $this->talents[$value]->current_level;
    } else {
      return 0;
    }
  }

}

?>
