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
  debug("http://" . htmlentities($server) . ".djartsgames.ca/~idle/post.php?call=" . $call . $user_id_url . $user_hash_url . $parameters);
  curl_setopt($ch, CURLOPT_URL, "http://" . htmlentities($server) . ".djartsgames.ca/~idle/post.php?call=" . $call . $user_id_url . $user_hash_url . $parameters);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

  $response = curl_exec($ch);
  curl_close($ch);
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
          $saved_form_image .= '<div style="width: 40px; height: 40px; float: left; position: absolute; left:' . ($form['x'] - 30) * .6 .'px; top: ' . ($form['y'] * .6) . 'px"><img src="' . ${"image$id"} . '" style="width: 40px; height: 40px;"/></div>';
        }
      }
    }
  }
  return $saved_form_image;
}
?>
