<?php
include "navigation.php";
if (!empty($_POST['user_id']) && !empty($_POST['user_hash'])) {
  if ($_POST['page'] < 1) {
    $_POST['page'] = 1;
  }
  if (isset($_POST['next_page'])) {
    $_POST['page']++;
  }
  if (isset($_POST['previous_page'])) {
    if ($_POST['page'] > 1) {
      $_POST['page']--;
    } else {
      $_POST['page'] = 1;
    }
  }
  $ch = curl_init();
  $response = call_cne('', $_POST['user_id'], $_POST['user_hash'], 'getPlayHistory', '&page=' . urlencode($_POST['page']));

  $json_response = json_decode($response);
  $game_defines = new GameDefines();
  $loot_definition = $game_defines->loot;
  $crusaders = $game_defines->crusaders;
  $missions = $game_defines->missions;
  $chests = $game_defines->chests;
}
?>
<div style="color:red;">This is still very much a work in progress, don't be surprised to see raw json</div>
<div>This doesn't show chest/bi drop entries so it's possible pages will have nothing on them</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? $_POST['user_id'] : ''); ?>"><br>
User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? $_POST['user_hash'] : ''); ?>"><br>
Page: <input type="text" name="page" value="<?php echo (isset($_POST['page']) ? $_POST['page'] : 1); ?>"><br>
<input type="submit">
<?php
  if (!empty($json_response->entries)) {
    echo '<input type="submit" name="previous_page" value="Previous Page"><input type="submit" name="next_page" value="Next Page">';
  }
?>
</form>
<?php
if (!empty($json_response->entries)) {
  echo "<div style='color: red;'>All times are in CNE time</div>";
  foreach($json_response->entries AS $entry) {
    if (isset($entry->info->action) && $entry->info->action !== 'add_normal') {
      if (isset($entry->info->action) && $entry->info->action == 'upgrade_legendary') {
        echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Upgraded crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . ", gear " . $loot_definition[$entry->info->loot_id]->name . " to level " . $entry->info->level . "<br>";
      } else if (isset($entry->info->action) && $entry->info->action == 'craft_legendary') {
        echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Crafted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
      } else if (isset($entry->info->action) && $entry->info->action == 'disenchant_legendary') {
        echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Disenchanted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
      } else if (isset($entry->info->action) && $entry->info->action == 'start_mission') {
        $mission_crusaders = '';
        foreach($entry->info->hero_ids AS $hero) {
          $mission_crusaders .= ' ' . $crusaders[$hero]->name;
        }
        echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Started mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " with success chance of " . $entry->info->success_chance . "<br>";
      } else if (isset($entry->info->action) && $entry->info->action == 'complete_mission') {
        if ($entry->info->successful == 1) {
          if (!empty($entry->info->rewards->enchantment)) {
            $mission_crusaders = '';
            foreach($entry->info->rewards->enchantment->hero_ids AS $hero) {
              $mission_crusaders .= ' ' . $crusaders[$hero]->name;
            }
            echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " each received " . $entry->info->rewards->enchantment->points . " ep<br>";
        } else if (!empty($entry->info->rewards->crafting_recipes)) {
            $crafting_reward = '';
            $hero_crafting_reward = '';
            foreach ($entry->info->rewards->crafting_recipes AS $crafting_recipe) {
              $crafting_reward .= ' ' . $loot_definition[$crafting_recipe]->name;
              $hero_crafting_reward .= ' ' . $crusaders[$loot_definition[$crafting_recipe]->hero_id]->name;
            }
            echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is crafting recipe(s) for" . $crafting_reward .  " for crusader(s)" . $hero_crafting_reward . "<br>";
          } else if (!empty($entry->info->rewards->gold_time)) {
            echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is gold equal to " . $entry->info->rewards->gold_time . " seconds of gold<br>";
          } else if (!empty($entry->info->rewards->idols)) {
            echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->idols . " idols<br>";
          } else if (!empty($entry->info->rewards->red_rubies)) {
            echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->red_rubies . " rubies<br>";
          } else {
            echo "<pre>" . print_r($entry, true) . "</pre>";
          }
        }
      } else if (!empty($entry->info->action) && ($entry->info->action == 'use_normal' || $entry->info->action == 'use_rare' || $entry->info->action == 'use_generic_chest')) {
        if (!empty($entry->info->normal_chests) || !empty($entry->info->rare_chests) || !empty($entry->info->chests)) {
          $chest_type = '';
          $chests_opened = 0;
          if (!empty($entry->info->normal_chests)) {
            $chest_type = 'silver chest(s)';
            $chests_opened = $entry->info->normal_chests->used;
          } else if(!empty($entry->info->rare_chests)) {
            $chest_type = 'jeweled chest(s)';
            $chests_opened = $entry->info->rare_chests->used;
          } else if (!empty($entry->info->chest_type_id)) {
            $chest_type = $chests[$entry->info->chest_type_id]->name;
            $chests_opened = $entry->info->chests->used;
          }
          $gold_gained = 0;
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
          }
          foreach ($rune_array AS $rune_id => $runes_gained) {
            foreach ($runes_gained AS $rune_level => $gain) {
              $rune_gain .= $gain . " lvl " . $rune_level . " " . $game_defines->gems[$rune_id]->name . ", ";
            }
          }
          $rune_gain = rtrim($rune_gain, ", ");

          if (empty($rune_gain)) {
            $chest_contents = $common_mats . " common materials, " . $uncommon_mats . " uncommon materials, " . $rare_mats . " rare materials, and " . $epic_mats . " epic materials<br>";
          } else {
            $chest_contents = $rune_gain . "<br>";
          }
          echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Opened " . $chests_opened . " " . $chest_type . " gained " . $chest_contents;
        } else {
          echo "<pre>" . print_r($entry, true) . "</pre>";
        }
      }
    } else if (!empty($entry->info->idols)) {
      $reset_reward = '';
      if (!empty($entry->info->objective_awards->dungeon_progress)) {
        $reset_reward .= ' also gained ' . $entry->info->objective_awards->dungeon_progress . ' dungeon points and ' . $entry->info->objective_awards->dungeon_coins . ' dungeon coins';
      }
      echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Reset on objective " . $game_defines->campaign_formations[$entry->info->objective_id]['name'] . " for " . $entry->info->idols->gained . " idols, in " . $entry->info->play_time/60 . " minutes at area " . $entry->info->current_area . $reset_reward . "<br>";
    } else if (!empty($entry->info->reset_stats->rewards[0]->reward)) {
      if ($entry->info->reset_stats->rewards[0]->reward == 'challenge_tokens') {
        //The challenge rewards are split between 2 entries, so this fudges it so it reports on 1 line
        echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Reset for " . $entry->info->reset_stats->rewards[0]->amount . " challenge tokens and ";
      } else {
        echo "<pre>" . print_r($entry, true) . "</pre>";
      }
    } else if (!empty($entry->info->code)) {
      echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Redeemed code " . $entry->info->code . "<br>";
    } else if (isset($entry->info->action) && $entry->info->action === 'add_normal') {
      continue;
    } else if (isset($entry->info->objective_id)) {
      echo "<span style='font-weight: bold;'>" . $entry->history_date . "</span>: Started on objective " . $game_defines->campaign_formations[$entry->info->objective_id]['name'] . "<br>";
    } else {
      //I'm not going to bother printing out buff uses currently
      if (empty($entry->info->buff_use_details)) {
        echo "<pre>" . print_r($entry, true) . "</pre>";
      }
    }
  }
}
?>


