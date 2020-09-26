<?php

function call_cne($server, $user_id, $user_hash, $call, $parameters) {
  $ch = curl_init();
  $user_id_url = '';
  $user_hash_url = '';
  if (!empty($user_id)) {
    $user_id_url = '&user_id=' . htmlentities($user_id);
  }
  if (!empty($user_hash)) {
    $user_hash_url = '&hash=' . htmlentities($user_hash);
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

function debug($value) {
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

function generate_formation_image($saved_form, $objective, $all_crusaders, $campaign_formations) {
  $saved_form_image = '';
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
    } else {
      ${"image$position"} = './images/empty_slot.png';
    }
  }
  foreach ($campaign_formations AS $formation) {
    if ($formation['name'] == $objective) {
      foreach ($formation AS $id => $form) {
        if ($id !== 'name') {
          $saved_form_image .= '<div style="width: 40px; height: 40px; float: left; position: absolute; left:' . ($form['x'] - 30) * .6 .'px; top: ' . ($form['y'] * .64) . 'px"><img src="' . ${"image$id"} . '" style="width: 40px; height: 40px;"/></div>';
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
        $width = 'width: 270px;';
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

function get_total_mats($user_loot, $all_crusader_loot, $all_loot, $crafting_materials) {
  $total_mats = 0;
  foreach ($user_loot AS $id => $loot) {
    foreach($all_crusader_loot[$all_loot[$loot->loot_id]->hero_id] AS $slot_id => $crusader_all_slot_loot) {
      foreach ($crusader_all_slot_loot AS $crusader_slot_loot) {
        if ($crusader_slot_loot->id == $loot->loot_id) {
          if ($crusader_slot_loot->rarity == 5) {
            for ($i = 1; $i < $loot->count; $i++) {
              $total_mats += (250 * pow(2, ($i-1)));
            }
          }
        }
      }
    }
  }
  foreach ($crafting_materials AS $id => $material) {
    switch ($id) {
      case 1:
        $total_mats += $material;
        break;
      case 2:
        $total_mats += $material * 2;
        break;
      case 3:
        $total_mats += $material * 4;
        break;
      case 4:
        $total_mats += $material * 8;
        break;
    }
  }
  return $total_mats;
}
?>
