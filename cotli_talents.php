<?php
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
    <td>Time-o-rama</td><td><input style="width:50px" type="text" name="time_o_rama" id="time_o_rama" value="<?php echo $user->talents['time_o_rama']->current_level; ?>"></td>
    <td>Massive Criticals</td><td><input style="width:50px" type="text" name="massive_criticals" value="<?php echo $user->talents['massive_criticals']->current_level; ?>"></td>
    <td>Golden Benefits</td><td><input style="width:50px" type="text" name="golden_benefits" value="<?php echo $user->talents['golden_benefits']->current_level; ?>"></td>
    <td>Super Clicks</td><td><input style="width:50px" type="text" name="super_clicks" value="<?php echo $user->talents['super_clicks']->current_level; ?>"></td>
    <td>Passive Criticals</td><td><input style="width:50px" type="text" name="passive_criticals" value="<?php echo $user->talents['passive_criticals']->current_level; ?>"></td>
    <td>Set Bonus</td><td><input style="width:50px" type="text" name="set_bonus" value="<?php echo $user->talents['set_bonus']->current_level; ?>"></td>
    <td>Every Last Cent</td><td><input style="width:50px" type="text" name="every_last_cent" value="<?php echo $user->talents['every_last_cent']->current_level; ?>"></td>
    <td>Apprentice Crafter</td><td><input style="width:50px" type="text" name="apprentice_crafter" value="<?php echo $user->talents['apprentice_crafter']->current_level; ?>"></td>
    <td>Scavenger</td><td><input style="width:50px" type="text" name="scavenger" value="<?php echo $user->talents['scavenger']->current_level; ?>"></td>
    <td>Impatience</td><td><input style="width:50px" type="text" name="impatience" value="<?php echo $user->talents['impatience']->current_level; ?>"></td>
    <td>Level All The Way</td><td><input style="width:50px" type="text" name="level_all_the_way" value="<?php echo $user->talents['level_all_the_way']->current_level; ?>"></td>
    <td>Mission Accomplished</td><td><input style="width:50px" type="text" name="mission_accomplished" value="<?php echo $user->talents['mission_accomplished']->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Endurance Training</td><td><input style="width: 50px" type="text" name="endurance_training" value="<?php echo $user->talents['endurance_training']->current_level; ?>"></td>
    <td>Ride the Storm</td><td><input style="width:50px" type="text" name="ride_the_storm" value="<?php echo $user->talents['ride_the_storm']->current_level; ?>"</td>
    <td>Storm's Building</td><td><input style="width:50px" type="text" name="storms_building" value="<?php echo $user->talents['storms_building']->current_level; ?>"></td>
    <td>The More the Merrier</td><td><input style="width:50px" type="text" name="the_more_the_merrier" value="<?php echo $user->talents['the_more_the_merrier']->current_level; ?>"></td>
    <td>Overenchanted</td><td><input style="width:50px" type="text" name="overenchanted" value="<?php echo $user->talents['overenchanted']->current_level; ?>"></td>
    <td>Surplus Cooldown</td><td><input style="width:50px" type="text" name="surplus_cooldown" value="<?php echo $user->talents['surplus_cooldown']->current_level; ?>"></td>
    <td>Sharing is Caring</td><td><input style="width:50px" type="text" name="sharing_is_caring" value="<?php echo $user->talents['sharing_is_caring']->current_level; ?>"></td>
    <td>Task Mastery</td><td><input style="width:50px" type="text" name="task_mastery" value="<?php echo $user->talents['task_mastery']->current_level; ?>"></td>
    <td>Efficient Crusading</td><td><input style="width:50px" type="text" name="efficient_crusading" value="<?php echo $user->talents['efficient_crusading']->current_level; ?>"></td>
    <td>Nurturing</td><td><input style="width:50px" type="text" name="nurturing" value="<?php echo $user->talents['nurturing']->current_level; ?>"></td>
    <td>Prospector</td><td><input style="width:50px" type="text" name="prospector" value="<?php echo $user->talents['prospector']->current_level; ?>"></td>
    <td>Doing it Again</td><td><input style="width:50px" type="text" name="doing_it_again" value="<?php echo $user->talents['doing_it_again']->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Gold-o-splosion</td><td><input style="width:50px" type="text" name="gold_o_splosion" value="<?php echo $user->talents['gold_o_splosion']->current_level; ?>"></td>
    <td>Speed Runner</td><td><input style="width:50px" type="text" name="speed_runner" value="<?php echo $user->talents['speed_runner']->current_level; ?>"</td>
    <td>Sniper</td><td><input style="width:50px" type="text" name="sniper" value="<?php echo $user->talents['sniper']->current_level; ?>"></td>
    <td>Higher Magnification</td><td><input style="width:50px" type="text" name="higher_magnification" value="<?php echo $user->talents['higher_magnification']->current_level; ?>"></td>
    <td>Fast Learners</td><td><input style="width:50px" type="text" name="fast_learners" value="<?php echo $user->talents['fast_learners']->current_level; ?>"></td>
    <td>Well Equiped</td><td><input style="width:50px" type="text" name="well_equiped" value="<?php echo $user->talents['well_equiped']->current_level; ?>"></td>
    <td>Swap Day</td><td><input style="width:50px" type="text" name="swap_day" value="<?php echo $user->talents['swap_day']->current_level; ?>"></td>
    <td>Synergy</td><td><input style="width:50px" type="text" name="synergy" value="<?php echo $user->talents['synergy']->current_level; ?>"></td>
    <td>Deep Idol Scavenger</td><td><input style="width:50px" type="text" name="deep_idol_scavenger" value="<?php echo $user->talents['deep_idol_scavenger']->current_level; ?>"></td>
    <td>Extra Training</td><td><input style="width:50px" type="text" name="extra_training" value="<?php echo $user->talents['extra_training']->current_level; ?>"></td>
    <td>Head Start</td><td><input style="width:50px" type="text" name="head_start" value="<?php echo $user->talents['head_start']->current_level; ?>"></td>
    <td>Triple Tier Trouble</td><td><input style="width:50px" type="text" name="triple_tier_trouble" value="<?php echo $user->talents['triple_tier_trouble']->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Extended Spawns</td><td><input style="width:50px" type="text" name="extended_spawns" value="<?php echo $user->talents['extended_spawns']->current_level; ?>"></td>
    <td>Click-tastrophe</td><td><input style="width:50px" type="text" name="click_tastrophy" value="<?php echo $user->talents['click_tastrophy']->current_level; ?>"</td>
    <td>Instant Satisfaction</td><td><input style="width:50px" type="text" name="instant_satisfaction" value="<?php echo $user->talents['instant_satisfaction']->current_level; ?>"></td>
    <td>Extra Healthy</td><td><input style="width:50px" type="text" name="extra_healthy" value="<?php echo $user->talents['extra_healthy']->current_level; ?>"></td>
    <td>Legendary Benefits</td><td><input style="width:50px" type="text" name="legendary_benefits" value="<?php echo $user->talents['legendary_benefits']->current_level; ?>"></td>
    <td>Idols Over Time</td><td><input style="width:50px" type="text" name="idols_over_time" value="<?php echo $user->talents['idols_over_time']->current_level; ?>"></td>
    <td>Golden Age</td><td><input style="width:50px" type="text" name="golden_age" value="<?php echo $user->talents['golden_age']->current_level; ?>"></td>
    <td>Journeyman Crafter</td><td><input style="width:50px" type="text" name="journeyman_crafter" value="<?php echo $user->talents['journeyman_crafter']->current_level; ?>"></td>
    <td>Sprint Mode</td><td><input style="width:50px" type="text" name="sprint_mode" value="<?php echo $user->talents['sprint_mode']->current_level; ?>"></td>
    <td>Superior Training</td><td><input style="width:50px" type="text" name="superior_training" value="<?php echo $user->talents['superior_training']->current_level; ?>"></td>
    <td>Kilo Leveling</td><td><input style="width:50px" type="text" name="kilo_leveling" value="<?php echo $user->talents['kilo_leveling']->current_level; ?>"></td>
    <td>Fourth Time's The Charm</td><td><input style="width:50px" type="text" name="fourth_times_the_charm" value="<?php echo $user->talents['fourth_times_the_charm']->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Mission Adrenaline</td><td><input style="width:50px" type="text" name="mission_adrenaline" value="<?php echo $user->talents['mission_adrenaline']->current_level; ?>"></td>
    <td>Lingering Buffs</td><td><input style="width:50px" type="text" name="lingering_buffs" value="<?php echo $user->talents['lingering_buffs']->current_level; ?>"</td>
    <td>Omniclicking</td><td><input style="width:50px" type="text" name="omniclicking" value="<?php echo $user->talents['omniclicking']->current_level; ?>"></td>
    <td>Bossing Around</td><td><input style="width:50px" type="text" name="bossing_around" value="<?php echo $user->talents['bossing_around']->current_level; ?>"></td>
    <td>Cheer Squad</td><td><input style="width:50px" type="text" name="cheer_squad" value="<?php echo $user->talents['cheer_squad']->current_level; ?>"></td>
    <td>Valuable Experience</td><td><input style="width:50px" type="text" name="valuable_experience" value="<?php echo $user->talents['valuable_experience']->current_level; ?>"></td>
    <td>Every Little Bit Helps</td><td><input style="width:50px" type="text" name="every_little_bit_helps" value="<?php echo $user->talents['every_little_bit_helps']->current_level; ?>"></td>
    <td>Jeweler</td><td><input style="width:50px" type="text" name="jeweler" value="<?php echo $user->talents['jeweler']->current_level; ?>"></td>
    <td>Idol Champions</td><td><input style="width:50px" type="text" name="idol_champions" value="<?php echo $user->talents['idol_champions']->current_level; ?>"></td>
    <td>10K Training</td><td><input style="width:50px" type="text" name="tenk_training" value="<?php echo $user->talents['tenk_training']->current_level; ?>"></td>
    <td>Bonus Training</td><td><input style="width:50px" type="text" name="bonus_training" value="<?php echo $user->talents['bonus_training']->current_level ?>"></td>
    <td>Scrap Hoarder</td><td><input style="width:50px" type="text" name="scrap_hoarder" value="<?php echo $user->talents['scrap_hoarder']->current_level; ?>"></td>
  </tr>
  <tr>
    <td>Phase Skip</td><td><input style="width:50px" type="text" name="phase_skip" value="<?php echo $user->talents['phase_skip']->current_level; ?>"></td>
    <td>Weekend Warrior</td><td><input style="width:50px" type="text" name="weekend_warrior" value="<?php echo $user->talents['weekend_warrior']->current_level; ?>"></td>
    <td>Material Goods</td><td><input style="width:50px" type="text" name="material_goods" value="<?php echo $user->talents['material_goods']->current_level; ?>"></td>
    <td></td><td></td>
    <td>Big Earner</td><td><input style="width:50px" type="text" name="big_earner" value="<?php echo $user->talents['big_earner']->current_level; ?>"></td>
    <td>Maxed Power!</td><td><input style="width:50px" type="text" name="maxed_power" value="<?php echo $user->talents['maxed_power']->current_level; ?>"></td>
    <td>Idolatry</td><td><input style="width:50px" type="text" name="idolatry" value="<?php echo $user->talents['idolatry']->current_level; ?>"></td>
    <td>Master Crafter</td><td><input style="width:50px" type="text" name="master_crafter" value="<?php echo $user->talents['master_crafter']->current_level; ?>"></td>
    <td>Marathon Sprint</td><td><input style="width:50px" type="text" name="marathon_sprint" value="<?php echo $user->talents['marathon_sprint']->current_level; ?>"></td>
    <td>Montage Training</td><td><input style="width:50px" type="text" name="montage_training" value="<?php echo $user->talents['montage_training']->current_level; ?>"></td>
    <td>Arithmagician</td><td><input style="width:50px" type="text" name="arithmagician" value="<?php echo $user->talents['arithmagician']->current_level; ?>"></td>
    <td>Cash In Hand</td><td><input style="width:50px" type="text" name="cash_in_hand" value="<?php echo $user->talents['cash_in_hand']->current_level; ?>"></td>
  </tr>
  <tr>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td>Legendary Friendship</td><td><input style="width:50px" type="text" name="legendary_friendship" value="<?php echo $user->talents['legendary_friendship']->current_level; ?>"></td>
    <td>Golden Friendship</td><td><input style="width:50px" type="text" name="golden_friendship" value="<?php echo $user->talents['golden_friendship']->current_level; ?>"></td>
    <td>Friendly Helpers</td><td><input style="width:50px" type="text" name="friendly_helpers" value="<?php echo $user->talents['friendly_helpers']->current_level; ?>"></td>
    <td></td><td></td>
    <td>Sprint for the Finish</td><td><input style="width:50px" type="text" name="sprint_for_the_finish" value="<?php echo $user->talents['sprint_for_the_finish']->current_level; ?>"></td>
    <td>Magical Training</td><td><input style="width:50px" type="text" name="magical_training" value="<?php echo $user->talents['magical_training']->current_level; ?>"></td>
    <td></td><td></td>
    <td></td><td></td>
  </tr>
</table>
<?php
  if (!empty($results_to_print)) {
    echo $results_to_print;
  }
?>
Total Idols: <input type="text" name="total_idols" value="<?php echo $user->total_idols; ?>"><br>
Talents to Recommend: <input type="text" name="talents_to_recommend" value="<?php echo $user->talents_to_recommend; ?>"><br>
Max level Reached: <input type="text" name="max_level_reached" value="<?php echo $user->max_level_reached; ?>"><br>
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
