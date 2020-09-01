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
  //debug($json_response);
  //debug($game_defines->crusader_loot);
  //die();
 $user_crusaders = '<table style="float: left; clear:both;"><tr>';
 $column_count = 0;
  foreach ($json_response->details->heroes AS $id => $crusader) {
    $crusader_name = '';
    if ($crusader->owned == 1) {
      $crusader_image_name = str_replace(array(' ', ',', "'", '"'), "", ucwords($game_defines->crusaders[$crusader->hero_id]->name));
      $crusader_image_name_short = str_replace(array(' ', ',', "'", '"'), "", strtolower(explode(' ', $game_defines->crusaders[$crusader->hero_id]->name)[0]));
      if (file_exists('./images/' . $crusader_image_name . '_48.png')) {
        $image = './images/' . $crusader_image_name . '_48.png';
      } else if (file_exists('./images/' . $crusader_image_name . '_256.png')) {
        $image = './images/' . $crusader_image_name . '_256.png';
      } else if (file_exists('./images/' . $crusader_image_name_short . '.png')) {
        $image = './images/' . $crusader_image_name_short . '.png';
      } else if (file_exists('./images/' . $crusader_image_name_short . '_48.png')) {
        $image = './images/' . $crusader_image_name_short . '_48.png';
      } else {
        $image = '';
        $crusader_name = $game_defines->crusaders[$crusader->hero_id]->name;
      }
      $crusader_loot = get_crusader_loot($game_defines->crusaders[$crusader->hero_id], $json_response->details->loot, $game_defines->crusader_loot, $game_defines->loot);
      if ($column_count > 10) {
        $user_crusaders .= '</tr></tr>';
        $column_count = 0;
      }
      $user_crusaders .= '<td style="height: 48px; width: 48px;background-repeat: no-repeat; background-size: contain;background-image: url(\'' . $image .'\')">' . $crusader_name . '</td><td>' . implode('', $crusader_loot) . '</td>';
      $column_count++;
    }
  }
  $user_crusaders .= '</tr></table>';
}

function get_crusader_loot($crusader, $user_loot, $all_crusader_loot, $all_loot) {
  $owned_crusader_gear = array('<div style="background-color: black;"></div>', '<div style="background-color: black;"></div>', '<div style="background-color: black;"></div>');
  foreach ($user_loot AS $id => $loot) {
    if ($all_loot[$loot->loot_id]->hero_id == $crusader->id) {
      foreach($all_crusader_loot[$all_loot[$loot->loot_id]->hero_id] AS $slot_id => $crusader_all_slot_loot) {
        foreach ($crusader_all_slot_loot AS $crusader_slot_loot) {
          if ($crusader_slot_loot->id == $loot->loot_id) {
            $gear_level = '';
            switch ($crusader_slot_loot->rarity) {
              case 1:
                  $gear_level = '<div style="background-color: grey;">C</div>';
                break;
              case 2:
                  $gear_level = '<div style="background-color: green;">U</div>';
                break;
              case 3:
                  $gear_level = '<div style="background-color: #3378fe;">R</div>';
                break;
              case 4:
                if ($crusader_slot_loot->golden == 0) {
                  $gear_level = '<div style="background-color: mediumpurple;">E</div>';
                } else {
                  $gear_level = '<div style="background-color: lightcoral;">GE</div>';
                }
                break;
              case 5:
                if ($crusader_slot_loot->golden == 0) {
                  $gear_level = '<div style="background-color: lightblue;">' . $loot->count . '</div>';
                } else {
                  $gear_level = '<div style="background-color: gold;">' . $loot->count . '</div>';
                }
                break;
            }
            $owned_crusader_gear[$crusader_slot_loot->slot_id] = $gear_level;
          }
        }
      }
    }
  }
  return $owned_crusader_gear;
}

?>
<div style="color:red;">This will only display your crusaders and thier gear</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? htmlspecialchars($_POST['server']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (!empty($user_crusaders)) {
  echo $user_crusaders;
}
?>
</html>