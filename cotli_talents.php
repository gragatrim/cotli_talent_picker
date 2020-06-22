<?php
#ceil(Base Cost * Multiplier ^ (n - 1))
include "cotli_talents_logic.php";
?>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<table>
  <tr>
    <th colspan="8">Active</th>
    <th colspan="8">Passive</th>
    <th colspan="8">Utility</th>
  <tr>
    <td>Time-o-rama</td><td><input style="width:50px" type="text" name="time_o_rama" id="time_o_rama" value="<?php echo $time_o_rama_talent->current_level; ?>"></td>
    <td>Massive Criticals</td><td><input style="width:50px" type="text" name="massive_criticals" value="<?php echo $massive_criticals_talent->current_level; ?>"></td>
    <td>Golden Benefits</td><td><input style="width:50px" type="text" name="golden_benefits" value="<?php echo $golden_benefits_talent->current_level; ?>"></td>
    <td>Super Clicks</td><td><input style="width:50px" type="text" name="super_clicks" value="<?php echo $super_clicks_talent->current_level; ?>"></td>
    <td>Passive Criticals</td><td><input style="width:50px" type="text" name="passive_criticals" value="<?php echo $passive_criticals_talent->current_level; ?>"></td>
    <td>Set Bonus</td><td><input style="width:50px" type="text" name="set_bonus" value="<?php echo $set_bonus_talent->current_level; ?>"></td>
    <td>Every Last Cent</td><td><input style="width:50px" type="text" name="every_last_cent" value="<?php echo $every_last_cent_talent->current_level; ?>"></td>
    <td>Apprentice Crafter</td><td><input style="width:50px" type="text" name="apprentice_crafter" value="<?php echo $apprentice_crafter_talent->current_level; ?>"></td>
    <td>Scavenger</td><td><input style="width:50px" type="text" name="scavenger" value="<?php echo $scavenger_talent->current_level; ?>"></td>
    <td>Impatience</td><td><input style="width:50px" type="text" name="impatience" value="<?php echo $impatience_talent->current_level; ?>"></td>
    <td>Level All The Way</td><td><input style="width:50px" type="text" name="level_all_the_way" value="<?php echo $level_all_the_way_talent->current_level; ?>"></td>
    <td>Mission Accomplished</td><td><input style="width:50px" type="text" name="mission_accomplished" value="<?php echo $mission_accomplished_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Endurance Training</td><td><input style="width: 50px" type="text" name="endurance_training" value="<?php echo $endurance_training_talent->current_level; ?>"></td>
    <td>Ride the Storm</td><td><input style="width:50px" type="text" name="ride_the_storm" value="<?php echo $ride_the_storm_talent->current_level; ?>"</td>
    <td>Storm's Building</td><td><input style="width:50px" type="text" name="storms_building" value="<?php echo $storms_building_talent->current_level; ?>"></td>
    <td>The More the Merrier</td><td><input style="width:50px" type="text" name="the_more_the_merrier" value="<?php echo $the_more_the_merrier_talent->current_level; ?>"></td>
    <td>Overenchanted</td><td><input style="width:50px" type="text" name="overenchanted" value="<?php echo $overenchanted_talent->current_level; ?>"></td>
    <td>Surplus Cooldown</td><td><input style="width:50px" type="text" name="surplus_cooldown" value="<?php echo $surplus_cooldown_talent->current_level; ?>"></td>
    <td>Sharing is Caring</td><td><input style="width:50px" type="text" name="sharing_is_caring" value="<?php echo $sharing_is_caring_talent->current_level; ?>"></td>
    <td>Task Mastery</td><td><input style="width:50px" type="text" name="task_mastery" value="<?php echo $task_mastery_talent->current_level; ?>"></td>
    <td>Efficient Crusading</td><td><input style="width:50px" type="text" name="efficient_crusading" value="<?php echo $efficient_crusading_talent->current_level; ?>"></td>
    <td>Nurturing</td><td><input style="width:50px" type="text" name="nurturing" value="<?php echo $nurturing_talent->current_level; ?>"></td>
    <td>Prospector</td><td><input style="width:50px" type="text" name="prospector" value="<?php echo $prospector_talent->current_level; ?>"></td>
    <td>Doing it Again</td><td><input style="width:50px" type="text" name="doing_it_again" value="<?php echo $doing_it_again_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Gold-o-splosion</td><td><input style="width:50px" type="text" name="gold_o_splosion" value="<?php echo $gold_o_splosion_talent->current_level; ?>"></td>
    <td>Speed Runner</td><td><input style="width:50px" type="text" name="speed_runner" value="<?php echo $speed_runner_talent->current_level; ?>"</td>
    <td>Sniper</td><td><input style="width:50px" type="text" name="sniper" value="<?php echo $sniper_talent->current_level; ?>"></td>
    <td>Higher Magnification</td><td><input style="width:50px" type="text" name="higher_magnification" value="<?php echo $higher_magnification_talent->current_level; ?>"></td>
    <td>Fast Learners</td><td><input style="width:50px" type="text" name="fast_learners" value="<?php echo $fast_learners_talent->current_level; ?>"></td>
    <td>Well Equiped</td><td><input style="width:50px" type="text" name="well_equiped" value="<?php echo $well_equiped_talent->current_level; ?>"></td>
    <td>Swap Day</td><td><input style="width:50px" type="text" name="swap_day" value="<?php echo $swap_day_talent->current_level; ?>"></td>
    <td>Synergy</td><td><input style="width:50px" type="text" name="synergy" value="<?php echo $synergy_talent->current_level; ?>"></td>
    <td>Deep Idol Scavenger</td><td><input style="width:50px" type="text" name="deep_idol_scavenger" value="<?php echo $deep_idol_scavenger_talent->current_level; ?>"></td>
    <td>Extra Training</td><td><input style="width:50px" type="text" name="extra_training" value="<?php echo $extra_training_talent->current_level; ?>"></td>
    <td>Head Start</td><td><input style="width:50px" type="text" name="head_start" value="<?php echo $head_start_talent->current_level; ?>"></td>
    <td>Triple Tier Trouble</td><td><input style="width:50px" type="text" name="triple_tier_trouble" value="<?php echo $triple_tier_trouble_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Extended Spawns</td><td><input style="width:50px" type="text" name="extended_spawns" value="<?php echo $extended_spawns_talent->current_level; ?>"></td>
    <td>Click-tastrophe</td><td><input style="width:50px" type="text" name="click_tastrophy" value="<?php echo $click_tastrophy_talent->current_level; ?>"</td>
    <td>Instant Satisfaction</td><td><input style="width:50px" type="text" name="instant_satisfaction" value="<?php echo $instant_satisfaction_talent->current_level; ?>"></td>
    <td>Extra Healthy</td><td><input style="width:50px" type="text" name="extra_healthy" value="<?php echo $extra_healthy_talent->current_level; ?>"></td>
    <td>Legendary Benefits</td><td><input style="width:50px" type="text" name="legendary_benefits" value="<?php echo $legendary_benefits_talent->current_level; ?>"></td>
    <td>Idols Over Time</td><td><input style="width:50px" type="text" name="idols_over_time" value="<?php echo $idols_over_time_talent->current_level; ?>"></td>
    <td>Golden Age</td><td><input style="width:50px" type="text" name="golden_age" value="<?php echo $golden_age_talent->current_level; ?>"></td>
    <td>Journeyman Crafter</td><td><input style="width:50px" type="text" name="journeyman_crafter" value="<?php echo $journeyman_crafter_talent->current_level; ?>"></td>
    <td>Sprint Mode</td><td><input style="width:50px" type="text" name="sprint_mode" value="<?php echo $sprint_mode_talent->current_level; ?>"></td>
    <td>Superior Training</td><td><input style="width:50px" type="text" name="superior_training" value="<?php echo $superior_training_talent->current_level; ?>"></td>
    <td>Kilo Leveling</td><td><input style="width:50px" type="text" name="kilo_leveling" value="<?php echo $kilo_leveling_talent->current_level; ?>"></td>
    <td>Fourth Time's The Charm</td><td><input style="width:50px" type="text" name="fourth_times_the_charm" value="<?php echo $fourth_times_the_charm_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Mission Adrenaline</td><td><input style="width:50px" type="text" name="mission_adrenaline" value="<?php echo $mission_adrenaline_talent->current_level; ?>"></td>
    <td>Lingering Buffs</td><td><input style="width:50px" type="text" name="lingering_buffs" value="<?php echo $lingering_buffs_talent->current_level; ?>"</td>
    <td>Omniclicking</td><td><input style="width:50px" type="text" name="omniclicking" value="<?php echo $omniclicking_talent->current_level; ?>"></td>
    <td>Bossing Around</td><td><input style="width:50px" type="text" name="bossing_around" value="<?php echo $bossing_around_talent->current_level; ?>"></td>
    <td>Cheer Squad</td><td><input style="width:50px" type="text" name="cheer_squad" value="<?php echo $cheer_squad_talent->current_level; ?>"></td>
    <td>Valuable Experience</td><td><input style="width:50px" type="text" name="valuable_experience" value="<?php echo $valuable_experience_talent->current_level; ?>"></td>
    <td>Every Little Bit Helps</td><td><input style="width:50px" type="text" name="every_little_bit_helps" value="<?php echo $every_little_bit_helps_talent->current_level; ?>"></td>
    <td>Jeweler</td><td><input style="width:50px" type="text" name="jeweler" value="<?php echo $jeweler_talent->current_level; ?>"></td>
    <td>Idol Champions</td><td><input style="width:50px" type="text" name="idol_champions" value="<?php echo $idol_champions_talent->current_level; ?>"></td>
    <td>10K Training</td><td><input style="width:50px" type="text" name="tenk_training" value="<?php echo $tenk_training_talent->current_level; ?>"></td>
    <td>Bonus Training</td><td><input style="width:50px" type="text" name="bonus_training" value="<?php echo $bonus_training_talent->current_level ?>"></td>
    <td>Scrap Hoarder</td><td><input style="width:50px" type="text" name="scrap_hoarder" value="<?php echo $scrap_hoarder_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Phase Skip</td><td><input style="width:50px" type="text" name="phase_skip" value="<?php echo $phase_skip_talent->current_level; ?>"></td>
    <td>Weekend Warrior</td><td><input style="width:50px" type="text" name="weekend_warrior" value="<?php echo $weekend_warrior_talent->current_level; ?>"></td>
    <td>Material Goods</td><td><input style="width:50px" type="text" name="material_goods" value="<?php echo $material_goods_talent->current_level; ?>"></td>
    <td></td><td></td>
    <td>Big Earner</td><td><input style="width:50px" type="text" name="big_earner" value="<?php echo $big_earner_talent->current_level; ?>"></td>
    <td>Maxed Power!</td><td><input style="width:50px" type="text" name="maxed_power" value="<?php echo $maxed_power_talent->current_level; ?>"></td>
    <td>Idolatry</td><td><input style="width:50px" type="text" name="idolatry" value="<?php echo $idolatry_talent->current_level; ?>"></td>
    <td>Master Crafter</td><td><input style="width:50px" type="text" name="master_crafter" value="<?php echo $master_crafter_talent->current_level; ?>"></td>
    <td>Marathon Sprint</td><td><input style="width:50px" type="text" name="marathon_sprint" value="<?php echo $marathon_sprint_talent->current_level; ?>"></td>
    <td>Montage Training</td><td><input style="width:50px" type="text" name="montage_training" value="<?php echo $montage_training_talent->current_level; ?>"></td>
    <td>Arithmagician</td><td><input style="width:50px" type="text" name="arithmagician" value="<?php echo $arithmagician_talent->current_level; ?>"></td>
    <td>Cash In Hand</td><td><input style="width:50px" type="text" name="cash_in_hand" value="<?php echo $cash_in_hand_talent->current_level; ?>"></td>
  </tr>
  <tr>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td>Legendary Friendship</td><td><input style="width:50px" type="text" name="legendary_friendship" value="<?php echo $legendary_friendship_talent->current_level; ?>"></td>
    <td>Golden Friendship</td><td><input style="width:50px" type="text" name="golden_friendship" value="<?php echo $golden_friendship_talent->current_level; ?>"></td>
    <td>Friendly Helpers</td><td><input style="width:50px" type="text" name="friendly_helpers" value="<?php echo $friendly_helpers_talent->current_level; ?>"></td>
    <td></td><td></td>
    <td>Sprint for the Finish</td><td><input style="width:50px" type="text" name="sprint_for_the_finish" value="<?php echo $sprint_for_the_finish_talent->current_level; ?>"></td>
    <td>Magical Training</td><td><input style="width:50px" type="text" name="magical_training" value="<?php echo $magical_training_talent->current_level; ?>"></td>
    <td></td><td></td>
    <td></td><td></td>
  </tr>
</table>
Total Idols: <input type="text" name="total_idols" value="<?php echo $user->total_idols; ?>"><br>
Golden Items: <input type="text" name="golden_items" value="<?php echo $user->golden_items; ?>"><br>
Common + Uncommon Recipies: <input type="text" name="common_and_uncommon_recipies" value="<?php echo $user->common_and_uncommon_recipies; ?>"><br>
Rare Recipies: <input type="text" name="rare_recipies" value="<?php echo $user->rare_recipies; ?>"><br>
Epic Recipies: <input type="text" name="epic_recipies" value="<?php echo $user->epic_recipies; ?>"><br>
Missions Accomplished: <input type="text" name="missions_accomplished" value="<?php echo $user->missions_accomplished; ?>"><br>
Legendaries: <input type="text" name="legendaries" value="<?php echo $user->legendaries; ?>"><br>
Brass Rings: <input type="text" name="brass_rings" value="<?php echo $user->brass_rings; ?>"><br>
Silver Rings: <input type="text" name="silver_rings" value="<?php echo $user->silver_rings; ?>"><br>
Golden Rings: <input type="text" name="golden_rings" value="<?php echo $user->golden_rings; ?>"><br>
Diamond Rings: <input type="text" name="diamond_rings" value="<?php echo $user->diamond_rings; ?>"><br>
Average Mission Completion in 8h: <input type="text" name="average_mission_completion" value="<?php echo $user->average_mission_completion; ?>"><br>
Main DPS Slot: <input type="text" name="main_dps_slot" value="<?php echo $user->main_dps_slot; ?>"><br>
Cooldown Reduction%: <input type="text" name="cooldown_reduction" value="<?php echo $user->cooldown_reduction; ?>"><br>
EP from main DPS: <input type="text" name="ep_from_main_dps" value="<?php echo $user->ep_from_main_dps; ?>"><br>
EP from Benched Crusaders: <input type="text" name="ep_from_benched_crusaders" value="<?php echo $user->ep_from_benched_crusaders; ?>"><br>
Epics on main DPS: <input type="text" name="epics_on_main_dps" value="<?php echo $user->epics_on_main_dps; ?>"><br>
Epics on Benched Crusaders: <input type="text" name="epics_on_benched_crusaders" value="<?php echo $user->epics_on_benched_crusaders; ?>"><br>
Storm Rider Gear Bonus: <input type="text" name="storm_rider_gear_bonus" value="<?php echo $user->storm_rider_gear_bonus; ?>"><br>
Main DPS benched crusaders legendaries: <input type="text" name="main_dps_benched_crusaders_legendaries" value="<?php echo $user->main_dps_benched_crusaders_legendaries; ?>"><br>
Main DPS benched crusaders golden gear: <input type="text" name="main_dps_benched_crusaders_golden_gear" value="<?php echo $user->main_dps_benched_crusaders_golden_gear; ?>"><br>
Taskmasters owned: <input type="text" name="taskmasters_owned" value="<?php echo $user->taskmasters_owned; ?>"><br>
Clicks per second: <input type="text" name="clicks_per_second" value="<?php echo $user->clicks_per_second; ?>"><br>
Crusaders owned: <input type="text" name="crusaders_owned" value="<?php echo $user->crusaders_owned; ?>"><br>
Crusaders in formation: <input type="text" name="crusaders_in_formation" value="<?php echo $user->crusaders_in_formation; ?>"><br>
Critical chance: <input type="text" name="critical_chance" value="<?php echo $user->critical_chance; ?>"><br>
Click damage per DPS: <input type="text" name="click_damage_per_dps" value="<?php echo $user->click_damage_per_dps; ?>"><br>
Gold bonus provided by crusaders: <input type="text" name="gold_bonus_provided_by_crusaders" value="<?php echo $user->gold_bonus_provided_by_crusaders; ?>"><br>
<input type="submit">
</form>

</body>
</html>
