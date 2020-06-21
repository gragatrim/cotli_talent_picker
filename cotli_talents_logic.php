<?php
if ($_POST) {
  $time_o_rama_talent = new Talent(20, 25, 1.25, $_POST['time_o_rama']);
  $massive_criticals_talent = new Talent(25, 50, 1.25, $_POST['massive_criticals']);
  $golden_benefits_talent = new Talent(-1, 1500, 1.061, $_POST['golden_benefits'], '+', $_POST['golden_items']);
  $super_clicks_talent = new Talent(25, 50, 1.1, $_POST['super_clicks']);
  $endurance_training_talent = new Talent(20, 50, 1.25, $_POST['endurance_training']);
  $ride_the_storm_talent = new Talent(25, 100,1.15, $_POST['ride_the_storm']);
  $storms_building_talent = new Talent(15, 100,1.33, $_POST['storms_building']);
  $the_more_the_merrier_talent = new Talent(30, 4500,1.163, $_POST['the_more_the_merrier']);
  $gold_o_splosion_talent = new Talent(25,500, 1.15, $_POST['gold_o_splosion']);
  $speed_runner_talent = new Talent(10, 1000, 1.63, $_POST['speed_runner']);
  $sniper_talent = new Talent(40, 200, 1.1, $_POST['sniper']);
  $higher_magnification_talent = new Talent(10, 2000, 1.5, $_POST['higher_magnification']);
  $extended_spawns_talent = new Talent(40, 10000, 1.13, $_POST['extended_spawns']);
  $click_tastrophy_talent = new Talent(40, 2500,1.2, $_POST['click_tastrophy']);
  $instant_satisfaction_talent = new Talent(21, 7500,1.3333, $_POST['instant_satisfaction']);
  $extra_healhty_talent = new Talent(50, 1500,1.305, $_POST['extra_healthy']);
  $mission_adrenaline_talent = new Talent(50, 125000,1.153, $_POST['mission_adrenaline']);
  $lingering_buffs_talent = new Talent(10, 1000000,2, $_POST['lingering_buffs']);
  $omniclicking_talent = new Talent(25, 75000,1.322, $_POST['omniclicking']);
  $bossing_around_talent = new Talent(2, 40000000,13999., $_POST['bossing_around']);
  $phase_skip_talent = new Talent(10, 30000000,1.2, $_POST['phase_skip']);
  $weekend_warrior_talent = new Talent(25, 750000000,1.31, $_POST['weekend_warrior']);
  $material_goods_talent = new Talent(40, 30000000,1.2, $_POST['material_goods']);
  $passive_criticals_talent = new Talent(50, 10,1.1, $_POST['passive_criticals']);
  $set_bonus_talent = new Talent(50, 25, 1.1, $_POST['set_bonus']);
  $every_last_cent_talent = new Talent(20, 50,1.25, $_POST['every_last_cent']);
  $apprentice_crafter_talent = new Talent(-1, 200,1.1, $_POST['apprentice_crafter'], '+', $_POST['common_and_uncommon_recipies']);
  $overenchanted_talent = new Talent(50, 100,1.1, $_POST['overenchanted']);
  $surplus_cooldown_talent = new Talent(50, 100,1.1, $_POST['surplus_cooldown']);
  $sharing_is_caring_talent = new Talent(14, 500,1.25, $_POST['sharing_is_caring']);
  $task_mastery_talent = new Talent(20, 100,1.32, $_POST['task_mastery']);
  $fast_learners_talent = new Talent(18, 250,1.2, $_POST['fast_learners']);
  $well_equiped_talent = new Talent(50, 500,1.075, $_POST['well_equiped']);
  $swap_day_talent = new Talent(50, 500,1.075, $_POST['swap_day']);
  $synergy_talent = new Talent(20, 300,1.85, $_POST['synergy']);
  $legendary_benefits_talent = new Talent(50, 10000,1.1, $_POST['legendary_benefits']);
  $idols_over_time_talent = new Talent(20, 4000,1.4, $_POST['idols_over_time']);
  $golden_age_talent = new Talent(50, 7500,1.12, $_POST['golden_age']);
  $journeyman_crafter_talent = new Talent(-1, 200000,1.061, $_POST['journeyman_crafter'], '+', $_POST['rare_recipies']);
  $cheer_squad_talent = new Talent(50, 166000,1.165, $_POST['cheer_squad']);
  $valuable_experience_talent = new Talent(45, 500000,1.132, $_POST['valuable_experience']);
  $every_little_bit_helps_talent = new Talent(500, 25000,1.022, $_POST['every_little_bit_helps'], '*', 1, 5);
  $jeweler_talent = new Talent(20, 80000,1.5, $_POST['jeweler']);
  $big_earner_talent = new Talent(10, 250000000,1.9, $_POST['big_earner']);
  //TODO Count maxed talents and update
  $maxed_power_talent = new Talent(50, 75000000,1.3, $_POST['maxed_power'], '+', '0');
  $idolatry_talent = new Talent(20, 50000000,1.5, $_POST['idolatry'], '*', $_POST['total_idols'], 10);
  $master_crafter_talent = new Talent(-1, 900000000,1.28, $_POST['master_crafter'], '+', $_POST['epic_recipies']);
  $legendary_friendship_talent = new Talent(25, 7500000000,1.56, $_POST['legendary_friendship']);
  $golden_friendship_talent = new Talent(25, 8000000000,1.395, $_POST['golden_friendship']);
  $friendly_helpers_talent = new Talent(50, 500000000,1.26, $_POST['friendly_helpers'], '*', $_POST['taskmasters_owned'], 10);
  $scavenger_talent = new Talent(50, 25, 1.1, $_POST['scavenger']);
  $impatience_talent = new Talent(20, 25, 1.25, $_POST['impatience']);
  //TODO Count total levels purchased and update
  $level_all_the_way_talent = new Talent(50, 200,1.11, $_POST['level_all_the_way'], '+', 0);
  $mission_accomplished_talent = new Talent(-1, 500,1.19, $_POST['mission_accomplished'], '+', $_POST['missions_accomplished']);
  $efficient_crusading_talent = new Talent(25, 50,1.1, $_POST['efficient_crusading']);
  $nurturing_talent = new Talent(20, 1000, 1.06, $_POST['nurturing']);
  $prospector_talent = new Talent(10, 300, 1.6, $_POST['prospector']);
  $doing_it_again_talent = new Talent(1, 1000,0, $_POST['doing_it_again']);
  $deep_idol_scavenger_talent = new Talent(25, 500,1.15, $_POST['deep_idol_scavenger']);
  $extra_training_talent = new Talent(40, 1000, 1.075, $_POST['extra_training'], '*', 400);
  $head_start_talent = new Talent(1, 10000, 0, $_POST['head_start']);
  $triple_tier_trouble_talent = new Talent(1, 5000, 0, $_POST['triple_tier_trouble']);
  $sprint_mode_talent = new Talent(10, 25000, 2, $_POST['sprint_mode']);
  $superior_training_talent = new Talent(80, 5000, 1.0888, $_POST['superior_training'], '*', 400);
  $kilo_leveling_talent = new Talent(5, 500000, 4, $_POST['kilo_leveling']);
  $fourth_times_the_charm_talent = new Talent(1, 25000, 0, $_POST['fourth_times_the_charm']);
  $idol_champions_talent = new Talent(40, 50000, 1.211, $_POST['idol_champions']);
  $tenk_training_talent = new Talent(80, 140000, 1.083, $_POST['tenk_training'], '*', 400);
  $bonus_training_talent = new Talent(24, 225000, 1.31, $_POST['bonus_training']);
  $scrap_hoarder_talent = new Talent(3, 15000000, 2, $_POST['scrap_hoarder']);
  $marathon_sprint_talent = new Talent(20, 123000000, 1.5, $_POST['marathon_sprint']);
  $montage_training_talent = new Talent(120, 35000000, 1.065, $_POST['montage_training'], '*', 400);
  $arithmagician_talent = new Talent(19, 500000000, 'arithmagician', $_POST['arithmagician']);
  $cash_in_hand_talent = new Talent(10, 40000000, 2.5, $_POST['cash_in_hand']);
  $sprint_for_the_finish_talent = new Talent(30, 200000000000, 1.2275, $_POST['sprint_for_the_finish']);
  $magical_training_talent = new Talent(-1, 20000000000, 1.285, $_POST['magical_training'], '*', 400);
  $base_damage = 1;
  echo $_POST['golden_benefits'] . " means " . $golden_benefits_talent->get_current_damage() . "% gain<br>";
  echo "Friendly Helpers lvl " . $friendly_helpers_talent->current_level . " means " . $friendly_helpers_talent->get_current_damage() . "% gain<br>";
  echo "Every little bit helps lvl " . $every_little_bit_helps_talent->current_level . " means " . $every_little_bit_helps_talent->get_current_damage() . "% gain<br>";
  echo "Friendly Helpers next level cost is " . $friendly_helpers_talent->get_next_level_cost() . " <br>";
  echo "Arithmagician next level cost is " . $arithmagician_talent->get_next_level_cost() . " <br>";
  echo "Final Damage " . $base_damage * $golden_benefits_talent->get_current_damage() . "<br>";
  echo "Next golden benefits level will cost " . $golden_benefits_talent->get_next_level_cost() . " idols.<br>";
  echo "Next bossing around level will cost " . $bossing_around_talent->get_next_level_cost() . " idols.<br>";
  echo "Next cheer squad level will cost " . $cheer_squad_talent->get_next_level_cost() . " idols.<br>";
}

class Talent {
  function __construct($max_level, $base_cost, $level_multiplier, $current_level, $damage_type = '', $damage_multiplier = '', $multiplicative_damage_base = '', $effect = '') {
    $this->max_level = $max_level;
    $this->base_cost = $base_cost;
    $this->level_multiplier = $level_multiplier;
    $this->current_level = $current_level;
    $this->damage_type = $damage_type;
    $this->damage_multiplier = $damage_multiplier;
    $this->multiplicative_damage_base = $multiplicative_damage_base;
    $this->effect = $effect;
  }

  public function get_current_level() {
    return $this->current_level;
  }

  public function get_current_damage() {
    $damage = 0;
    if ($this->damage_type == '+') {
      $damage = $this->current_level * $this->damage_multiplier;
    } else if ($this->damage_type == '*') {
      $owned_taskmaster_damage = (pow(1 + (.1 * $_POST['friendly_helpers']), $_POST['taskmasters_owned']) - 1) * 100;
      $damage = (pow(1 + $this->multiplicative_damage_base * $this->damage_multiplier / 100, $this->current_level) - 1) * 100;
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
