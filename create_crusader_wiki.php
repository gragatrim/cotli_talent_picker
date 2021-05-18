<?php
include "navigation.php";
if ($_POST) {
  if (!empty($_POST['force_refresh'])) {
    $force_refresh = true;
  } else {
    $force_refresh = false;
  }
  if (!empty($_POST['use_dev_info'])) {
    $use_dev_info = true;
  } else {
    $use_dev_info = false;
  }
  $game_defines = new GameDefines($force_refresh, $use_dev_info);
  $crusader_id = htmlspecialchars($_POST['crusader_id']);
  $crusader_upgrades = $game_defines->get_crusader_upgrades();
  $crusader_infobox = "{{Crusader_Infobox";
  $crusader_campaign = 0;
  $crusader_name = '';
  $crusader = [];
  //This is here as a lazy way to allow us to get the previous crusaders names in the next loop
  foreach($game_defines->crusaders AS $hero) {
    if ($hero->id == $crusader_id) {
      $crusader_name = $hero->name;
      $crusader = $hero;
    }
  }
  if (!empty($crusader)) {
    $alt_crusaders = array();
    $next_crusader = '';
    foreach($game_defines->crusaders AS $hero) {
      if ($hero->seat_id == ($crusader->seat_id - 1) && empty($previous_crusader)) {
        $previous_crusader = $hero->name;
      }
      if ($hero->seat_id == ($crusader->seat_id + 1) && empty($next_crusader)) {
        $next_crusader = $hero->name;
      }
      if ($hero->seat_id == $crusader->seat_id && $hero->id != $crusader->id) {
        $alt_crusaders[] = $hero->name;
      }
      if ($hero->id == $crusader_id) {
        $crusader_infobox .= "| Title = " . $hero->name . "\n";
        $crusader_infobox .= "| Crusader_Number = " . $hero->seat_id . "\n";
        $crusader_infobox .= "| Starting_Cost = " . $hero->base_cost . "\n";
        foreach ($hero->properties->flavor_tags as $flavor_tag) {
          if (stripos($flavor_tag, 'event') !== false) {
            $crusader_campaign = str_ireplace('event', '', $flavor_tag);
          }
        }
        $crusader_name = $hero->name;
        $crusader = $hero;
      }
    }
    $alt_crusader_wiki = '';
    foreach($alt_crusaders AS $alt_key => $alt_crusader) {
      if ($alt_key == 0) {
        $alt_crusader_wiki .= "| Alt_Crusader = " . $alt_crusader . "\n";
      } else {
        //For some reason the wiki needs it like this
        $alt_crusader_wiki .= "| Alt_Crusader" . ($alt_key + 1) . " = " . $alt_crusader . "\n";
      }
    }
    $crusader_infobox .= $alt_crusader_wiki;
    $crusader_infobox .= "| Prev_Crusader = " . $previous_crusader . "\n";
    $crusader_infobox .= "| Next_Crusader = " . $next_crusader . "\n";
    $crusader_infobox .= "}}";
    $campaign_name = '';
    foreach($game_defines->campaigns AS $campaign) {
      if (!empty($campaign->requirements[0]) && !empty($campaign->requirements[0]->event_id) && $campaign->requirements[0]->event_id == $crusader_campaign) {
        $campaign_name = $campaign->name;
      }
    }
    $formation_abilities = $game_defines->formation_abilities;
    $crusader_upgrades_wiki = "==Upgrades==\n{{Upgrade|top}}\n";
    foreach($game_defines->crusader_upgrades AS $upgrade) {
      if ($upgrade->hero_id == $crusader_id) {
        $upgrade_effect = '';
        $upgrade_formation_ability = explode(',',$upgrade->effect);
        if (stripos($upgrade->effect, 'hero_dps_multiplier_mult') !== false) {
          $effect = explode(',',$upgrade->effect);
          $upgrade_effect = "|{{IncDPS|" . $crusader_name . "|" . $effect[1] . "%}}";
        } else if (stripos($upgrade->effect, 'global_dps_multiplier_mult') !== false) {
          $upgrade_effect = '|{{IncDPS|all|' . $upgrade_formation_ability[1] . '%}}';
        } else if (stripos($upgrade->effect, 'hero_level_dps_mult,4,25,200') !== false) {
          $upgrade_effect = "";
        } else if (stripos($upgrade->effect, 'unlock_formation_ability') !== false) {
          $formation_ability_variables = explode(',', $formation_abilities[$upgrade_formation_ability[1]]->effect[0]->effect_string);
          if (!empty($formation_abilities[$upgrade_formation_ability[1]]->effect[0]->formation_ability_desc)) {
            $upgrade_effect = "|" . $formation_abilities[$upgrade_formation_ability[1]]->effect[0]->formation_ability_desc;
            $upgrade_effect = str_replace("\$source__short", $crusader_name, $upgrade_effect);
            $upgrade_effect = str_replace("\$source", $crusader_name, $upgrade_effect);
            $upgrade_effect = str_ireplace("\$amount", $formation_ability_variables[1], $upgrade_effect);
            $upgrade_effect = str_ireplace("amount", $formation_ability_variables[1], $upgrade_effect);
            if (!empty($formation_ability_variables[3]) && !empty($formation_abilities[$formation_ability_variables[3]]->name)) {
              $upgrade_effect = preg_replace('/\$fa[^ ]*/', $formation_abilities[$formation_ability_variables[3]]->name, $upgrade_effect);
            }
          } else {
            if ($formation_ability_variables[0] == 'global_dps_per_target') {
              $upgrade_adjacent_effect = '';
              if (!empty($formation_abilities[$upgrade_formation_ability[1]]->effect[0]->per_target->targets)) {
                switch ($formation_abilities[$upgrade_formation_ability[1]]->effect[0]->per_target->targets) {
                  case "adj":
                    $upgrade_adjacent_effect = ' next to ' . $crusader_name;
                    break;
                  case "col":
                    $upgrade_adjacent_effect = ' in the same column as ' . $crusader_name;
                    break;
                }
              }
              $upgrade_effect = "|{{IncDPS|all|" . $formation_ability_variables[1] . "%}} for each " . $formation_abilities[$upgrade_formation_ability[1]]->effect[0]->per_target->tags[0] . " crusader" . $upgrade_adjacent_effect . ", stacking " . ($formation_ability_variables[2] == 1 ? 'multiplicatively' : 'additively');
            } else if ($formation_ability_variables[0] == 'buff_formation_ability') {
              $requirements = '';
              if (!empty($upgrade->requirements)) {
                $requirements .= ' when there is ';
                if (!empty($upgrade->requirements->greater_than)) {
                  $requirements .= ' at least ' . ($upgrade->requirements->greater_than + 1);
                } else if (!empty($upgrade->requirements->less_than)) {
                  $requirements .= ($upgrade->requirements->less_than) . ' or fewer';
                }
                if (!empty($upgrade->requirements->requirement)) {
                  if ($upgrade->requirements->requirement == 'num_adjacent') {
                    $requirements .= 'adjacent to ' . $crusader_name;
                  } else if ($upgrade->requirements->requirement == 'num_in_formation') {
                    $requirements .= ' in the formation';
                  } else if ($upgrade->requirements->requirement == 'num_monsters_alive'){
                    $requirements .= ' or more monsters alive';
                  } else if ($upgrade->requirements->requirement == 'affected_by_fas'){
                    $requirements .= ' Formation Abilities affecting ' . $crusader_name;
                  }
                }
              }
              $upgrade_effect = '|Increases the effect of ' . $formation_abilities[$formation_ability_variables[2]]->name . ' by ' . $formation_ability_variables[1] . '%' . $requirements;
            } else {
              $upgrade_effect = "|" . $formation_abilities[$upgrade_formation_ability[1]]->effect[0]->effect_string;
            }
          }
        } else if (stripos($upgrade->effect, 'buff_formation_ability') !== false) {
          $upgrade_effect = '|Increases the effect of ' . $formation_abilities[$upgrade_formation_ability[2]]->name . ' by ' . $upgrade_formation_ability[1] . '%';
        } else {
          $upgrade_effect = "|" . $upgrade->effect;
        }
        if ($upgrade->required_level == 200) {
          //for some reason the wiki expects this in this order....
          $crusader_upgrades_wiki .= "{{Upgrade|" . $upgrade->required_level . "|" . $upgrade->name . "|" . sprintf("%.2E", $upgrade->cost) . $upgrade_effect . "|" . $upgrade->description . "|image=" . str_replace(" ", "", ucwords($upgrade->name)) . ".png}}\n";
        } else {
          $crusader_upgrades_wiki .= "{{Upgrade|" . $upgrade->name . "|" . $upgrade->required_level . "|" . sprintf("%.2E", $upgrade->cost) . $upgrade_effect . "|" . $upgrade->description . "|image=" . str_replace(" ", "", ucwords($upgrade->name)) . ".png}}\n";
        }
      }
    }
    $crusader_upgrades_wiki .= "{{Upgrade|end}}\n";

    $crusader_mission_tags = '';
    foreach($crusader->properties->tags AS $crusader_tags) {
      $crusader_mission_tags .= '[[Category:Mission Tag ' . $crusader_tags . "]]\n";
    }
    //If this runs out and the game is still being updated.... then good for CNE
    $ordinal_numbers = array(1 => 'first',
                             2 => 'second',
                             3 => 'third',
                             4 => 'fourth',
                             5 => 'fifth',
                             6 => 'sixth',
                             7 => 'seventh',
                             8 => 'eighth',
                             9 => 'ninth',
                             10 => 'tenth',
                             11 => 'eleventh',
                             12 => 'twelveth',
                             13 => 'thirteenth',
                             14 => 'fourteenth',
                             15 => 'fifteenth');
    //They just numerically index these, and they randomly change the order, so this will ensure we get the right tier
    foreach ($crusader->properties->flavor_tags AS $tag) {
      if (strpos($tag, 'tier') !== false) {
        $tier = 'the ' . $ordinal_numbers[substr($tag, 4)] . " tier of the [[" . $campaign_name . "]] Event.";
        break;
      }
    }
    if (empty($tier)) {
      $tier = $crusader->properties->flavor_tags[0];
    }
    $wiki_text = $crusader_infobox . "
    '''" . $crusader_name . "''' is the new Crusader in " . $tier . "
    {{Clr}}

    " . $crusader_upgrades_wiki . "

    {{Items}}

    {{Strategies}}

    ==References==
    <references />

    {{Crusaders}}
    [[Category:Crusaders]]\n" . $crusader_mission_tags;
  }
}
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
Crusader Id: <input type="text" name="crusader_id" value="<?php echo (isset($_POST['crusader_id']) ? htmlspecialchars($_POST['crusader_id']) : 0); ?>"><br>
Force Game Detail Refresh: <input type="checkbox" name="force_refresh" value="1" not-checked><br>
Use Dev Data?: <input type="checkbox" name="use_dev_info" value="1" not-checked><br>
<input type="submit">
<br>
<?php
if (!empty($wiki_text)) {
  echo "<pre>" . $wiki_text . "</pre>";
}
?>
