<?php
include "navigation.php";
include "game_defines.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server'])) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://" . urlencode($_POST['server']) . ".djartsgames.ca/~idle/post.php?call=getUserDetails&instance_key=0&user_id=" . urlencode($_POST['user_id']) . "&hash=" . urlencode($_POST['user_hash']));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

  $response = curl_exec($ch);
  $json_response = json_decode($response);
  if (!empty($json_response->switch_play_server)) {
    $curl_url = $json_response->switch_play_server;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl_url . "post.php?call=getUserDetails&instance_key=0&user_id=" . urlencode($_POST['user_id']) . "&hash=" . urlencode($_POST['user_hash']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    $response = curl_exec($ch);
    $json_response = json_decode($response);
  }
  if (empty($json_response) || $json_response->success != true) {
    error_log("curl_error: " . curl_error($ch), 0);
    error_log("json_response: " . $response, 0);
  }
  curl_close($ch);
  $saved_form_html = '<div style="clear:both;"></div>';
  foreach ($json_response->details->formation_saves->campaigns AS $id => $saved_forms) {
    $saved_form_html .= '<b style="font-size: 20px;" id="' . htmlentities($game_defines->campaigns[$id]->name) . '">' . $game_defines->campaigns[$id]->name . '</b><br>';
    foreach($saved_forms AS $saved_position => $saved_form) {
      if (!empty($_POST['show_taskmaster_location'])) {
        $height = 'height: 600px;';
      } else {
        $height = 'height: 400px;';
      }
      $saved_form_html .= '<div style="float: left; ' . $height . '; position: relative; width: 500px; background-color: lightgray; border: 1px solid;"><b>Saved form ' . $saved_position . '</b>';
      $saved_form_html .= generate_formation_image($saved_form[0], $game_defines->campaigns[$id]->name, $game_defines->crusaders, $game_defines->campaign_formations);
      //For the TMs index 1 is the area, 1 means the field, 2 means they are on a crusader, 3 means the abilities
      //For the TMs index 2 is their position in the area(or seat id), not 0 indexed
      if (!empty($_POST['show_taskmaster_location'])) {
        $saved_form_html .= '<div style="float: left; position: relative; top: 325px;">';
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
    $saved_form_html .= '<div style="clear:both;"></div>';
  }
  foreach ($json_response->details->formation_saves->challenges AS $id => $saved_forms) {
    $saved_form_html .= '<b style="font-size: 20px;" id="' . htmlentities($game_defines->objectives[$id]->name) . '">' . $game_defines->objectives[$id]->name . '</b><br>';
    foreach($saved_forms AS $saved_position => $saved_form) {
    if (!empty($_POST['show_taskmaster_location'])) {
      $height = 'height: 600px;';
    } else {
      $height = 'height: 400px;';
    }
      $saved_form_html .= '<div style="float: left; ' . $height . '; position: relative; height: 600px; width: 500px; background-color: lightgray; border: 1px solid;"><b>Saved form ' . $saved_position . '</b>';
      $saved_form_html .= generate_formation_image($saved_form[0], $game_defines->objectives[$id]->name, $game_defines->crusaders, $game_defines->campaign_formations);
      //For the TMs index 1 is the area, 1 means the field, 2 means they are on a crusader, 3 means the abilities
      //For the TMs index 2 is their position in the area(or seat id), not 0 indexed
      if (!empty($_POST['show_taskmaster_location'])) {
        $saved_form_html .= '<div style="float: left; position: relative; top: 325px;">';
        foreach ($saved_form[1] AS $taskmaster_saved_position) {
          $taskmaster_location = '';
          if ($taskmaster_saved_position[1] == 3) {
            $taskmaster_location = 'activating the ability ' . $game_defines->abilities[$taskmaster_saved_position[2]]->name;
          } else if ($taskmaster_saved_position[1] == 1) {
            $taskmaster_location = 'clicking on the field';
          } else if ($taskmaster_saved_position[1] == 2) {
            $taskmaster_location = 'upgrading the active crusader in seat ' . $taskmaster_saved_position[2];
          } else {
            $taskmaster_location = 'clicking on a buff or auto-advance';
          }
          $saved_form_html .= $game_defines->taskmasters[$taskmaster_saved_position[0]]->name . ' is ' . $taskmaster_location . '<br/>';
        }
        $saved_form_html .= '</div>';
      }
      $saved_form_html .= '</div>';
    }
    $saved_form_html .= '<div style="clear:both;"></div>';
  }
}

function generate_formation_image($saved_form, $objective, $all_crusaders, $campaign_formations) {
  $saved_form_image = '';
  foreach($saved_form AS $position => $crusader) {
    if ($crusader > -1) {
      $crusader_image_name = str_replace(array(' ', ',', "'", '"'), "", ucwords($all_crusaders[$crusader]->name));
      $crusader_image_name_short = str_replace(array(' ', ',', "'", '"'), "", strtolower(explode(' ', $all_crusaders[$crusader]->name)[0]));
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
          $saved_form_image .= '<div style="width: 48px; height: 48px; float: left; position: absolute; left:' . $form['x'] .'px; top: ' . $form['y'] . 'px"><img src="' . ${"image$id"} . '" style="width: 48px; height: 48px;"/></div>';
        }
      }
    }
  }
  return $saved_form_image;
}

if (!empty($_POST['show_taskmaster_location'])) {
  $checked = 'checked';
} else {
  $checked = 'not-checked';
}
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? htmlspecialchars($_POST['server']) : ''); ?>"><br>
  Show Taskmaster Location?: <input type="checkbox" name="show_taskmaster_location" value="1" <?php echo $checked;?>><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<a style="float: left; clear: left;" href="#Playing it Old School">Jump to Dungeon Forms</a>
<?php
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
</html>
