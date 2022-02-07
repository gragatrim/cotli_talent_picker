<?php

function call_cne($server, $user_id, $user_hash, $call, $parameters) {
  $user_id = trim($user_id);
  $user_hash = trim($user_hash);
  $ch = curl_init();
  $user_id_url = '';
  $user_hash_url = '';
  if (!empty($user_id)) {
    $user_id_url = '&user_id=' . htmlentities($user_id);
  }
  if (!empty($user_hash)) {
    $user_hash_url = '&hash=' . htmlentities($user_hash);
  }
  if (empty($server)) {
    $server = 'idlemaster';
  }
  curl_setopt($ch, CURLOPT_URL, "http://" . htmlentities($server) . ".djartsgames.ca/~idle/post.php?call=" . $call . $user_id_url . $user_hash_url . $parameters);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

  $response = curl_exec($ch);
  $json_response = json_decode($response);
  curl_close($ch);
  if (!empty($json_response->switch_play_server)) {
    $ch = curl_init();
    $curl_url = $json_response->switch_play_server;
    curl_setopt($ch, CURLOPT_URL, $curl_url . "post.php?call=" . $call . $user_id_url . $user_hash_url . $parameters);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    $response = curl_exec($ch);
    curl_close($ch);
  }
  return $response;
}

function debug($value, $title = '') {
  echo '<pre>================== ' . $title . '=============</pre>';
  echo '<pre>' . print_r($value, true) . '</pre>';
}

function format($number) {
  $formatted_number = '';
  $decimal_position = strpos($number, '.');
  if (bccomp($number, '0', 40) === 0) {
    $formatted_number = '0';
  } else if (strpos($number, '0') === 0) {
    $ltrim = ltrim($number, '0.');
    $ltrim_strlen = strlen($ltrim);
    $number_strlen = strlen($number);
    $exponent = '-' . ($number_strlen - $ltrim_strlen - 1);
    $base = substr($ltrim,0,1);
    $decimal = substr($ltrim,1,2);
    $formatted_number = $base . "." . $decimal . "E" . $exponent;
  } else if ($decimal_position > 2 || ($decimal_position === false && strlen($number) > 3)) {
    if ($decimal_position !== false) {
      $exponent_value = (strlen(substr($number, 0, $decimal_position)) - 1);
    } else {
      $exponent_value = strlen($number) - 1;
    }
    $exponent = '+' . $exponent_value;
    $base = substr($number,0,1);
    $decimal = substr($number,1,2);
    $formatted_number = $base . "." . $decimal . "E" . $exponent;
  } else {
    $formatted_number = sprintf("%.2E", $number);
  }
  return $formatted_number;
}

function generate_formation_image($saved_form, $objective, $all_crusaders, $campaign_formations, $draggable = false) {
  $saved_form_image = '';
  if (!empty($saved_form)) {
    foreach($saved_form AS $position => $crusader) {
      if ($crusader > -1) {
        $crusader_image_name = str_replace(array(' ', ',', "'", '"', '-'), "", ucwords($all_crusaders[$crusader]->name));
        $crusader_image_name_short = str_replace(array(' ', ',', "'", '"', '-'), "", strtolower(explode(' ', $all_crusaders[$crusader]->name)[0]));
        if (file_exists('./images/' . $crusader_image_name . '_48.png')) {
          ${"image$position"} = './images/' . $crusader_image_name . '_48.png';
        } else if (file_exists('./images/' . $crusader_image_name . '_256.png')) {
          ${"image$position"} = './images/' . $crusader_image_name . '_256.png';
        } else if (file_exists('./images/' . $crusader_image_name_short . '.png')) {
          ${"image$position"} = './images/' . $crusader_image_name_short . '.png';
        } else if (file_exists('./images/' . $crusader_image_name_short . '_48.png')) {
          ${"image$position"} = './images/' . $crusader_image_name_short . '_48.png';
        } else {
          ${"image$position"} = './images/empty_slot.png';
        }
          ${"crusader_id_$position"} = $crusader;
      } else {
        ${"image$position"} = './images/empty_slot.png';
      }
    }
  }

  if (!empty($campaign_formations)) {
    foreach ($campaign_formations AS $formation) {
      if ($formation['name'] == $objective) {
        foreach ($formation AS $id => $form) {
          if ($id !== 'name') {
            $img_id = '';
            if (!empty(${"crusader_id_$id"})) {
               $img_id = 'id="img_form_crusader' . ${"crusader_id_$id"} . '"';
            }
            if (!isset(${"image$id"})) {
              ${"image$id"} = './images/empty_slot.png';
            }
            $saved_form_image .= '<div style="width: 40px; height: 40px; float: left; position: absolute; left:' . ($form['x'] - 30) * .6 .'px; top: ' . ($form['y'] * .64) . 'px" ondrop="drop(event)" ondragover="allowDrop(event)"><img ' . $img_id . ' src="' . ${"image$id"} . '" style="width: 40px; height: 40px;" draggable="true" ondragstart="drag(event)"/></div>';
          }
        }
      }
    }
  }
  return $saved_form_image;
}

function get_crusader_image($crusader_name) {
  $crusader_info = array('name' => '');
  $crusader_image_name = str_replace(array(' ', ',', "'", '"', '-'), "", ucwords($crusader_name));
  $crusader_image_name_short = str_replace(array(' ', ',', "'", '"', '-'), "", strtolower(explode(' ', $crusader_name)[0]));
  if (file_exists('./images/' . $crusader_image_name . '_48.png')) {
    $crusader_info['image'] = './images/' . $crusader_image_name . '_48.png';
  } else if (file_exists('./images/' . $crusader_image_name . '_256.png')) {
    $crusader_info['image'] = './images/' . $crusader_image_name . '_256.png';
  } else if (file_exists('./images/' . $crusader_image_name_short . '.png')) {
    $crusader_info['image'] = './images/' . $crusader_image_name_short . '.png';
  } else if (file_exists('./images/' . $crusader_image_name_short . '_48.png')) {
    $crusader_info['image'] = './images/' . $crusader_image_name_short . '_48.png';
  } else {
    $crusader_info['image'] = './images/empty_slot.png';
    $crusader_info['name']  = $crusader_name;
  }
  return $crusader_info;
}

function generate_saved_forms($forms, $game_defines) {
  $saved_form_html = '<div style="clear:both;"></div>';
  foreach ($forms AS $id => $saved_forms) {
    if (!empty($game_defines->campaigns[$id]->name)) {
      $saved_form_html .= '<b style="font-size: 20px;" id="' . htmlentities($game_defines->campaigns[$id]->name) . '">' . $game_defines->campaigns[$id]->name . '</b><br><div>';
    } else {
      $saved_form_html .= '<b style="font-size: 20px;" id="' . htmlentities($game_defines->objectives[$id]->name) . '">' . $game_defines->objectives[$id]->name . '</b><br><div>';
    }
    foreach($saved_forms AS $saved_position => $saved_form) {
      if (!empty($_POST['show_taskmaster_location'])) {
        $height = 'height: 600px;';
      } else {
        $height = 'height: 300px;';
      }
      if (!empty($game_defines->objectives[$id]->campaign_id) && $game_defines->objectives[$id]->campaign_id == 29) {
        $width = 'width: 300px;';
      } else {
        $width = 'width: 330px;';
      }
        $saved_form_html .= '<div style="float: left; ' . $height . '; ' . $width . ' position: relative; background-color: lightgray; border: 1px solid;"><b>Saved form ' . $saved_position . '</b>';
      if (!empty($game_defines->campaigns[$id]->name)) {
        $saved_form_html .= generate_formation_image($saved_form[0], $game_defines->campaigns[$id]->name, $game_defines->crusaders, $game_defines->campaign_formations);
      } else {
        $saved_form_html .= generate_formation_image($saved_form[0], $game_defines->objectives[$id]->name, $game_defines->crusaders, $game_defines->campaign_formations);
      }
      //For the TMs index 1 is the area, 1 means the field, 2 means they are on a crusader, 3 means the abilities
      //For the TMs index 2 is their position in the area(or seat id), not 0 indexed
      if (!empty($_POST['show_taskmaster_location'])) {
        $saved_form_html .= '<div style="float: left; position: relative; top: 200px;">';
        if (!empty($saved_form[1])) {
          foreach ($saved_form[1] AS $taskmaster_saved_position) {
            $taskmaster_location = '';
            if ($taskmaster_saved_position[1] == 3) {
              $taskmaster_location = 'activating the ability ' . $game_defines->abilities[$taskmaster_saved_position[2]]->name;
            } else if ($taskmaster_saved_position[1] == 1) {
              $taskmaster_location = 'clicking on the field';
            } else if ($taskmaster_saved_position[1] == 2) {
              $taskmaster_location = 'upgrading the active crusader in seat ' . $taskmaster_saved_position[2];
            } else if ($taskmaster_saved_position[1] == 4) {
              $taskmaster_location = 'clicking on auto-advance';
            } else {
              $taskmaster_location = 'clicking on a buff';
            }
            $saved_form_html .= $game_defines->taskmasters[$taskmaster_saved_position[0]]->name . ' is ' . $taskmaster_location . '<br/>';
          }
        }
        $saved_form_html .= '</div>';
      }
      $saved_form_html .= '</div>';
    }
    $saved_form_html .= '</div><div style="clear:both;"></div>';
  }
  return $saved_form_html;
}

function get_total_mats($user_loot, $all_crusader_loot, $all_loot, $crafting_materials, $include_unopened_chests = false, $user_chests = array(), $chest_defines = NULL) {
  $total_mats = 0;
  $gear_levels = array();
  foreach ($user_loot AS $id => $loot) {
    foreach($all_crusader_loot[$all_loot[$loot->loot_id]->hero_id] AS $slot_id => $crusader_all_slot_loot) {
      foreach ($crusader_all_slot_loot AS $crusader_slot_loot) {
        if ($crusader_slot_loot->id == $loot->loot_id) {
          if ($crusader_slot_loot->rarity == 5) {
            for ($i = 1; $i < $loot->count; $i++) {
              $total_mats += (250 * pow(2, ($i-1)));
            }
            if (isset($gear_levels[$i])) {
              $gear_levels[$i]++;
            } else {
              $gear_levels[$i] = 1;
            }
          }
        }
      }
    }
  }
  if (!empty($crafting_materials)) {
    foreach ($crafting_materials AS $id => $material) {
      switch ($id) {
        case 1:
          $total_mats += $material;
          break;
        case 2:
          $total_mats += $material * 2.5;
          break;
        case 3:
          $total_mats += $material * 5;
          break;
        case 4:
          $total_mats += $material * 10;
          break;
      }
    }
  }

  if ($include_unopened_chests !== false) {
    //Numbers taken from the work of @ryan92084 from discord in the sheet found here http://bit.ly/CotLI_Chest_Stats
    $mats_per_sc = 7.82634045;
    $mats_per_jc = 40.291578;
    $total_silver_chests = 0;
    $total_jeweled_chests = 0;
    foreach ($user_chests AS $chest_id => $number_of_chests) {
      if (empty($chest_defines[$chest_id])){
        continue;
      }
      if (stripos($chest_defines[$chest_id]->name, 'silver') !== false) {
        $total_silver_chests += $number_of_chests;
      } else if (stripos($chest_defines[$chest_id]->name, 'jeweled') !== false) {
        $total_jeweled_chests += $number_of_chests;
      }
    }
    //I don't think it matter if all that much, decided to floor it
    $total_mats += floor($total_silver_chests * $mats_per_sc + $total_jeweled_chests * $mats_per_jc);
  }
  ksort($gear_levels);
  return array($total_mats, $gear_levels);
}

function generate_formation_table($game_defines) {
  $all_formations = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Formation Name</th></tr>';
  foreach ($game_defines->campaign_formations AS $id => $campaign_formations) {
    $all_formations .= '<tr><td class="borderless">' . $id . '</td><td class="borderless">' . $campaign_formations['name'] . '</td></tr>';
  }
  $all_formations .= '</table>';
  return $all_formations;
}

function get_talent_implemented_css($id, $fully_implemented_talents, $partially_implemented_talents) {
  $color = "brown";
  if (in_array($id, $fully_implemented_talents)) {
    $color = "purple";
  } else if (in_array($id, $partially_implemented_talents)) {
    $color = "blue";
  } else {
    $color = "brown";
  }
  return $color;
}

function exp2int($exp) {
  if (strlen($exp) < 1 || $exp == 0) {
    return 0;
  }
  @list($mantissa, $exponent) = explode("e", strtolower($exp));
  if($exponent=='') return $exp;
  @list($int, $dec) = explode(".", $mantissa);
  return bcmul($mantissa, bcpow("10", $exponent, 40), 40);
}

function get_gem_effect($gem_effects, $game_defines) {
  $effect_array = explode(',', $gem_effects->effect_string);
  $gem_slot_effect = '';
  if ($effect_array[0] == 'buff_formation_abilities' || $effect_array[0] == 'buff_formation_ability') {
    $effect_array_size = count($effect_array);
    for ($k = 2; $k < $effect_array_size; $k++) {
      $gem_slot_effect .= $game_defines->formation_abilities[$effect_array[$k]]->name . '<br>';
    }
  } else if ($effect_array[0] == 'buff_formation_ability_indices') {
    $effect_array_size = count($effect_array);
    for ($k = 2; $k < ($effect_array_size - 1); $k++) {
      $gem_slot_effect .= $game_defines->formation_abilities[$effect_array[$k]]->name . '<br>';
    }
  } else if ($effect_array[0] == 'unlock_formation_ability') {
    $gem_slot_effect .= $game_defines->formation_abilities[$effect_array[1]]->name . '<br>';
  } else if ($effect_array[0] == 'buff_upgrades' || $effect_array[0] == 'buff_upgrade_max_level') {
    $gem_upgrade_count = count($effect_array);
    for ($j = 2; $j < $gem_upgrade_count; $j++) {
      $gem_slot_effect .= $game_defines->crusader_upgrades[$effect_array[$j]]->name . '<br>';
    }
  } else if ($effect_array[0] == 'buff_ability') {
    $gem_slot_effect .= 'Buff ' . $game_defines->abilities[$effect_array[2]]->name . '<br>';
  } else if ($effect_array[0] == 'global_dps_multiplier_mult') {
    $gem_slot_effect .= 'Buff Global DPS<br>';
  } else if ($effect_array[0] == 'critical_click_chance_mult') {
    $gem_slot_effect .= 'Critical Click Chance<br>';
  } else if ($effect_array[0] == 'gold_multiplier_mult') {
    $gem_slot_effect .= 'Increase All Gold Found<br>';
  } else if ($effect_array[0] == 'monster_explodes_damage_increase') {
    $gem_slot_effect .= 'Increases the explosion damage of ' . $game_defines->formation_abilities[$effect_array[2]]->name . '<br>';
  } else if ($effect_array[0] == 'buff_garnet_stack_conversion_rate') {
    $gem_slot_effect .= 'Increases the conversion rate of good luck stacks <br>';
  } else if ($effect_array[0] == 'buff_garnet_warp_areas') {
    $gem_slot_effect .= 'Increases the areas skipped by warping<br>';
  } else {
    $gem_slot_effect .= $gem_effects->effect_string . '<br>';
  }
  return $gem_slot_effect;
}

function get_bi_drop_total($max_area_reached, $t2_11ths_completed) {
  //This is to properly handle that you only get an increase in BI every 5 areas and not for every area reached
  $floored_max_area_reached = floor($max_area_reached * 2 / 10) / 2 * 10;
  $floored_max_area_using_new_bi = 0;
  if ($floored_max_area_reached > 5895) {
    $floored_max_area_using_new_bi = $floored_max_area_reached - 5895;
  }
  if ($floored_max_area_reached > 5895) {
    //The new BI scaling below will correctly handle the rest
    $floored_max_area_reached = 5895;
  }
  $fp_idol_average_before_5900 = 0.4*10.201*(1+0.25*($t2_11ths_completed-1))*((1-pow(1.0201,(($floored_max_area_reached-95)/5)))/(1-1.0201));
  $fp_idol_gain_at_5895 = ((1+0.25*($t2_11ths_completed-1))*floor(10*pow(1.01,(0.4*(5800)))));
  $new_bi_fp_idol_gain_sum = 0;
  for ($i = 5; $i <= $floored_max_area_using_new_bi; $i += 5) {
    $new_bi_fp_idol_gain_sum += $fp_idol_gain_at_5895*pow(1.01, $i/5);
  }
  $fp_idol_average = $new_bi_fp_idol_gain_sum * .4 + $fp_idol_average_before_5900;
  return $fp_idol_average;
}

function parse_effect_from_string($effect) {
  $effect_array = explode(',', $effect);
  $return = $effect;
  if ($effect_array[0] == 'gold_multiplier_mult') {
    $return = '+' . $effect_array[1] . '% Gold';
  } else if ($effect_array[0] == 'dps_to_all_monsters') {
    $return = 'Deal ' . $effect_array[1] . '% of your DPS to all monsters';
  } else if ($effect_array[0] == 'global_click_damage_dps_percent') {
    $return = 'Increase CLK by ' . $effect_array[1] . '% of your DPS';
  } else if ($effect_array[0] == 'critical_click_chance_damage_mult') {
    $return = 'Increase your Critical Click Chance by ' . $effect_array[1] . ' and your Damage multiplier by ' . $effect_array[2];
  } else if ($effect_array[0] == 'increase_monster_spawn_time_mult') {
    $return = 'Increase monster spawn speed by ' . $effect_array[1] . '%';
  } else if($effect_array[0] == 'global_dps_multiplier_mult') {
    $return = 'Increase the DPS of all crusaders by ' . $effect_array[1] . '%';
  }

  return $return;
}

function gold_gain_addition($number1, $number2) {
  //This function needs to exists since the gold gained is returned as a string using scientific notation and I can't figure out how to convert it to an actual number for use with bcmath
  $sum = array(0,0);
  $number1_array = explode('e', $number1);
  $number2_array = explode('e', $number2);
  //I'm also going to be lazy and not deal with converting 10.XX to 1.XX and increasing the exponent, or if the exponents are different actually adding in the smaller amount
  if ($number1_array[1] == $number2_array[1]) {
    $sum[0] = $number1_array[0] + $number2_array[0];
    $sum[1] = $number1_array[1];
  } else if ($number1_array[1] > $number2_array[1]) {
    $sum = $number1_array;
  } else {
    $sum = $number2_array;
  }

  return $sum[0] . 'e' . $sum[1];
}

function seconds_to_time($seconds) {
  $dtF = new \DateTime('@0');
  $dtT = new \DateTime("@$seconds");
  return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}
?>
