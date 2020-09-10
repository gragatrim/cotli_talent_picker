<?php
include "navigation.php";
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server'])) {
  $ch = curl_init();
  $response = call_cne($_POST['server'], $_POST['user_id'], $_POST['user_hash'], 'getPlayHistory', '&page=' . urlencode($_POST['page']));

  $json_response = json_decode($response);
  if (!empty($json_response->switch_play_server)) {
    $curl_url = $json_response->switch_play_server;
    preg_match('@^(?:http[s]?://)?([^.]+)@i', $curl_url, $matches);
    $response = call_cne($matches[1], $_POST['user_id'], $_POST['user_hash'], 'getPlayHistory', '&page=' . urlencode($_POST['page']));
    $json_response = json_decode($response);
  }
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
Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? $_POST['server'] : ''); ?>"><br>
Page: <input type="text" name="page" value="<?php echo (isset($_POST['page']) ? $_POST['page'] : ''); ?>"><br>
<input type="submit">
</form>
<?php
if (!empty($json_response)) {
  foreach($json_response->entries AS $entry) {
    if ($entry->info->action !== 'add_normal') {
      if ($entry->info->action == 'upgrade_legendary') {
        echo "Upgraded crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . ", gear " . $loot_definition[$entry->info->loot_id]->name . " to level " . $entry->info->level . "<br>";
      } else if ($entry->info->action == 'craft_legendary') {
        echo "Crafted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
      } else if ($entry->info->action == 'disenchant_legendary') {
        echo "Disenchanted legendary item " . $loot_definition[$entry->info->loot_id]->name . ", for crusader " . $crusaders[$loot_definition[$entry->info->loot_id]->hero_id]->name . "<br>";
      } else if ($entry->info->action == 'start_mission') {
        $mission_crusaders = '';
        foreach($entry->info->hero_ids AS $hero) {
          $mission_crusaders .= ' ' . $crusaders[$hero]->name;
        }
        echo "Started mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " with success chance of " . $entry->info->success_chance . "<br>";
      } else if ($entry->info->action == 'complete_mission') {
        if ($entry->info->successful == 1) {
          if (!empty($entry->info->rewards->enchantment)) {
            $mission_crusaders = '';
            foreach($entry->info->rewards->enchantment->hero_ids AS $hero) {
              $mission_crusaders .= ' ' . $crusaders[$hero]->name;
            }
            echo "Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", sent crusaders" . $mission_crusaders . " each received " . $entry->info->rewards->enchantment->points . " ep<br>";
        } else if (!empty($entry->info->rewards->crafting_recipes)) {
            $crafting_reward = '';
            $hero_crafting_reward = '';
            foreach ($entry->info->rewards->crafting_recipes AS $crafting_recipe) {
              $crafting_reward .= ' ' . $loot_definition[$crafting_recipe]->name;
              $hero_crafting_reward .= ' ' . $crusaders[$loot_definition[$crafting_recipe]->hero_id]->name;
            }
            echo "Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is crafting recipe(s) for" . $crafting_reward .  " for crusader(s)" . $hero_crafting_reward . "<br>";
          } else if (!empty($entry->info->rewards->gold_time)) {
            echo "Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is gold equal to " . $entry->info->rewards->gold_time . " seconds of gold<br>";
          } else if (!empty($entry->info->rewards->idols)) {
            echo "Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->idols . " idols<br>";
          } else if (!empty($entry->info->rewards->red_rubies)) {
            echo "Successfully completed mission " . $missions[$entry->info->mission_id]->name . ", reward is " . $entry->info->rewards->red_rubies . " rubies<br>";
          } else {
            echo "<pre>" . print_r($entry, true) . "</pre>";
          }
        }
      } else if ($entry->info->action == 'use_normal' || $entry->info->action == 'use_rare' || $entry->info->action == 'use_generic_chest') {
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
          }
          echo "Opened " . $chests_opened . " " . $chest_type . " gained " . $common_mats . " common materials, " . $uncommon_mats . " uncommon materials, " . $rare_mats . " rare materials, and " . $epic_mats . " epic materials<br>";
        } else {
          echo "<pre>" . print_r($entry, true) . "</pre>";
        }
      } else if (!empty($entry->info->idols)) {
        $reset_reward = '';
        if (!empty($entry->info->objective_awards->dungeon_progress)) {
          $reset_reward .= ' also gained ' . $entry->info->objective_awards->dungeon_progress . ' dungeon points and ' . $entry->info->objective_awards->dungeon_coins . ' dungeon coins';
        }
        echo "Reset for " . $entry->info->idols->gained . " idols, in " . $entry->info->play_time/60 . " minutes" . $reset_reward . "<br>";
      } else if (!empty($entry->info->reset_stats->rewards[0]->reward)) {
        if ($entry->info->reset_stats->rewards[0]->reward == 'challenge_tokens') {
          //The challenge rewards are split between 2 entries, so this fudges it so it reports on 1 line
          echo "Reset for " . $entry->info->reset_stats->rewards[0]->amount . " challenge tokens and ";
        } else {
          echo "<pre>" . print_r($entry, true) . "</pre>";
        }
      } else if (!empty($entry->info->code)) {
        echo "Redeemed code " . $entry->info->code . "<br>";
      } else {
        //I'm not going to bother printing out buff uses currently
        if (empty($entry->info->buff_use_details)) {
          echo "<pre>" . print_r($entry, true) . "</pre>";
        }
      }
    }
  }
}
?>


