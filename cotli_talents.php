<?php
include "navigation.php";
include "cotli_talents_logic.php";
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div class="purple legend">Purple background means it's implemented </div><div class="blue legend">Blue background means it's mostly implemented </div><div class="brown legend">Brown background means it's not implemented</div>
<?php
  echo $game_defines->generate_talent_tree_table($user, $fully_implemented_talents, $partially_implemented_talents);
  if (!empty($results_to_print)) {
    echo $results_to_print;
  }
?>
<div style="float: left; width: 800px; font-weight: bold;">
If you fill in the user id and user hash in the left column below it'll populate the right column and your talents.
If you want to fiddle with things, leave the user id and user hash fields empty and then the information in the right columns and your talents won't get overwritten with what is in your game.
The gold bonus provided by crusaders accepts values in the form 1.0E34
Formation Full Up assumes the gold find is converted 1:1 into DPS.
Front Line Fire and Must be Magic, always assume they will be active.
</div>
<div style="float: left; clear: left; font-weight: bold;" class="red">Leave Raw User Data empty if using userid & hash, the raw user data only updates when you refresh the game</div>
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($user->user_id) ? $user->user_id : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($user->user_hash) ? $user->user_hash : ''); ?>"><br>
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlentities($_POST['raw_user_data']) : ''); ?>"><br>
  Talents to Recommend: <input type="text" name="talents_to_recommend" value="<?php echo (isset($user->talents_to_recommend) ? $user->talents_to_recommend : 1); ?>"><br>
  Average Mission Completion in 8h: <input type="text" name="average_mission_completion" value="<?php echo (isset($user->average_mission_completion) ? $user->average_mission_completion : 0); ?>"><br>
  Main DPS Slot: <input type="text" name="main_dps_slot" value="<?php echo (isset($user->main_dps_slot) ? $user->main_dps_slot : 0); ?>"><br>
  Level Increase from Runes: <input type="text" name="main_dps_max_level_increase_from_runes" value="<?php echo (isset($user->main_dps_max_level_increase_from_runes) ? $user->main_dps_max_level_increase_from_runes : 0); ?>"><br>
  EP from main DPS: <input type="text" name="ep_from_main_dps" value="<?php echo (isset($user->ep_from_main_dps) ? $user->ep_from_main_dps : 0); ?>"><br>
  Main DPS benched crusaders EP: <input type="text" name="ep_from_benched_crusaders" value="<?php echo (isset($user->ep_from_benched_crusaders) ? $user->ep_from_benched_crusaders : 0); ?>"><br>
  Epics on main DPS: <input type="text" name="epics_on_main_dps" value="<?php echo (isset($user->epics_on_main_dps) ? $user->epics_on_main_dps : 0); ?>"><br>
  Main DPS benched crusaders epics(or better): <input type="text" name="epics_on_benched_crusaders" value="<?php echo (isset($user->epics_on_benched_crusaders) ? $user->epics_on_benched_crusaders : 0); ?>"><br>
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
  Skins owned: <input type="text" name="skins_owned" value="<?php echo (isset($user->skins_owned) ? $user->skins_owned : 0); ?>"><br>
  Lowest epic trinket count: <input type="text" name="lowest_epic_trinket_count" value="<?php echo (isset($user->lowest_epic_trinket_count) ? $user->lowest_epic_trinket_count : 0); ?>"><br>
  <div class="hidden" >Storm Rider Gear Bonus: <input type="text" name="storm_rider_gear_bonus" value="<?php echo (isset($user->storm_rider_gear_bonus) ? $user->storm_rider_gear_bonus : 0); ?>"><br></div>
  <div class="hidden" >Clicks per second: <input type="text" name="clicks_per_second" value="<?php echo (isset($user->clicks_per_second) ? $user->clicks_per_second : 0); ?>"><br></div>
  <div class="hidden" >Click damage per DPS: <input type="text" name="click_damage_per_dps" value="<?php echo (isset($user->click_damage_per_dps) ? $user->click_damage_per_dps : 0); ?>"><br></div>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
</body>
</html>
