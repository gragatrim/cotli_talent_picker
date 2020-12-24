<?php

//Semi global, mainly I'm just lazy, if you add to these arrays, you must add it to the dps_talents array in the talent constructor
$fully_implemented_talents = array(119, 3, 66, 63, 118, 92, 120, 5, 16, 17, 23, 31, 54, 121, 34, 36, 39, 41, 56, 122, 74, 104, 106, 107, 114, 115, 105, 111, 112, 113, 73);
$partially_implemented_talents = array(55, 102 );
class Talent {
  function __construct($id, $name, $tier, $max_level, $base_cost, $level_multiplier, $current_level = 0, $damage_type = '', $damage_base = 0, $damage_base_multiplier = 1, $stacks = 1, $main_dps_slot = 0, $level_costs = array()) {
    $this->id = $id;
    $this->name = $name;
    $this->tier = $tier;
    $this->max_level = $max_level;
    $this->base_cost = $base_cost;
    $this->level_multiplier = $level_multiplier;
    $this->current_level = (is_numeric($current_level) ? $current_level : 0);
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
    $this->level_costs = $level_costs;
    $this->dps_talents = array(119, 3, 66, 63, 118, 92, 120, 5, 16, 17, 23, 31, 54, 121, 34, 36, 39, 41, 56, 122, 74, 104, 106, 107, 114, 115, 105, 111, 112, 113, 73, 55, 102);
  }

  public function get_damage_at_additional_level($levels_to_add) {
    $damage = '0';
    $this->current_level += $levels_to_add;
    $damage = $this->get_current_damage();
    $this->current_level -= $levels_to_add;
    return $damage;
  }

  public function get_current_damage() {
    if (!in_array($this->id, $this->dps_talents)) {
      return 0;
    }
    $damage = '1';
    if ($this->damage_type == '+') {
      $damage = $this->get_additive_damage();
    } else if ($this->damage_type == '*') {
      $damage = $this->get_multiplicative_damage();
    }
    if ($this->name == 'extra_training'
     || $this->name == 'superior_training'
     || $this->name == 'tenk_training'
     || ($this->name == 'bonus_training' && $this->current_level >= $this->main_dps_slot)
     || $this->name == 'montage_training'
     || $this->name == 'magical_training') {
      $return_damage = $damage;
    } else {
      $return_damage = bcsub($damage, 100, 40);
    }
    return $return_damage;
  }

  function get_additive_damage() {
    $damage = '0';
    if ($this->name == 'overenchanted') {
      $damage = bcmul(bcmul(bcadd(bcdiv(bcmul($this->damage_base, $this->current_level, 40), 100, 40), 1, 40), $this->stacks, 40), 25, 40);
    } else {
      $damage = bcadd(bcmul(bcadd(bcmul(bcsub($this->current_level, 1, 40), $this->damage_base_multiplier, 40), $this->damage_base, 40), $this->stacks, 40), 100, 40);
    }
    return $damage;
  }

  function get_multiplicative_damage() {
    $damage = '0';
    //All other talents use current level as the multiplier, just every little bit helps use it as the stack
    if ($this->name == 'every_little_bit_helps') {
      $this->stacks = $this->current_level;
    } else if ($this->name == 'front_line_fire'
            || $this->name == 'must_be_magic') {
      $this->stacks = ($this->current_level - 1);
    } else if ($this->name == 'dressing_for_success') {
        $this->damage_base = (2 * $this->current_level);
        $this->damage_base_multiplier = (2 * $this->current_level);
    } else if ($this->name == 'formation_full_up') {
      $this->stacks = $this->current_level - 1;
    } else if ($this->name != 'apprentice_crafter'
      && $this->name != 'journeyman_crafter'
      && $this->name != 'master_crafter'
      && $this->current_level != $this->damage_base_multiplier) {
      $this->damage_base_multiplier = $this->current_level;
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
      $damage = bcpow($level_multiplier, $this->current_level, 40);
    } else if ($this->name == 'cheer_squad') {
      $damage = bcadd(bcmul($this->current_level, $this->stacks, 40), 100, 40);
    } else if ($this->name == 'kilo_leveling') {
      $damage = bcmul(bcpow(bcmul($this->damage_base, $this->damage_base_multiplier, 40), $this->stacks, 40), 100, 40);
    } else if ($this->name == 'dressing_for_success' || $this->name == 'trinket_hoarder') {
      $damage = bcmul(bcmul(bcadd('1', bcdiv(($this->damage_base + 2), '100', 20)), bcpow(bcadd(bcdiv($this->damage_base_multiplier, 100, 20), 1, 20), ($this->stacks - 1), 20)), 100, 20);
    } else if ($this->name == 'front_line_fire' || $this->name == 'formation_full_up' || $this->name == 'must_be_magic') {
      $damage = bcmul(bcmul(bcpow(bcadd(bcdiv($this->damage_base_multiplier, 100, 40), 1, 40), $this->stacks, 40), 100, 40), bcadd(bcdiv($this->damage_base, 100, 40), 1, 40));
    } else if ($this->name == 'apprentice_crafter' || $this->name == 'journeyman_crafter' || $this->name == 'master_crafter') {
      $damage = bcmul(bcadd(bcmul(bcsub(bcpow(bcadd(bcdiv($this->damage_base_multiplier, 100, 40), 1, 40), $this->current_level, 40), 1, 40), $this->stacks, 40), 1, 40), 100, 40);
    } else {
      $damage = bcmul(bcpow(bcadd('1', bcmul(bcdiv($this->damage_base, '100', 20), $this->damage_base_multiplier, 20), 20), $this->stacks, 20), 100, 20);
    }
    return $damage;
  }

  public function get_cost_at_level($level) {
    $level_cost = '0';
    if ($level < $this->max_level || $this->max_level == -1) {
      if ($this->level_multiplier != 'arithmagician'
        && $this->name != 'bossing_around') {
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
      } else if ($this->level_multiplier == 'arithmagician') {
        $level_cost = $this->arith_cost[$level];
      } else {
        //Bossing around
        $level_cost = $this->level_costs[$level+1];
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
