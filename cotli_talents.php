<?php
include "cotli_talents_logic.php";
?>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

.hidden {
  display: none;
}

.green {
  background: green;
}

.red {
  background: red;
}

.yellow {
  background: yellow;
}

.legend {
  width: 350px;
}
</style>
</head>
<body>

<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div class="green legend">Green background means it's implemented </div><div class="yellow legend">Yellow background means it's mostly implemented </div><div class="red legend">Red background means it's not implemented</div>
<table>
  <tr>
    <th colspan="8">Active</th>
    <th colspan="8">Passive</th>
    <th colspan="8">Utility</th>
  <tr>
    <td class="red">Time-o-rama</td><td><input style="width:50px" type="text" name="time_o_rama" id="time_o_rama" value="<?php echo $user->talents['time_o_rama']->current_level; ?>"></td>
    <td class="red">Massive Criticals</td><td><input style="width:50px" type="text" name="massive_criticals" value="<?php echo $user->talents['massive_criticals']->current_level; ?>"></td>
    <td class="green">Golden Benefits</td><td><input style="width:50px" type="text" name="golden_benefits" value="<?php echo $user->talents['golden_benefits']->current_level; ?>"></td>
    <td class="red">Super Clicks</td><td><input style="width:50px" type="text" name="super_clicks" value="<?php echo $user->talents['super_clicks']->current_level; ?>"></td>
    <td class="green">Passive Criticals</td><td><input style="width:50px" type="text" name="passive_criticals" value="<?php echo $user->talents['passive_criticals']->current_level; ?>"></td>
    <td class="green">Set Bonus</td><td><input style="width:50px" type="text" name="set_bonus" value="<?php echo $user->talents['set_bonus']->current_level; ?>"></td>
    <td class="red">Every Last Cent</td><td><input style="width:50px" type="text" name="every_last_cent" value="<?php echo $user->talents['every_last_cent']->current_level; ?>"></td>
    <td class="green">Apprentice Crafter</td><td><input style="width:50px" type="text" name="apprentice_crafter" value="<?php echo $user->talents['apprentice_crafter']->current_level; ?>"></td>
    <td class="red">Scavenger</td><td><input style="width:50px" type="text" name="scavenger" value="<?php echo $user->talents['scavenger']->current_level; ?>"></td>
    <td class="red">Impatience</td><td><input style="width:50px" type="text" name="impatience" value="<?php echo $user->talents['impatience']->current_level; ?>"></td>
    <td class="green">Level All The Way</td><td><input style="width:50px" type="text" name="level_all_the_way" value="<?php echo $user->talents['level_all_the_way']->current_level; ?>"></td>
    <td class="green">Mission Accomplished</td><td><input style="width:50px" type="text" name="mission_accomplished" value="<?php echo $user->talents['mission_accomplished']->current_level; ?>"></td>
  </tr>
  <tr>
    <td class="red">Endurance Training</td><td><input style="width: 50px" type="text" name="endurance_training" value="<?php echo $user->talents['endurance_training']->current_level; ?>"></td>
    <td class="red">Ride the Storm</td><td><input style="width:50px" type="text" name="ride_the_storm" value="<?php echo $user->talents['ride_the_storm']->current_level; ?>"</td>
    <td class="red">Storm's Building</td><td><input style="width:50px" type="text" name="storms_building" value="<?php echo $user->talents['storms_building']->current_level; ?>"></td>
    <td class="red">The More the Merrier</td><td><input style="width:50px" type="text" name="the_more_the_merrier" value="<?php echo $user->talents['the_more_the_merrier']->current_level; ?>"></td>
    <td class="green">Overenchanted</td><td><input style="width:50px" type="text" name="overenchanted" value="<?php echo $user->talents['overenchanted']->current_level; ?>"></td>
    <td class="green">Surplus Cooldown</td><td><input style="width:50px" type="text" name="surplus_cooldown" value="<?php echo $user->talents['surplus_cooldown']->current_level; ?>"></td>
    <td class="green">Sharing is Caring</td><td><input style="width:50px" type="text" name="sharing_is_caring" value="<?php echo $user->talents['sharing_is_caring']->current_level; ?>"></td>
    <td class="red">Task Mastery</td><td><input style="width:50px" type="text" name="task_mastery" value="<?php echo $user->talents['task_mastery']->current_level; ?>"></td>
    <td class="red">Efficient Crusading</td><td><input style="width:50px" type="text" name="efficient_crusading" value="<?php echo $user->talents['efficient_crusading']->current_level; ?>"></td>
    <td class="red">Nurturing</td><td><input style="width:50px" type="text" name="nurturing" value="<?php echo $user->talents['nurturing']->current_level; ?>"></td>
    <td class="red">Prospector</td><td><input style="width:50px" type="text" name="prospector" value="<?php echo $user->talents['prospector']->current_level; ?>"></td>
    <td class="red">Doing it Again</td><td><input style="width:50px" type="text" name="doing_it_again" value="<?php echo $user->talents['doing_it_again']->current_level; ?>"></td>
  </tr>
  <tr>
    <td class="red">Gold-o-splosion</td><td><input style="width:50px" type="text" name="gold_o_splosion" value="<?php echo $user->talents['gold_o_splosion']->current_level; ?>"></td>
    <td class="red">Speed Runner</td><td><input style="width:50px" type="text" name="speed_runner" value="<?php echo $user->talents['speed_runner']->current_level; ?>"</td>
    <td class="red">Sniper</td><td><input style="width:50px" type="text" name="sniper" value="<?php echo $user->talents['sniper']->current_level; ?>"></td>
    <td class="red">Higher Magnification</td><td><input style="width:50px" type="text" name="higher_magnification" value="<?php echo $user->talents['higher_magnification']->current_level; ?>"></td>
    <td class="red">Fast Learners</td><td><input style="width:50px" type="text" name="fast_learners" value="<?php echo $user->talents['fast_learners']->current_level; ?>"></td>
    <td class="green">Well Equiped</td><td><input style="width:50px" type="text" name="well_equiped" value="<?php echo $user->talents['well_equiped']->current_level; ?>"></td>
    <td class="green">Swap Day</td><td><input style="width:50px" type="text" name="swap_day" value="<?php echo $user->talents['swap_day']->current_level; ?>"></td>
    <td class="red">Synergy</td><td><input style="width:50px" type="text" name="synergy" value="<?php echo $user->talents['synergy']->current_level; ?>"></td>
    <td class="red">Deep Idol Scavenger</td><td><input style="width:50px" type="text" name="deep_idol_scavenger" value="<?php echo $user->talents['deep_idol_scavenger']->current_level; ?>"></td>
    <td class="green">Extra Training</td><td><input style="width:50px" type="text" name="extra_training" value="<?php echo $user->talents['extra_training']->current_level; ?>"></td>
    <td class="red">Head Start</td><td><input style="width:50px" type="text" name="head_start" value="<?php echo $user->talents['head_start']->current_level; ?>"></td>
    <td class="red">Triple Tier Trouble</td><td><input style="width:50px" type="text" name="triple_tier_trouble" value="<?php echo $user->talents['triple_tier_trouble']->current_level; ?>"></td>
  </tr>
  <tr>
    <td class="red">Extended Spawns</td><td><input style="width:50px" type="text" name="extended_spawns" value="<?php echo $user->talents['extended_spawns']->current_level; ?>"></td>
    <td class="red">Click-tastrophe</td><td><input style="width:50px" type="text" name="click_tastrophy" value="<?php echo $user->talents['click_tastrophy']->current_level; ?>"</td>
    <td class="red">Instant Satisfaction</td><td><input style="width:50px" type="text" name="instant_satisfaction" value="<?php echo $user->talents['instant_satisfaction']->current_level; ?>"></td>
    <td class="red">Extra Healthy</td><td><input style="width:50px" type="text" name="extra_healthy" value="<?php echo $user->talents['extra_healthy']->current_level; ?>"></td>
    <td class="green">Legendary Benefits</td><td><input style="width:50px" type="text" name="legendary_benefits" value="<?php echo $user->talents['legendary_benefits']->current_level; ?>"></td>
    <td class="red">Idols Over Time</td><td><input style="width:50px" type="text" name="idols_over_time" value="<?php echo $user->talents['idols_over_time']->current_level; ?>"></td>
    <td class="green">Golden Age</td><td><input style="width:50px" type="text" name="golden_age" value="<?php echo $user->talents['golden_age']->current_level; ?>"></td>
    <td class="green">Journeyman Crafter</td><td><input style="width:50px" type="text" name="journeyman_crafter" value="<?php echo $user->talents['journeyman_crafter']->current_level; ?>"></td>
    <td class="red">Sprint Mode</td><td><input style="width:50px" type="text" name="sprint_mode" value="<?php echo $user->talents['sprint_mode']->current_level; ?>"></td>
    <td class="green">Superior Training</td><td><input style="width:50px" type="text" name="superior_training" value="<?php echo $user->talents['superior_training']->current_level; ?>"></td>
    <td class="yellow">Kilo Leveling</td><td><input style="width:50px" type="text" name="kilo_leveling" value="<?php echo $user->talents['kilo_leveling']->current_level; ?>"></td>
    <td class="red">Fourth Time's The Charm</td><td><input style="width:50px" type="text" name="fourth_times_the_charm" value="<?php echo $user->talents['fourth_times_the_charm']->current_level; ?>"></td>
  </tr>
  <tr>
    <td class="red">Mission Adrenaline</td><td><input style="width:50px" type="text" name="mission_adrenaline" value="<?php echo $user->talents['mission_adrenaline']->current_level; ?>"></td>
    <td class="red">Lingering Buffs</td><td><input style="width:50px" type="text" name="lingering_buffs" value="<?php echo $user->talents['lingering_buffs']->current_level; ?>"</td>
    <td class="red">Omniclicking</td><td><input style="width:50px" type="text" name="omniclicking" value="<?php echo $user->talents['omniclicking']->current_level; ?>"></td>
    <td class="red">Bossing Around</td><td><input style="width:50px" type="text" name="bossing_around" value="<?php echo $user->talents['bossing_around']->current_level; ?>"></td>
    <td class="green">Cheer Squad</td><td><input style="width:50px" type="text" name="cheer_squad" value="<?php echo $user->talents['cheer_squad']->current_level; ?>"></td>
    <td class="red">Valuable Experience</td><td><input style="width:50px" type="text" name="valuable_experience" value="<?php echo $user->talents['valuable_experience']->current_level; ?>"></td>
    <td class="green">Every Little Bit Helps</td><td><input style="width:50px" type="text" name="every_little_bit_helps" value="<?php echo $user->talents['every_little_bit_helps']->current_level; ?>"></td>
    <td class="red">Jeweler</td><td><input style="width:50px" type="text" name="jeweler" value="<?php echo $user->talents['jeweler']->current_level; ?>"></td>
    <td class="red">Idol Champions</td><td><input style="width:50px" type="text" name="idol_champions" value="<?php echo $user->talents['idol_champions']->current_level; ?>"></td>
    <td class="green">10K Training</td><td><input style="width:50px" type="text" name="tenk_training" value="<?php echo $user->talents['tenk_training']->current_level; ?>"></td>
    <td class="green">Bonus Training</td><td><input style="width:50px" type="text" name="bonus_training" value="<?php echo $user->talents['bonus_training']->current_level ?>"></td>
    <td class="red">Scrap Hoarder</td><td><input style="width:50px" type="text" name="scrap_hoarder" value="<?php echo $user->talents['scrap_hoarder']->current_level; ?>"></td>
  </tr>
  <tr>
    <td class="red">Phase Skip</td><td><input style="width:50px" type="text" name="phase_skip" value="<?php echo $user->talents['phase_skip']->current_level; ?>"></td>
    <td class="red">Weekend Warrior</td><td><input style="width:50px" type="text" name="weekend_warrior" value="<?php echo $user->talents['weekend_warrior']->current_level; ?>"></td>
    <td class="red">Material Goods</td><td><input style="width:50px" type="text" name="material_goods" value="<?php echo $user->talents['material_goods']->current_level; ?>"></td>
    <td></td><td></td>
    <td class="red">Big Earner</td><td><input style="width:50px" type="text" name="big_earner" value="<?php echo $user->talents['big_earner']->current_level; ?>"></td>
    <td class="yellow">Maxed Power!</td><td><input style="width:50px" type="text" name="maxed_power" value="<?php echo $user->talents['maxed_power']->current_level; ?>"></td>
    <td class="green">Idolatry</td><td><input style="width:50px" type="text" name="idolatry" value="<?php echo $user->talents['idolatry']->current_level; ?>"></td>
    <td class="green">Master Crafter</td><td><input style="width:50px" type="text" name="master_crafter" value="<?php echo $user->talents['master_crafter']->current_level; ?>"></td>
    <td class="red">Marathon Sprint</td><td><input style="width:50px" type="text" name="marathon_sprint" value="<?php echo $user->talents['marathon_sprint']->current_level; ?>"></td>
    <td class="green">Montage Training</td><td><input style="width:50px" type="text" name="montage_training" value="<?php echo $user->talents['montage_training']->current_level; ?>"></td>
    <td class="red">Arithmagician</td><td><input style="width:50px" type="text" name="arithmagician" value="<?php echo $user->talents['arithmagician']->current_level; ?>"></td>
    <td class="red">Cash In Hand</td><td><input style="width:50px" type="text" name="cash_in_hand" value="<?php echo $user->talents['cash_in_hand']->current_level; ?>"></td>
  </tr>
  <tr>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td class="green">Legendary Friendship</td><td><input style="width:50px" type="text" name="legendary_friendship" value="<?php echo $user->talents['legendary_friendship']->current_level; ?>"></td>
    <td class="green">Golden Friendship</td><td><input style="width:50px" type="text" name="golden_friendship" value="<?php echo $user->talents['golden_friendship']->current_level; ?>"></td>
    <td class="green">Friendly Helpers</td><td><input style="width:50px" type="text" name="friendly_helpers" value="<?php echo $user->talents['friendly_helpers']->current_level; ?>"></td>
    <td></td><td></td>
    <td class="red">Sprint for the Finish</td><td><input style="width:50px" type="text" name="sprint_for_the_finish" value="<?php echo $user->talents['sprint_for_the_finish']->current_level; ?>"></td>
    <td class="green">Magical Training</td><td><input style="width:50px" type="text" name="magical_training" value="<?php echo $user->talents['magical_training']->current_level; ?>"></td>
    <td></td><td></td>
    <td></td><td></td>
  </tr>
</table>
<?php
  if (!empty($results_to_print)) {
    echo $results_to_print;
  }
?>
Total Idols: <input type="text" name="total_idols" value="<?php echo (isset($user->total_idols) ? $user->total_idols : 0); ?>"> Debug: <input type="checkbox" name="debug" value="true" <?php echo (isset($_POST['debug']) ? "checked" : ''); ?>><br>
Talents to Recommend: <input type="text" name="talents_to_recommend" value="<?php echo (isset($user->talents_to_recommend) ? $user->talents_to_recommend : 0); ?>"><br>
Max level Reached: <input type="text" name="max_level_reached" value="<?php echo (isset($user->max_level_reached) ? $user->max_level_reached : 0); ?>"><br>
Golden Items: <input type="text" name="golden_items" value="<?php echo (isset($user->golden_items) ? $user->golden_items : 0); ?>"><br>
Common + Uncommon Recipies: <input type="text" name="common_and_uncommon_recipies" value="<?php echo (isset($user->common_and_uncommon_recipies) ? $user->common_and_uncommon_recipies : 0); ?>"><br>
Rare Recipies: <input type="text" name="rare_recipies" value="<?php echo (isset($user->rare_recipies) ? $user->rare_recipies : 0); ?>"><br>
Epic Recipies: <input type="text" name="epic_recipies" value="<?php echo (isset($user->epic_recipies) ? $user->epic_recipies : 0); ?>"><br>
Missions Accomplished: <input type="text" name="missions_accomplished" value="<?php echo (isset($user->missions_accomplished) ? $user->missions_accomplished : 0); ?>"><br>
Legendaries: <input type="text" name="legendaries" value="<?php echo (isset($user->legendaries) ? $user->legendaries : 0); ?>"><br>
Brass Rings: <input type="text" name="brass_rings" value="<?php echo (isset($user->brass_rings) ? $user->brass_rings : 0); ?>"><br>
Silver Rings: <input type="text" name="silver_rings" value="<?php echo (isset($user->silver_rings) ? $user->silver_rings : 0); ?>"><br>
Golden Rings: <input type="text" name="golden_rings" value="<?php echo (isset($user->golden_rings) ? $user->golden_rings : 0); ?>"><br>
Diamond Rings: <input type="text" name="diamond_rings" value="<?php echo (isset($user->diamond_rings) ? $user->diamond_rings : 0); ?>"><br>
<div class="hidden" >Average Mission Completion in 8h: <input type="text" name="average_mission_completion" value="<?php echo (isset($user->average_mission_completion) ? $user->average_mission_completion : 0); ?>"><br></div>
Main DPS Slot: <input type="text" name="main_dps_slot" value="<?php echo (isset($user->main_dps_slot) ? $user->main_dps_slot : 0); ?>"><br>
<div class="hidden" >Cooldown Reduction%: <input type="text" name="cooldown_reduction" value="<?php echo (isset($user->cooldown_reduction) ? $user->cooldown_reduction : 0); ?>"><br></div>
EP from main DPS: <input type="text" name="ep_from_main_dps" value="<?php echo (isset($user->ep_from_main_dps) ? $user->ep_from_main_dps : 0); ?>"><br>
EP from Benched Crusaders: <input type="text" name="ep_from_benched_crusaders" value="<?php echo (isset($user->ep_from_benched_crusaders) ? $user->ep_from_benched_crusaders : 0); ?>"><br>
Epics on main DPS: <input type="text" name="epics_on_main_dps" value="<?php echo (isset($user->epics_on_main_dps) ? $user->epics_on_main_dps : 0); ?>"><br>
Epics on Benched Crusaders: <input type="text" name="epics_on_benched_crusaders" value="<?php echo (isset($user->epics_on_benched_crusaders) ? $user->epics_on_benched_crusaders : 0); ?>"><br>
<div class="hidden" >Storm Rider Gear Bonus: <input type="text" name="storm_rider_gear_bonus" value="<?php echo (isset($user->storm_rider_gear_bonus) ? $user->storm_rider_gear_bonus : 0); ?>"><br></div>
Main DPS benched crusaders legendaries: <input type="text" name="main_dps_benched_crusaders_legendaries" value="<?php echo (isset($user->main_dps_benched_crusaders_legendaries) ? $user->main_dps_benched_crusaders_legendaries : 0); ?>"><br>
Main DPS benched crusaders golden gear: <input type="text" name="main_dps_benched_crusaders_golden_gear" value="<?php echo (isset($user->main_dps_benched_crusaders_golden_gear) ? $user->main_dps_benched_crusaders_golden_gear : 0); ?>"><br>
Taskmasters owned: <input type="text" name="taskmasters_owned" value="<?php echo (isset($user->taskmasters_owned) ? $user->taskmasters_owned : 0); ?>"><br>
<div class="hidden" >Clicks per second: <input type="text" name="clicks_per_second" value="<?php echo (isset($user->clicks_per_second) ? $user->clicks_per_second : 0); ?>"><br></div>
Crusaders owned: <input type="text" name="crusaders_owned" value="<?php echo (isset($user->crusaders_owned) ? $user->crusaders_owned : 0); ?>"><br>
Crusaders in formation: <input type="text" name="crusaders_in_formation" value="<?php echo (isset($user->crusaders_in_formation) ? $user->crusaders_in_formation : 0); ?>"><br>
Critical chance: <input type="text" name="critical_chance" value="<?php echo (isset($user->critical_chance) ? $user->critical_chance : 0); ?>"><br>
<div class="hidden" >Click damage per DPS: <input type="text" name="click_damage_per_dps" value="<?php echo (isset($user->click_damage_per_dps) ? $user->click_damage_per_dps : 0); ?>"><br></div>
Gold bonus provided by crusaders: <input type="text" name="gold_bonus_provided_by_crusaders" value="<?php echo (isset($user->gold_bonus_provided_by_crusaders) ? $user->gold_bonus_provided_by_crusaders : 0); ?>"><br>
<input type="submit">
</form>

</body>
</html>
