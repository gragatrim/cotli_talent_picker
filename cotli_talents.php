<?php
include "navigation.php";
include "cotli_talents_logic.php";
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div class="purple legend">Purple background means it's implemented </div><div class="blue legend">Blue background means it's mostly implemented </div><div class="brown legend">Brown background means it's not implemented</div>
<table>
  <tr>
    <th colspan="8">Active</th>
    <th colspan="8">Passive</th>
    <th colspan="8">Utility</th>
  <tr>
    <td class="brown">Time-o-rama</td><td><input style="width:50px" type="text" name="time_o_rama" id="time_o_rama" value="<?php echo $user->get_talent_value('time_o_rama'); ?>"></td>
    <td class="brown">Massive Criticals</td><td><input style="width:50px" type="text" name="massive_criticals" value="<?php echo $user->get_talent_value('massive_criticals'); ?>"></td>
    <td class="purple">Golden Benefits</td><td><input style="width:50px" type="text" name="golden_benefits" value="<?php echo $user->get_talent_value('golden_benefits'); ?>"></td>
    <td class="brown">Super Clicks</td><td><input style="width:50px" type="text" name="super_clicks" value="<?php echo $user->get_talent_value('super_clicks'); ?>"></td>
    <td class="purple">Passive Criticals</td><td><input style="width:50px" type="text" name="passive_criticals" value="<?php echo $user->get_talent_value('passive_criticals'); ?>"></td>
    <td class="purple">Set Bonus</td><td><input style="width:50px" type="text" name="set_bonus" value="<?php echo $user->get_talent_value('set_bonus'); ?>"></td>
    <td class="brown">Every Last Cent</td><td><input style="width:50px" type="text" name="every_last_cent" value="<?php echo $user->get_talent_value('every_last_cent'); ?>"></td>
    <td class="purple">Apprentice Crafter</td><td><input style="width:50px" type="text" name="apprentice_crafter" value="<?php echo $user->get_talent_value('apprentice_crafter'); ?>"></td>
    <td class="brown">Scavenger</td><td><input style="width:50px" type="text" name="scavenger" value="<?php echo $user->get_talent_value('scavenger'); ?>"></td>
    <td class="brown">Impatience</td><td><input style="width:50px" type="text" name="impatience" value="<?php echo $user->get_talent_value('impatience'); ?>"></td>
    <td class="purple">Level All The Way</td><td><input style="width:50px" type="text" name="level_all_the_way" value="<?php echo $user->get_talent_value('level_all_the_way'); ?>"></td>
    <td class="purple">Mission Accomplished</td><td><input style="width:50px" type="text" name="mission_accomplished" value="<?php echo $user->get_talent_value('mission_accomplished'); ?>"></td>
  </tr>
  <tr>
    <td class="brown">Endurance Training</td><td><input style="width: 50px" type="text" name="endurance_training" value="<?php echo $user->get_talent_value('endurance_training'); ?>"></td>
    <td class="brown">Ride the Storm</td><td><input style="width:50px" type="text" name="ride_the_storm" value="<?php echo $user->get_talent_value('ride_the_storm'); ?>"</td>
    <td class="brown">Storm's Building</td><td><input style="width:50px" type="text" name="storms_building" value="<?php echo $user->get_talent_value('storms_building'); ?>"></td>
    <td class="brown">The More the Merrier</td><td><input style="width:50px" type="text" name="the_more_the_merrier" value="<?php echo $user->get_talent_value('the_more_the_merrier'); ?>"></td>
    <td class="purple">Overenchanted</td><td><input style="width:50px" type="text" name="overenchanted" value="<?php echo $user->get_talent_value('overenchanted'); ?>"></td>
    <td class="purple">Surplus Cooldown</td><td><input style="width:50px" type="text" name="surplus_cooldown" value="<?php echo $user->get_talent_value('surplus_cooldown'); ?>"></td>
    <td class="purple">Sharing is Caring</td><td><input style="width:50px" type="text" name="sharing_is_caring" value="<?php echo $user->get_talent_value('sharing_is_caring'); ?>"></td>
    <td class="brown">Task Mastery</td><td><input style="width:50px" type="text" name="task_mastery" value="<?php echo $user->get_talent_value('task_mastery'); ?>"></td>
    <td class="brown">Efficient Crusading</td><td><input style="width:50px" type="text" name="efficient_crusading" value="<?php echo $user->get_talent_value('efficient_crusading'); ?>"></td>
    <td class="brown">Nurturing</td><td><input style="width:50px" type="text" name="nurturing" value="<?php echo $user->get_talent_value('nurturing'); ?>"></td>
    <td class="brown">Prospector</td><td><input style="width:50px" type="text" name="prospector" value="<?php echo $user->get_talent_value('prospector'); ?>"></td>
    <td class="brown">Doing it Again</td><td><input style="width:50px" type="text" name="doing_it_again" value="<?php echo $user->get_talent_value('doing_it_again'); ?>"></td>
  </tr>
  <tr>
    <td class="brown">Gold-o-splosion</td><td><input style="width:50px" type="text" name="gold_o_splosion" value="<?php echo $user->get_talent_value('gold_o_splosion'); ?>"></td>
    <td class="brown">Speed Runner</td><td><input style="width:50px" type="text" name="speed_runner" value="<?php echo $user->get_talent_value('speed_runner'); ?>"</td>
    <td class="brown">Sniper</td><td><input style="width:50px" type="text" name="sniper" value="<?php echo $user->get_talent_value('sniper'); ?>"></td>
    <td class="brown">Higher Magnification</td><td><input style="width:50px" type="text" name="higher_magnification" value="<?php echo $user->get_talent_value('higher_magnification'); ?>"></td>
    <td class="brown">Fast Learners</td><td><input style="width:50px" type="text" name="fast_learners" value="<?php echo $user->get_talent_value('fast_learners'); ?>"></td>
    <td class="purple">Well Equipped</td><td><input style="width:50px" type="text" name="well_equipped" value="<?php echo $user->get_talent_value('well_equipped'); ?>"></td>
    <td class="purple">Swap Day</td><td><input style="width:50px" type="text" name="swap_day" value="<?php echo $user->get_talent_value('swap_day'); ?>"></td>
    <td class="brown">Synergy</td><td><input style="width:50px" type="text" name="synergy" value="<?php echo $user->get_talent_value('synergy'); ?>"></td>
    <td class="brown">Deep Idol Scavenger</td><td><input style="width:50px" type="text" name="deep_idol_scavenger" value="<?php echo $user->get_talent_value('deep_idol_scavenger'); ?>"></td>
    <td class="purple">Extra Training</td><td><input style="width:50px" type="text" name="extra_training" value="<?php echo $user->get_talent_value('extra_training'); ?>"></td>
    <td class="brown">Head Start</td><td><input style="width:50px" type="text" name="head_start" value="<?php echo $user->get_talent_value('head_start'); ?>"></td>
    <td class="brown">Triple Tier Trouble</td><td><input style="width:50px" type="text" name="triple_tier_trouble" value="<?php echo $user->get_talent_value('triple_tier_trouble'); ?>"></td>
  </tr>
  <tr>
    <td class="brown">Extended Spawns</td><td><input style="width:50px" type="text" name="extended_spawns" value="<?php echo $user->get_talent_value('extended_spawns'); ?>"></td>
    <td class="brown">Click-tastrophe</td><td><input style="width:50px" type="text" name="click_tastrophe" value="<?php echo $user->get_talent_value('click_tastrophe'); ?>"</td>
    <td class="brown">Instant Satisfaction</td><td><input style="width:50px" type="text" name="instant_satisfaction" value="<?php echo $user->get_talent_value('instant_satisfaction'); ?>"></td>
    <td class="brown">Extra Healthy</td><td><input style="width:50px" type="text" name="extra_healthy" value="<?php echo $user->get_talent_value('extra_healthy'); ?>"></td>
    <td class="purple">Legendary Benefits</td><td><input style="width:50px" type="text" name="legendary_benefits" value="<?php echo $user->get_talent_value('legendary_benefits'); ?>"></td>
    <td class="brown">Idols Over Time</td><td><input style="width:50px" type="text" name="idols_over_time" value="<?php echo $user->get_talent_value('idols_over_time'); ?>"></td>
    <td class="purple">Golden Age</td><td><input style="width:50px" type="text" name="golden_age" value="<?php echo $user->get_talent_value('golden_age'); ?>"></td>
    <td class="purple">Journeyman Crafter</td><td><input style="width:50px" type="text" name="journeyman_crafter" value="<?php echo $user->get_talent_value('journeyman_crafter'); ?>"></td>
    <td class="brown">Sprint Mode</td><td><input style="width:50px" type="text" name="sprint_mode" value="<?php echo $user->get_talent_value('sprint_mode'); ?>"></td>
    <td class="purple">Superior Training</td><td><input style="width:50px" type="text" name="superior_training" value="<?php echo $user->get_talent_value('superior_training'); ?>"></td>
    <td class="blue">Kilo Leveling</td><td><input style="width:50px" type="text" name="kilo_leveling" value="<?php echo $user->get_talent_value('kilo_leveling'); ?>"></td>
    <td class="brown">Fourth Time's The Charm</td><td><input style="width:50px" type="text" name="fourth_times_the_charm" value="<?php echo $user->get_talent_value('fourth_times_the_charm'); ?>"></td>
  </tr>
  <tr>
    <td class="purple">Mission Adrenaline</td><td><input style="width:50px" type="text" name="mission_adrenaline" value="<?php echo $user->get_talent_value('mission_adrenaline'); ?>"></td>
    <td class="brown">Lingering Buffs</td><td><input style="width:50px" type="text" name="lingering_buffs" value="<?php echo $user->get_talent_value('lingering_buffs'); ?>"</td>
    <td class="brown">Omniclicking</td><td><input style="width:50px" type="text" name="omniclicking" value="<?php echo $user->get_talent_value('omniclicking'); ?>"></td>
    <td class="brown">Bossing Around</td><td><input style="width:50px" type="text" name="bossing_around" value="<?php echo $user->get_talent_value('bossing_around'); ?>"></td>
    <td class="purple">Cheer Squad</td><td><input style="width:50px" type="text" name="cheer_squad" value="<?php echo $user->get_talent_value('cheer_squad'); ?>"></td>
    <td class="brown">Valuable Experience</td><td><input style="width:50px" type="text" name="valuable_experience" value="<?php echo $user->get_talent_value('valuable_experience'); ?>"></td>
    <td class="purple">Every Little Bit Helps</td><td><input style="width:50px" type="text" name="every_little_bit_helps" value="<?php echo $user->get_talent_value('every_little_bit_helps'); ?>"></td>
    <td class="brown">Jeweler</td><td><input style="width:50px" type="text" name="jeweler" value="<?php echo $user->get_talent_value('jeweler'); ?>"></td>
    <td class="brown">Idol Champions</td><td><input style="width:50px" type="text" name="idol_champions" value="<?php echo $user->get_talent_value('idol_champions'); ?>"></td>
    <td class="purple">10K Training</td><td><input style="width:50px" type="text" name="tenk_training" value="<?php echo $user->get_talent_value('tenk_training'); ?>"></td>
    <td class="purple">Bonus Training</td><td><input style="width:50px" type="text" name="bonus_training" value="<?php echo $user->get_talent_value('bonus_training'); ?>"></td>
    <td class="brown">Scrap Hoarder</td><td><input style="width:50px" type="text" name="scrap_hoarder" value="<?php echo $user->get_talent_value('scrap_hoarder'); ?>"></td>
  </tr>
  <tr>
    <td class="brown">Phase Skip</td><td><input style="width:50px" type="text" name="phase_skip" value="<?php echo $user->get_talent_value('phase_skip'); ?>"></td>
    <td class="brown">Weekend Warrior</td><td><input style="width:50px" type="text" name="weekend_warrior" value="<?php echo $user->get_talent_value('weekend_warrior'); ?>"></td>
    <td class="brown">Material Goods</td><td><input style="width:50px" type="text" name="material_goods" value="<?php echo $user->get_talent_value('material_goods'); ?>"></td>
    <td></td><td></td>
    <td class="brown">Big Earner</td><td><input style="width:50px" type="text" name="big_earner" value="<?php echo $user->get_talent_value('big_earner'); ?>"></td>
    <td class="blue">Maxed Power!</td><td><input style="width:50px" type="text" name="maxed_power" value="<?php echo $user->get_talent_value('maxed_power'); ?>"></td>
    <td class="purple">Idolatry</td><td><input style="width:50px" type="text" name="idolatry" value="<?php echo $user->get_talent_value('idolatry'); ?>"></td>
    <td class="purple">Master Crafter</td><td><input style="width:50px" type="text" name="master_crafter" value="<?php echo $user->get_talent_value('master_crafter'); ?>"></td>
    <td class="brown">Marathon Sprint</td><td><input style="width:50px" type="text" name="marathon_sprint" value="<?php echo $user->get_talent_value('marathon_sprint'); ?>"></td>
    <td class="purple">Montage Training</td><td><input style="width:50px" type="text" name="montage_training" value="<?php echo $user->get_talent_value('montage_training'); ?>"></td>
    <td class="brown">Arithmagician</td><td><input style="width:50px" type="text" name="arithmagician" value="<?php echo $user->get_talent_value('arithmagician'); ?>"></td>
    <td class="brown">Cash In Hand</td><td><input style="width:50px" type="text" name="cash_in_hand" value="<?php echo $user->get_talent_value('cash_in_hand'); ?>"></td>
  </tr>
  <tr>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td></td><td></td>
    <td class="purple">Legendary Friendship</td><td><input style="width:50px" type="text" name="legendary_friendship" value="<?php echo $user->get_talent_value('legendary_friendship'); ?>"></td>
    <td class="purple">Golden Friendship</td><td><input style="width:50px" type="text" name="golden_friendship" value="<?php echo $user->get_talent_value('golden_friendship'); ?>"></td>
    <td class="purple">Friendly Helpers</td><td><input style="width:50px" type="text" name="friendly_helpers" value="<?php echo $user->get_talent_value('friendly_helpers'); ?>"></td>
    <td></td><td></td>
    <td class="brown">Sprint for the Finish</td><td><input style="width:50px" type="text" name="sprint_for_the_finish" value="<?php echo $user->get_talent_value('sprint_for_the_finish'); ?>"></td>
    <td class="purple">Magical Training</td><td><input style="width:50px" type="text" name="magical_training" value="<?php echo $user->get_talent_value('magical_training'); ?>"></td>
    <td></td><td></td>
    <td></td><td></td>
  </tr>
</table>
<?php
  if (!empty($results_to_print)) {
    echo $results_to_print;
  }
?>
<div style="float: left; width: 800px; font-weight: bold;">
If you fill in the user id and user hash in the left column below it'll populate the right column and your talents. If you want to fiddle with things, leave the user id and user hash fields empty and then the information in the right columns and your talents won't get overwritten with what is in your game.
</div>
<div style="float: left; clear: left; font-weight: bold;" class="red">Leave Raw User Data empty if using userid & hash, the raw user data only updates when you refresh the game</div>
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($user->user_id) ? $user->user_id : 0); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($user->user_hash) ? $user->user_hash : 0); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($user->server) ? $user->server : 'idlemaster'); ?>"><br>
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlentities($_POST['raw_user_data']) : ''); ?>"><br>
  Talents to Recommend: <input type="text" name="talents_to_recommend" value="<?php echo (isset($user->talents_to_recommend) ? $user->talents_to_recommend : 1); ?>"><br>
  Average Mission Completion in 8h: <input type="text" name="average_mission_completion" value="<?php echo (isset($user->average_mission_completion) ? $user->average_mission_completion : 0); ?>"><br>
  Main DPS Slot: <input type="text" name="main_dps_slot" value="<?php echo (isset($user->main_dps_slot) ? $user->main_dps_slot : 0); ?>"><br>
  Level Increase from Runes: <input type="text" name="main_dps_max_level_increase_from_runes" value="<?php echo (isset($user->main_dps_max_level_increase_from_runes) ? $user->main_dps_max_level_increase_from_runes : 0); ?>"><br>
  EP from main DPS: <input type="text" name="ep_from_main_dps" value="<?php echo (isset($user->ep_from_main_dps) ? $user->ep_from_main_dps : 0); ?>"><br>
  EP from Benched Crusaders: <input type="text" name="ep_from_benched_crusaders" value="<?php echo (isset($user->ep_from_benched_crusaders) ? $user->ep_from_benched_crusaders : 0); ?>"><br>
  Epics on main DPS: <input type="text" name="epics_on_main_dps" value="<?php echo (isset($user->epics_on_main_dps) ? $user->epics_on_main_dps : 0); ?>"><br>
  Epics on Benched Crusaders: <input type="text" name="epics_on_benched_crusaders" value="<?php echo (isset($user->epics_on_benched_crusaders) ? $user->epics_on_benched_crusaders : 0); ?>"><br>
  Main DPS benched crusaders legendaries: <input type="text" name="main_dps_benched_crusaders_legendaries" value="<?php echo (isset($user->main_dps_benched_crusaders_legendaries) ? $user->main_dps_benched_crusaders_legendaries : 0); ?>"><br>
  Main DPS benched crusaders golden gear: <input type="text" name="main_dps_benched_crusaders_golden_gear" value="<?php echo (isset($user->main_dps_benched_crusaders_golden_gear) ? $user->main_dps_benched_crusaders_golden_gear : 0); ?>"><br>
  Crusaders in formation: <input type="text" name="crusaders_in_formation" value="<?php echo (isset($user->crusaders_in_formation) ? $user->crusaders_in_formation : 0); ?>"><br>
  Critical chance: <input type="text" name="critical_chance" value="<?php echo (isset($user->critical_chance) ? $user->critical_chance : 0); ?>"><br>
  Gold bonus provided by crusaders: <input type="text" name="gold_bonus_provided_by_crusaders" value="<?php echo (isset($user->gold_bonus_provided_by_crusaders) ? $user->gold_bonus_provided_by_crusaders : 0); ?>"><br>
  Hitting Level Cap on Crusaders: <input type="checkbox" name="hitting_level_cap" value="true" <?php echo ((isset($user->hitting_level_cap) && $user->hitting_level_cap == false) ? '' : 'checked'); ?>><br>
  Ignore Impatience: <input type="checkbox" name="ignore_impatience" value="true" <?php echo ((isset($user->ignore_impatience) && $user->ignore_impatience == false) ? '' : 'checked'); ?>><br>
</div>
<div style="float: left;">
  Total Idols: <input type="text" name="total_idols" value="<?php echo (isset($user->total_idols) ? $user->total_idols : '0'); ?>"> <label for="debug">Debug: </label><input type="checkbox" id="debug" name="debug" value="true" <?php echo (isset($_POST['debug']) ? "checked" : ''); ?>><br>
  Max level Reached: <input type="text" name="max_level_reached" value="<?php echo (isset($user->max_level_reached) ? $user->max_level_reached : 0); ?>"><br>
  Golden Items: <input type="text" name="golden_items" value="<?php echo (isset($user->golden_items) ? $user->golden_items : 0); ?>"><br>
  Common + Uncommon Recipes: <input type="text" name="common_and_uncommon_recipes" value="<?php echo (isset($user->common_and_uncommon_recipes) ? $user->common_and_uncommon_recipes : 0); ?>"><br>
  Rare Recipes: <input type="text" name="rare_recipes" value="<?php echo (isset($user->rare_recipes) ? $user->rare_recipes : 0); ?>"><br>
  Epic Recipes: <input type="text" name="epic_recipes" value="<?php echo (isset($user->epic_recipes) ? $user->epic_recipes : 0); ?>"><br>
  Missions Accomplished: <input type="text" name="missions_accomplished" value="<?php echo (isset($user->missions_accomplished) ? $user->missions_accomplished : 0); ?>"><br>
  Legendaries: <input type="text" name="legendaries" value="<?php echo (isset($user->legendaries) ? $user->legendaries : 0); ?>"><br>
  Brass Rings: <input type="text" name="brass_rings" value="<?php echo (isset($user->brass_rings) ? $user->brass_rings : 0); ?>"><br>
  Silver Rings: <input type="text" name="silver_rings" value="<?php echo (isset($user->silver_rings) ? $user->silver_rings : 0); ?>"><br>
  Golden Rings: <input type="text" name="golden_rings" value="<?php echo (isset($user->golden_rings) ? $user->golden_rings : 0); ?>"><br>
  Diamond Rings: <input type="text" name="diamond_rings" value="<?php echo (isset($user->diamond_rings) ? $user->diamond_rings : 0); ?>"><br>
  Cooldown Reduction%: <input type="text" name="cooldown_reduction" value="<?php echo (isset($user->cooldown_reduction) ? $user->cooldown_reduction : 0); ?>"><br>
  Taskmasters owned: <input type="text" name="taskmasters_owned" value="<?php echo (isset($user->taskmasters_owned) ? $user->taskmasters_owned : 0); ?>"><br>
  Crusaders owned: <input type="text" name="crusaders_owned" value="<?php echo (isset($user->crusaders_owned) ? $user->crusaders_owned : 0); ?>"><br>
  <div class="hidden" >Storm Rider Gear Bonus: <input type="text" name="storm_rider_gear_bonus" value="<?php echo (isset($user->storm_rider_gear_bonus) ? $user->storm_rider_gear_bonus : 0); ?>"><br></div>
  <div class="hidden" >Clicks per second: <input type="text" name="clicks_per_second" value="<?php echo (isset($user->clicks_per_second) ? $user->clicks_per_second : 0); ?>"><br></div>
  <div class="hidden" >Click damage per DPS: <input type="text" name="click_damage_per_dps" value="<?php echo (isset($user->click_damage_per_dps) ? $user->click_damage_per_dps : 0); ?>"><br></div>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
</body>
</html>
