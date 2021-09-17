<?php
include "navigation.php";

if (!empty($_POST['user_id']) && !empty($_POST['user_hash'])) {
  if ($_POST['page'] < 1) {
    $_POST['page'] = 1;
  }
  if (isset($_POST['next_page'])) {
    $_POST['page'] = $_POST['page'] + $_POST['page_multiplier'];
  }
  if (isset($_POST['previous_page'])) {
    if ($_POST['page'] > 1) {
      $_POST['page'] = $_POST['page'] - $_POST['page_multiplier'];
    } else {
      $_POST['page'] = 1;
    }
  }
  $response = array();
  for ($i = 0; $i < $_POST['page_multiplier']; $i++) {
    $response[$i] = call_cne('', $_POST['user_id'], $_POST['user_hash'], 'getPlayHistory', '&page=' . ($_POST['page'] + $i));
  }

  $game_defines = new GameDefines();
  $loot_definition = $game_defines->loot;
  $crusaders = $game_defines->crusaders;
  $missions = $game_defines->missions;
  $chests = $game_defines->chests;
  $buffs = $game_defines->buffs;
  $quests = $game_defines->quests;
}

$page_navigation = '';
if (!empty($_POST['page'])) {
  $page_navigation = '<input type="submit" name="previous_page" value="Previous Page(s)"><input type="submit" name="next_page" value="Next Page(s)">(these go back/forward the amount you have checked for pages to view at once)';
}

$player_history = "<div style='color: red;'>All times are in CNE time</div>";
if (!empty($response)) {
  foreach ($response AS $id => $r) {
    $json_response = json_decode($r);
    $player_history .= "<div style='color: red;'>New Page</div>";
    foreach($json_response->entries AS $entry) {
      if (isset($entry->info->action) && $entry->info->action !== 'add_normal') {
        if (isset($entry->info->action) && $entry->info->action == 'upgrade_legendary') {
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Upgraded crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . ", gear " . $loot_definition[$entry->info->loot_id]->name . " to level " . $entry->info->level . "<br>";
        } else if (isset($entry->info->action) && $entry->info->action == 'craft_legendary') {
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Crafted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
        } else if (isset($entry->info->action) && $entry->info->action == 'disenchant_legendary') {
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Disenchanted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
        } else if (isset($entry->info->action) && $entry->info->action == 'start_mission') {
          $mission_crusaders = '';
          foreach($entry->info->hero_ids AS $hero) {
            $mission_crusaders .= ' ' . $crusaders[$hero]->name;
          }
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Started mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " with success chance of " . $entry->info->success_chance . "<br>";
        } else if (isset($entry->info->action) && $entry->info->action == 'complete_mission') {
          if ($entry->info->successful == 1) {
            if (!empty($entry->info->rewards->enchantment)) {
              $mission_crusaders = '';
              foreach($entry->info->rewards->enchantment->hero_ids AS $hero) {
                $mission_crusaders .= ' ' . $crusaders[$hero]->name;
              }
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " each received " . $entry->info->rewards->enchantment->points . " ep<br>";
          } else if (!empty($entry->info->rewards->crafting_recipes)) {
              $crafting_reward = '';
              $hero_crafting_reward = '';
              foreach ($entry->info->rewards->crafting_recipes AS $crafting_recipe) {
                $crafting_reward .= ' ' . $loot_definition[$crafting_recipe]->name;
                $hero_crafting_reward .= ' ' . $crusaders[$loot_definition[$crafting_recipe]->hero_id]->name;
              }
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is crafting recipe(s) for" . $crafting_reward .  " for crusader(s)" . $hero_crafting_reward . "<br>";
            } else if (!empty($entry->info->rewards->gold_time)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is gold equal to " . $entry->info->rewards->gold_time . " seconds of gold<br>";
            } else if (!empty($entry->info->rewards->idols)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->idols . " idols<br>";
            } else if (!empty($entry->info->rewards->red_rubies)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->red_rubies . " rubies<br>";
            } else if (!empty($entry->info->rewards->arcane_jewels)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->arcane_jewels . " Geode<br>";
            } else if (!empty($entry->info->rewards->chests->{365})) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->chests->{365} . " Runic Chest<br>";
            } else if (!empty($entry->info->rewards->chests->{2})) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->chests->{2} . " Jeweled Chest<br>";
            } else if (!empty($entry->info->rewards->crafting_materials)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->crafting_materials->{1} . " common mats, " . (!empty($entry->info->rewards->crafting_materials->{2}) ? $entry->info->rewards->crafting_materials->{2} : 0) . " uncommon mats, " . (!empty($entry->info->rewards->crafting_materials->{3}) ? $entry->info->rewards->crafting_materials->{3} : 0) . " rare mats, and " . (!empty($entry->info->rewards->crafting_materials->{4}) ? $entry->info->rewards->crafting_materials->{4} : 0) . " epic mats<br>";
            } else if (!empty($entry->info->rewards->activate_buffs)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . parse_effect_from_string($buffs[$entry->info->rewards->activate_buffs[0]->buff_id]->effect) . " for " . $entry->info->rewards->activate_buffs[0]->duration . " seconds<br>";
            } else if (!empty($entry->info->rewards->gem_solvent)) {
              $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->gem_solvent . " Solvent<br>";
            } else {
              $player_history .= "<pre>" . print_r($entry, true) . "</pre>";
            }
          }
        } else if (!empty($entry->info->action) && $entry->info->action == 'redeem_code') {
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Redeemed code " . $entry->info->code . "<br>";
        } else if (!empty($entry->info->action) && ($entry->info->action == 'use_normal' || $entry->info->action == 'use_rare' || $entry->info->action == 'use_generic_chest')) {
          if (!empty($entry->info->normal_chests) || !empty($entry->info->rare_chests) || !empty($entry->info->chests)) {
            $chest_type = '';
            $chests_opened = 0;
            if (!empty($entry->info->normal_chests)) {
              if ((!isset($_POST['show_chests_opened_by_crusaders']) || $_POST['show_chests_opened_by_crusaders'] == false) && (isset($entry->info->opened_by) && $entry->info->opened_by == 'Crusader Ability')) {
                //skip to the next entry
                continue;
              } else {
                $chest_type = 'silver chest(s)';
                $chests_opened = $entry->info->normal_chests->used;
              }
            } else if(!empty($entry->info->rare_chests)) {
              $chest_type = 'jeweled chest(s)';
              $chests_opened = $entry->info->rare_chests->used;
            } else if (!empty($entry->info->chest_type_id)) {
              $chest_type = $chests[$entry->info->chest_type_id]->name;
              $chests_opened = $entry->info->chests->used;
            }
            $gold_gained = '0e0';
            $common_mats = 0;
            $uncommon_mats = 0;
            $rare_mats = 0;
            $epic_mats = 0;
            $rune_array = array();
            $rune_gain = '';
            foreach($entry->info->loot AS $chest) {
              if (!empty($chest->crafting_materials)) {
                foreach ($chest->crafting_materials AS $type => $amount) {
                  switch ($type) {
                    case 1:
                      $common_mats += $amount;
                      break;
                    case 2:
                      $uncommon_mats += $amount;
                      break;
                    case 3:
                      $rare_mats += $amount;
                      break;
                    case 4:
                      $epic_mats += $amount;
                      break;
                  }
                }
              }
              if (!empty($chest->gems)) {
                foreach ($chest->gems AS $rune) {
                  if (empty($rune_array[$rune->id][$rune->level])) {
                    $rune_array[$rune->id][$rune->level] = 0;
                  }
                  $rune_array[$rune->id][$rune->level] += $rune->count;
                }
              }
              if (!empty($chest->add_gold_amount)) {
                $current_gold_gained = $gold_gained;
                $gold_gained = gold_gain_addition($chest->add_gold_amount, $current_gold_gained);
              }
            }
            foreach ($rune_array AS $rune_id => $runes_gained) {
              foreach ($runes_gained AS $rune_level => $gain) {
                $rune_gain .= $gain . " lvl " . $rune_level . " " . $game_defines->gems[$rune_id]->name . ", ";
              }
            }
            $rune_gain = rtrim($rune_gain, ", ");

            if (empty($rune_gain)) {
              $chest_contents = $common_mats . " common materials, " . $uncommon_mats . " uncommon materials, " . $rare_mats . " rare materials, and " . $epic_mats . " epic materials and " . $gold_gained . " gold<br>";
            } else {
              $chest_contents = $rune_gain . "<br>";
            }
            $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Opened " . $chests_opened . " " . $chest_type . " gained " . $chest_contents;
          } else {
            $player_history .= "<pre>" . print_r($entry, true) . "</pre>";
          }
        } else if (!empty($entry->info->action) && ($entry->info->action == 'talent_payout')) {
            $player_history .= "<div><span style='font-weight: bold;'>" . $entry->history_date . "</span>: Gained  " . $entry->info->reward->amount . " common materials for " . $entry->info->reward->details . "</div>";
        //Should eventually uncomment this and implement the things caught here... but I'm lazy
        //} else {
        //  //Catch all in case I haven't implemented it yet
        //  $player_history .= "<pre>" . print_r($entry, true) . "</pre>";
        }
      } else if (!empty($entry->info->idols)) {
        $reset_reward = '';
        if (!empty($entry->info->objective_awards->dungeon_progress)) {
          $reset_reward .= ' also gained ' . $entry->info->objective_awards->dungeon_progress . ' dungeon points and ' . $entry->info->objective_awards->dungeon_coins . ' dungeon coins';
        }
        if ($entry->info->campaign_id == 29) {
          $campaign = 'Dungeons';
        } else {
          $campaign = $game_defines->campaign_formations[$entry->info->campaign_id]['name'];
        }
        $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Reset on objective " . $game_defines->objectives[$entry->info->objective_id]->name . " for campaign " . $campaign . " and gained " . $entry->info->idols->gained . " idols, in " . $entry->info->play_time/60 . " minutes at area " . $entry->info->highest_area_unlocked . $reset_reward . "<br>";
      } else if (!empty($entry->info->reset_stats->rewards[0]->reward)) {
        if ($entry->info->reset_stats->rewards[0]->reward == 'challenge_tokens') {
          //The challenge rewards are split between 2 entries, so this fudges it so it reports on 1 line
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Reset for " . $entry->info->reset_stats->rewards[0]->amount . " challenge tokens and ";
        } else {
          $player_history .= "<pre>" . print_r($entry, true) . "</pre>";
        }
      } else if (isset($entry->info->action) && $entry->info->action === 'add_normal') {
        if (!empty($entry->info->bonus_boss_idols) && $entry->info->bonus_boss_idols->gained > 0 && isset($_POST['show_bonus_boss_idols']) && $_POST['show_bonus_boss_idols'] == true) {
          $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Gained " . $entry->info->bonus_boss_idols->gained . " bonus boss idols from area " . $entry->info->chest_area_sent . "<br>";
        } else {
          continue;
        }
      } else if (isset($entry->info->objective_id)) {
        if ($entry->info->campaign_id == 29) {
          $campaign = 'Dungeons';
        } else {
          $campaign = $game_defines->campaign_formations[$entry->info->campaign_id]['name'];
        }
        $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Started on objective " . $game_defines->objectives[$entry->info->objective_id]->name . " for campaign " . $campaign . "<br>";
      } else if (!empty($entry->info->quest_id)) {
        $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed quest " . $quests[$entry->info->quest_id]->name . ", reward is " . $quests[$entry->info->quest_id]->rewards[0]->amount . ' ' . str_replace('_', ' ', $quests[$entry->info->quest_id]->rewards[0]->reward) . "<br>";
      } else if (!empty($entry->info->buff_use_details)) {
        $buffs_used_string = '';
        $buffs_used_reward_string = '';
        foreach ($entry->info->buff_use_details AS $id => $buff_details) {
          $buffs_used_string .= $buff_details->uses . 'x ' . $buffs[$id]->name . ', ';
          $buffs_used_reward_string .= parse_effect_from_string($buffs[$id]->effect) . '(base duration: ' . $buffs[$id]->duration . ' seconds), ';
        }
        $buffs_used_string = trim($buffs_used_string, ', ');
        $buffs_used_reward_string = trim($buffs_used_reward_string, ', ');
        $player_history .= "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Used buff(s) " . $buffs_used_string . ", reward is " . $buffs_used_reward_string . "<br>";
      } else {
        //Catch all in case I haven't implemented it yet
        $player_history .= "<pre>" . print_r($entry, true) . "</pre>";
      }
    }
  }
}
?>
<div style="color:red;">This is still very much a work in progress, don't be surprised to see raw json</div>
<div>This doesn't show chest/bi drop entries so it's possible pages will have nothing on them</div>
<div>Additionally the gold gained might be slightly off for chest opening</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
User Id: <input type="text" name="user_id" size="1" value="<?php echo (isset($_POST['user_id']) ? $_POST['user_id'] : ''); ?>"><br>
User Hash: <input type="password" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? $_POST['user_hash'] : ''); ?>"><br>
Show Bonus Boss Idols: <input type="checkbox" name="show_bonus_boss_idols" value="true" <?php echo ((!isset($_POST['show_bonus_boss_idols']) || $_POST['show_bonus_boss_idols'] == false) ? '' : 'checked'); ?>><br>
Show Chests opened by Crusaders: <input type="checkbox" name="show_chests_opened_by_crusaders" value="true" <?php echo ((!isset($_POST['show_chests_opened_by_crusaders']) || $_POST['show_chests_opened_by_crusaders'] == false) ? '' : 'checked'); ?>><br>
Starting Page: <input type="text" name="page" value="<?php echo (isset($_POST['page']) ? $_POST['page'] : 1); ?>"><br>
Pages of Player History to view at once: 1<input type="radio" name="page_multiplier" value="1" <?php echo (((isset($_POST['page_multiplier']) && $_POST['page_multiplier'] == 1) || empty($_POST['page_multiplier'])) ? 'checked' : ''); ?>> 10<input type="radio" name="page_multiplier" value="10" <?php echo ((isset($_POST['page_multiplier']) && $_POST['page_multiplier'] == 10) ? 'checked' : ''); ?>> 25<input type="radio" name="page_multiplier" value="25" <?php echo ((isset($_POST['page_multiplier']) && $_POST['page_multiplier'] == 25) ? 'checked' : ''); ?>> 50<input type="radio" name="page_multiplier" value="50" <?php echo ((isset($_POST['page_multiplier']) && $_POST['page_multiplier'] == 50) ? 'checked' : ''); ?>><br>
<input type="submit">
<?php
  if (!empty($page_navigation)) {
    echo $page_navigation;
  }
  if (!empty($player_history)) {
    echo $player_history;
  }
?>
</form>
