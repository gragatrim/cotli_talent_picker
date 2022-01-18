<?php
//TODO refactor this.... it's trash
class User {
  function __construct($post_data = array(), $talents = 0, $t2_11ths_completed = 0, $max_area_reached = 0, $time_to_complete_fp = 0, $time_to_complete_sprint = 0, $areas_sprintable = 0, $dungeon_areas_per_hour = 0, $idol_buff = 1) {
    foreach ($post_data AS $key => $value) {
      if ($key == 'total_idols') {
        $this->total_idols = sprintf('%.0f', $value);
      } else if ($key == 'user_id' || $key  == 'user_hash') {
        $this->$key = trim($value);
      } else {
        $this->$key = htmlspecialchars($value);
      }
    }
    if (empty($this->debug)) {
      $this->debug = false;
    }
    $this->talents = $talents;
    $this->t2_11ths_completed = $t2_11ths_completed;
    $this->max_area_reached = $max_area_reached;
    $this->time_to_complete_fp = $time_to_complete_fp;
    $this->time_to_complete_sprint = $time_to_complete_sprint;
    $this->areas_sprintable = $areas_sprintable;
    $this->dungeon_areas_per_hour = $dungeon_areas_per_hour;
    $this->idol_buff = $idol_buff;
    if (!empty($this->talents)) {
      $this->talents_at_max = $this->get_max_talents();
      $this->total_talent_levels = $this->get_all_talent_levels();
      if ($this->hitting_level_cap != false) {
        $this->main_dps_max_levels = 5000 + ($this->talents['extra_training']->current_level + $this->talents['superior_training']->current_level + $this->talents['tenk_training']->current_level + $this->talents['montage_training']->current_level + $this->talents['olympian_training']->current_level + $this->talents['magical_training']->current_level + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot)) * 25 + $this->main_dps_max_level_increase_from_runes;
      }
    }
    $this->dungeon_level_increment = 500;
    $this->dungeon_idol_increment = array(500  => .0001,
                                          1000 => .0002,
                                          1500 => .0003,
                                          2000 => .0004,
                                          2500 => .0005,
                                          3000 => .0006,
                                          3500 => .0007,
                                          4000 => .0008,
                                          4500 => .0009,
                                          5000 => .0010,
                                          5500 => .0015,
                                          6000 => .0030,
                                          6500 => .0045,
                                          7000 => .0060,
                                          7500 => .0075,
                                          8000 => .0090,
                                          8500 => .0105,
                                          9000 => .0120,
                                          9500 => .0135,
                                          10000 => .0150,
                                          10500 => .0165,
                                          11000 => .0180,
                                          11500 => .0195,
                                          12000 => .0210,
                                          12500 => .0225,
                                          13000 => .0240,
                                          13500 => .0255,
                                          14000 => .0270,
                                          14500 => .0285,
                                          15000 => .0300,
                                          15500 => .0315,
                                          16000 => .0330,
                                          16500 => .0345,
                                          17000 => .0360,
                                          17500 => .0375,
                                          );
  }

  public function get_all_talent_levels() {
    $total_levels = 0;
    foreach ($this->talents AS $talent_name => $talent) {
      $total_levels += $talent->current_level;
    }
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
      if (!in_array($talent->id, $talent->dps_talents)) {
        continue;
      }
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
    $current_total_damage = $this->get_total_damage();
    if ($this->debug) {
      echo "<br style='clear: left;'>";
    }
    foreach ($this->talents AS $talent_name => $talent) {
      if (!$this->is_valid_talent($talent)) {
        continue;
      }
      $next_talent_level_cost = $talent->get_cost_at_level($talent->current_level);
      if (($talent->current_level + 1 > $talent->max_level && $talent->max_level != -1) || bccomp($next_talent_level_cost, bcdiv($this->total_idols, 3, 40)) == 1) {
        continue;
      }
      $future_talents_user = unserialize(serialize($this));
      $future_talents_user->update($talent_name);
      $future_total_damage = $future_talents_user->get_total_damage();
      $damage_diff = bcdiv(bcdiv(bcsub($future_total_damage, $current_total_damage, 40), $current_total_damage, 40), $next_talent_level_cost, 40);
      if ($this->debug) {
        $current_talent_damage = $talent->get_current_damage();
        echo "<br>" . $talent_name . " DPS diff of " . $damage_diff
        . "<br>future_total_damage: " . format($future_total_damage) . " current_total_damage: " . format($current_total_damage)
        . "<br>next_talent_level_cost: " . format($next_talent_level_cost) . " damage_diff: " . format($damage_diff)
        . "<br>current talent damage: " . format($current_talent_damage) . " future talent damage: " . format($future_talents_user->talents[$talent_name]->get_current_damage()) . "<br>";
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
    } else if ($talent->tier <=8 && $this->max_level_reached >= 3000) {
      $is_valid = true;
    }
    if ($this->hitting_level_cap == false) {
      if ($talent->name == 'extra_training' || $talent->name == 'kilo_leveling' || $talent->name == 'superior_training' || $talent->name == 'tenk_training') {
        $is_valid = false;
      }
    }
    if (($this->ignore_impatience == true && $talent->name == 'impatience')
      || ($this->ignore_must_be_magic == true && $talent->name == 'must_be_magic')
      || ($this->ignore_scars_to_your_powerful == true && $talent->name == 'scars_to_your_powerful')
      || ($this->ignore_front_line_fire == true && $talent->name == 'front_line_fire')
      || ($this->ignore_backline_defensive == true && $talent->name == 'backline_defensive')) {
      $is_valid = false;
    }

    if ($this->can_buy_olympian != 1 && $talent->name == 'olympian_training'
     || $this->can_buy_newt != 1 && $talent->name == 'arithmagician_newts') {
      $is_valid = false;
    }
    return $is_valid;
 }

  public function update($talent_to_update) {
    $this->talents[$talent_to_update]->current_level++;
    $this->talents_at_max = $this->get_max_talents();
    $this->total_talent_levels = $this->get_all_talent_levels();
    $this->talents['maxed_power']->stacks = $this->talents_at_max;
    $this->talents['level_all_the_way']->stacks = $this->total_talent_levels;
    if ($this->hitting_level_cap != false) {
      $this->main_dps_max_levels = 5000 + ($this->talents['extra_training']->current_level + $this->talents['superior_training']->current_level + $this->talents['tenk_training']->current_level + $this->talents['montage_training']->current_level + $this->talents['olympian_training']->current_level + $this->talents['magical_training']->current_level + max(0, ($this->talents['bonus_training']->current_level + 1) - $this->main_dps_slot)) * 25 + $this->main_dps_max_level_increase_from_runes;
      $this->talents['kilo_leveling']->stacks = floor($this->main_dps_max_levels/1000);
    }
  }

  public function get_dungeon_data($ledge) {
    $results = array();
    if ($this->dungeon_areas_per_hour < 1 || $this->areas_sprintable < 1 || $this->time_to_complete_sprint < 1) {
      return $results;
    }
    $next_highest_idol_ledge = $this->dungeon_idol_increment[$ledge];
    if ($ledge < $this->areas_sprintable) {
      $total_time = $this->time_to_complete_sprint / $this->areas_sprintable * $ledge;
    } else {
      $total_time = $this->time_to_complete_sprint + 60 * ($ledge - $this->areas_sprintable) / $this->dungeon_areas_per_hour;
    }
    $fp_idol_average = get_bi_drop_total($this->max_area_reached, $this->t2_11ths_completed);
    $idols_gained = bcmul(bcmul($this->total_idols, $next_highest_idol_ledge), $this->idol_buff);
    $idols_per_hour = $idols_gained / $total_time * 60;
    $idols_per_fp_time = $idols_per_hour / 60 * $this->time_to_complete_fp;
    $idol_over_fp = $idols_per_fp_time - $fp_idol_average * 2 * 1.25;
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
