<?php
#ceil(Base Cost * Multiplier ^ (n - 1))
include "cotli_talents_logic.php";

function print_value($input_name) {
  $return_value = '';
  if (!empty($_POST[$input_name])) {
    $return_value = $_POST[$input_name];
  }
  return $return_value;
}

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
    <td>Time-o-rama</td><td><input style="width:50px" type="text" name="time_o_rama" id="time_o_rama" value="<?php echo print_value("time_o_rama"); ?>"></td>
    <td>Massive Criticals</td><td><input style="width:50px" type="text" name="massive_criticals" value="<?php echo print_value("massive_criticals"); ?>"></td>
    <td>Golden Benefits</td><td><input style="width:50px" type="text" name="golden_benefits" value="<?php echo print_value("golden_benefits"); ?>"></td>
    <td>Super Clicks</td><td><input style="width:50px" type="text" name="super_clicks" value="<?php echo print_value("super_clicks"); ?>"></td>
    <td>Passive Criticals</td><td><input style="width:50px" type="text" name="passive_criticals" value="<?php echo print_value("passive_criticals"); ?>"></td>
    <td>Set Bonus</td><td><input style="width:50px" type="text" name="set_bonus" value="<?php echo print_value("set_bonus"); ?>"></td>
    <td>Every Last Cent</td><td><input style="width:50px" type="text" name="every_last_cent" value="<?php echo print_value("every_last_cent"); ?>"></td>
    <td>Apprentice Crafter</td><td><input style="width:50px" type="text" name="apprentice_crafter" value="<?php echo print_value("apprentice_crafter"); ?>"></td>
    <td>Scavenger</td><td><input style="width:50px" type="text" name="scavenger" value="<?php echo print_value("scavenger"); ?>"></td>
    <td>Impatience</td><td><input style="width:50px" type="text" name="impatience" value="<?php echo print_value("impatience"); ?>"></td>
    <td>Level All The Way</td><td><input style="width:50px" type="text" name="level_all_the_way" value="<?php echo print_value("level_all_the_way"); ?>"></td>
    <td>Mission Accomplished</td><td><input style="width:50px" type="text" name="mission_accomplished" value="<?php echo print_value("mission_accomplished"); ?>"></td>
  </tr>
  <tr>
    <td>Endurance Training</td><td><input style="width: 50px" type="text" name="endurance_training" value="<?php echo print_value("endurance_training"); ?>"></td>
    <td>Ride the Storm</td><td><input style="width:50px" type="text" name="ride_the_storm" value="<?php echo print_value("ride_the_storm"); ?>"</td>
    <td>Storm's Building</td><td><input style="width:50px" type="text" name="storms_building" value="<?php echo print_value("storms_building"); ?>"></td>
    <td>The More the Merrier</td><td><input style="width:50px" type="text" name="the_more_the_merrier" value="<?php echo print_value("the_more_the_merrier"); ?>"></td>
    <td>Overenchanted</td><td><input style="width:50px" type="text" name="overenchanted" value="<?php echo print_value("overenchanted"); ?>"></td>
    <td>Surplus Cooldown</td><td><input style="width:50px" type="text" name="surplus_cooldown" value="<?php echo print_value("surplus_cooldown"); ?>"></td>
    <td>Sharing is Caring</td><td><input style="width:50px" type="text" name="sharing_is_caring" value="<?php echo print_value("sharing_is_caring"); ?>"></td>
    <td>Task Mastery</td><td><input style="width:50px" type="text" name="task_mastery" value="<?php echo print_value("task_mastery"); ?>"></td>
    <td>Efficient Crusading</td><td><input style="width:50px" type="text" name="efficient_crusading" value="<?php echo print_value("efficient_crusading"); ?>"></td>
    <td>Nurturing</td><td><input style="width:50px" type="text" name="nurturing" value="<?php echo print_value("nurturing"); ?>"></td>
    <td>Prospector</td><td><input style="width:50px" type="text" name="prospector" value="<?php echo print_value("prospector"); ?>"></td>
    <td>Doing it Again</td><td><input style="width:50px" type="text" name="doing_it_again" value="<?php echo print_value("doing_it_again"); ?>"></td>
  </tr>
  <tr>
    <td>Gold-o-splosion</td><td><input style="width:50px" type="text" name="gold_o_splosion" value="<?php echo print_value("gold_o_splosion"); ?>"></td>
    <td>Speed Runner</td><td><input style="width:50px" type="text" name="speed_runner" value="<?php echo print_value("speed_runner"); ?>"</td>
    <td>Sniper</td><td><input style="width:50px" type="text" name="sniper" value="<?php echo print_value("sniper"); ?>"></td>
    <td>Higher Magnification</td><td><input style="width:50px" type="text" name="higher_magnification" value="<?php echo print_value("higher_magnification"); ?>"></td>
    <td>Fast Learners</td><td><input style="width:50px" type="text" name="fast_learners" value="<?php echo print_value("fast_learners"); ?>"></td>
    <td>Well Equiped</td><td><input style="width:50px" type="text" name="well_equiped" value="<?php echo print_value("well_equiped"); ?>"></td>
    <td>Swap Day</td><td><input style="width:50px" type="text" name="swap_day" value="<?php echo print_value("swap_day"); ?>"></td>
    <td>Synergy</td><td><input style="width:50px" type="text" name="synergy" value="<?php echo print_value("synergy"); ?>"></td>
    <td>Deep Idol Scavenger</td><td><input style="width:50px" type="text" name="deep_idol_scavenger" value="<?php echo print_value("deep_idol_scavenger"); ?>"></td>
    <td>Extra Training</td><td><input style="width:50px" type="text" name="extra_training" value="<?php echo print_value("extra_training"); ?>"></td>
    <td>Head Start</td><td><input style="width:50px" type="text" name="head_start" value="<?php echo print_value("head_start"); ?>"></td>
    <td>Triple Tier Trouble</td><td><input style="width:50px" type="text" name="triple_tier_trouble" value="<?php echo print_value("triple_tier_trouble"); ?>"></td>
  </tr>
  <tr>
    <td>Extended Spawns</td><td><input style="width:50px" type="text" name="extended_spawns" value="<?php echo print_value("extended_spawns"); ?>"></td>
    <td>Click-tastrophe</td><td><input style="width:50px" type="text" name="click_tastrophy" value="<?php echo print_value("click_tastrophy"); ?>"</td>
    <td>Instant Satisfaction</td><td><input style="width:50px" type="text" name="instant_satisfaction" value="<?php echo print_value("instant_satisfaction"); ?>"></td>
    <td>Extra Healthy</td><td><input style="width:50px" type="text" name="extra_healthy" value="<?php echo print_value("extra_healthy"); ?>"></td>
    <td>Legendary Benefits</td><td><input style="width:50px" type="text" name="legendary_benefits" value="<?php echo print_value("legendary_benefits"); ?>"></td>
    <td>Idols Over Time</td><td><input style="width:50px" type="text" name="idols_over_time" value="<?php echo print_value("idols_over_time"); ?>"></td>
    <td>Golden Age</td><td><input style="width:50px" type="text" name="golden_age" value="<?php echo print_value("golden_age"); ?>"></td>
    <td>Journeyman Crafter</td><td><input style="width:50px" type="text" name="journeyman_crafter" value="<?php echo print_value("journeyman_crafter"); ?>"></td>
    <td>Sprint Mode</td><td><input style="width:50px" type="text" name="sprint_mode" value="<?php echo print_value("sprint_mode"); ?>"></td>
    <td>Superior Training</td><td><input style="width:50px" type="text" name="superior_training" value="<?php echo print_value("superior_training"); ?>"></td>
    <td>Kilo Leveling</td><td><input style="width:50px" type="text" name="kilo_leveling" value="<?php echo print_value("kilo_leveling"); ?>"></td>
    <td>Fourth Time's The Charm</td><td><input style="width:50px" type="text" name="fourth_times_the_charm" value="<?php echo print_value("fourth_times_the_charm"); ?>"></td>
  </tr>
  <tr>
    <td>Mission Adrenaline</td><td><input style="width:50px" type="text" name="mission_adrenaline" value="<?php echo print_value("mission_adrenaline"); ?>"></td>
    <td>Lingering Buffs</td><td><input style="width:50px" type="text" name="lingering_buffs" value="<?php echo print_value("lingering_buffs"); ?>"</td>
    <td>Omniclicking</td><td><input style="width:50px" type="text" name="omniclicking" value="<?php echo print_value("omniclicking"); ?>"></td>
    <td>Bossing Around</td><td><input style="width:50px" type="text" name="bossing_around" value="<?php echo print_value("bossing_around"); ?>"></td>
    <td>Cheer Squad</td><td><input style="width:50px" type="text" name="cheer_squad" value="<?php echo print_value("cheer_squad"); ?>"></td>
    <td>Valuable Experience</td><td><input style="width:50px" type="text" name="valuable_experience" value="<?php echo print_value("valuable_experience"); ?>"></td>
    <td>Every Little Bit Helps</td><td><input style="width:50px" type="text" name="every_little_bit_helps" value="<?php echo print_value("every_little_bit_helps"); ?>"></td>
    <td>Jeweler</td><td><input style="width:50px" type="text" name="jeweler" value="<?php echo print_value("jeweler"); ?>"></td>
    <td>Idol Champions</td><td><input style="width:50px" type="text" name="idol_champions" value="<?php echo print_value("idol_champions"); ?>"></td>
    <td>10K Training</td><td><input style="width:50px" type="text" name="tenk_training" value="<?php echo print_value("tenk_training"); ?>"></td>
    <td>Bonus Training</td><td><input style="width:50px" type="text" name="bonus_training" value="<?php echo print_value("bonus_training"); ?>"></td>
    <td>Scrap Hoarder</td><td><input style="width:50px" type="text" name="scrap_hoarder" value="<?php echo print_value("scrap_hoarder"); ?>"></td>
  </tr>
  <tr>
    <td>Phase Skip</td><td><input style="width:50px" type="text" name="phase_skip" value="<?php echo print_value("phase_skip"); ?>"></td>
    <td>Weekend Warrior</td><td><input style="width:50px" type="text" name="weekend_warrior" value="<?php echo print_value("weekend_warrior"); ?>"></td>
    <td>Material Goods</td><td><input style="width:50px" type="text" name="material_goods" value="<?php echo print_value("material_goods"); ?>"></td>
    <td></td><td></td>
    <td>Big Earner</td><td><input style="width:50px" type="text" name="big_earner" value="<?php echo print_value("big_earner"); ?>"></td>
    <td>Maxed Power!</td><td><input style="width:50px" type="text" name="maxed_power" value="<?php echo print_value("maxed_power"); ?>"></td>
    <td>Idolatry</td><td><input style="width:50px" type="text" name="idolatry" value="<?php echo print_value("idolatry"); ?>"></td>
    <td>Master Crafter</td><td><input style="width:50px" type="text" name="master_crafter" value="<?php echo print_value("master_crafter"); ?>"></td>
    <td>Marathon Spring</td><td><input style="width:50px" type="text" name="marathon_sprint" value="<?php echo print_value("marathon_sprint"); ?>"></td>
    <td>Montage Training</td><td><input style="width:50px" type="text" name="montage_training" value="<?php echo print_value("montage_training"); ?>"></td>
    <td>Arithmagician</td><td><input style="width:50px" type="text" name="arithmagician" value="<?php echo print_value("arithmagician"); ?>"></td>
    <td>Cash In Hand</td><td><input style="width:50px" type="text" name="cash_in_hand" value="<?php echo print_value("cash_in_hand"); ?>"></td>
  </tr>
  <tr>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td>Legendary Friendship</td><td><input style="width:50px" type="text" name="legendary_friendship" value="<?php echo print_value("legendary_friendship"); ?>"></td>
    <td>Golden Friendship</td><td><input style="width:50px" type="text" name="golden_friendship" value="<?php echo print_value("golden_friendship"); ?>"></td>
    <td>Friendly Helpers</td><td><input style="width:50px" type="text" name="friendly_helpers" value="<?php echo print_value("friendly_helpers"); ?>"></td>
    <td></td><td></td>
    <td>Sprint for the Finish</td><td><input style="width:50px" type="text" name="sprint_for_the_finish" value="<?php echo print_value("sprint_for_the_finish"); ?>"></td>
    <td>Magical Training</td><td><input style="width:50px" type="text" name="magical_training" value="<?php echo print_value("magical_training"); ?>"></td>
    <td></td><td></td>
    <td></td><td></td>
  </tr>
</table>
Total Idols: <input type="text" name="total_idols" value="<?php echo print_value("total_idols"); ?>"><br>
Golden Items: <input type="text" name="golden_items" value="<?php echo print_value("golden_items"); ?>"><br>
Common + Uncommon Recipies: <input type="text" name="common_and_uncommon_recipies" value="<?php echo print_value("common_and_uncommon_recipies"); ?>"><br>
Rare Recipies: <input type="text" name="rare_recipies" value="<?php echo print_value("rare_recipies"); ?>"><br>
Epic Recipies: <input type="text" name="epic_recipies" value="<?php echo print_value("epic_recipies"); ?>"><br>
Missions Accomplished: <input type="text" name="missions_accomplished" value="<?php echo print_value("missions_accomplished"); ?>"><br>
Legendaries: <input type="text" name="legendaries" value="<?php echo print_value("legendaries"); ?>"><br>
Brass Rings: <input type="text" name="brass_rings" value="<?php echo print_value("brass_rings"); ?>"><br>
Silver Rings: <input type="text" name="silver_rings" value="<?php echo print_value("silver_rings"); ?>"><br>
Golden Rings: <input type="text" name="golden_rings" value="<?php echo print_value("golden_rings"); ?>"><br>
Diamond Rings: <input type="text" name="diamond_rings" value="<?php echo print_value("diamond_rings"); ?>"><br>
Average Mission Completion in 8h: <input type="text" name="average_mission_completion" value="<?php echo print_value("average_mission_completion"); ?>"><br>
Main DPS Slot: <input type="text" name="main_dps_slot" value="<?php echo print_value("main_dps_slot"); ?>"><br>
Cooldown Reduction%: <input type="text" name="cooldown_reduction" value="<?php echo print_value("cooldown_reduction"); ?>"><br>
EP from main DPS: <input type="text" name="ep_from_main_dps" value="<?php echo print_value("ep_from_main_dps"); ?>"><br>
EP from Benched Crusaders: <input type="text" name="ep_from_benched_crusaders" value="<?php echo print_value("ep_from_benched_crusaders"); ?>"><br>
Epics on main DPS: <input type="text" name="epics_on_main_dps" value="<?php echo print_value("epics_on_main_dps"); ?>"><br>
Epics on Benched Crusaders: <input type="text" name="epics_on_benched_crusaders" value="<?php echo print_value("epics_on_benched_crusaders"); ?>"><br>
Storm Rider Gear Bonus: <input type="text" name="storm_rider_gear_bonus" value="<?php echo print_value("storm_rider_gear_bonus"); ?>"><br>
Main DPS benched crusaders legendaries: <input type="text" name="main_dps_benched_crusaders_legendaries" value="<?php echo print_value("main_dps_benched_crusaders_legendaries"); ?>"><br>
Main DPS benched crusaders golden gear: <input type="text" name="main_dps_benched_crusaders_golden_gear" value="<?php echo print_value("main_dps_benched_crusaders_golden_gear"); ?>"><br>
Taskmasters owned: <input type="text" name="taskmasters_owned" value="<?php echo print_value("taskmasters_owned"); ?>"><br>
Clicks per second: <input type="text" name="clicks_per_second" value="<?php echo print_value("clicks_per_second"); ?>"><br>
Crusaders owned: <input type="text" name="crusaders_owned" value="<?php echo print_value("crusaders_owned"); ?>"><br>
Crusaders in formation: <input type="text" name="crusaders_in_formation" value="<?php echo print_value("crusaders_in_formation"); ?>"><br>
Critical chance: <input type="text" name="critical_chance" value="<?php echo print_value("critical_chance"); ?>"><br>
Click damage per DPS: <input type="text" name="click_damage_per_dps" value="<?php echo print_value("click_damage_per_dps"); ?>"><br>
<input type="submit">
</form>

</body>
</html>
