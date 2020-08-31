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
  foreach ($json_response->details->formation_saves->challenges AS $id => $saved_forms) {
    if ($game_defines->objectives[$id]->campaign_id == 29) {
      $saved_form_html .= '<b>' . $game_defines->objectives[$id]->name . '</b><br>';
      foreach($saved_forms AS $saved_position => $saved_form) {
        $saved_form_html .= '<div style="float: left;margin-right:40px;">Saved form ' . $saved_position;
        $saved_form_html .= generate_formation_image($saved_form[0], $game_defines->objectives[$id]->name, $game_defines->crusaders);
        $saved_form_html .= '</div>';
      }
      $saved_form_html .= '<div style="clear:both;"></div>';
    }
  }
}

function generate_formation_image($saved_form, $objective, $all_crusaders) {
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
  if ($objective == 'Playing it Old School') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Free for All') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Fun and Games') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Under Fire') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Sunday Stroll') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Dark Dwellers') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Making Waves') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image14 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Jungle Journey') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image14 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Achieve Flight') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  } else if ($objective == 'Dungeon Crawl') {
    $saved_form_image = '<table class="formation_table">
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image11 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image5 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image12 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image6 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image0 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image9 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image3 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="formation_table" style="background-image: url(\'' . $image13 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image7 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image1 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image10 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image4 .'\')"></td>
                            <td class="borderless"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image8 .'\')"></td>
                            <td class="borderless"></td>
                            <td class="formation_table" style="background-image: url(\'' . $image2 .'\')"></td>
                          </tr>
                          <tr>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                            <td class="borderless"></td>
                          </tr>
                        </table>';
  }
  return $saved_form_image;
}

?>
<div style="color:red;">This will only show dungeon formations</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="text" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  Server(use idlemaster if you don't know): <input type="text" name="server" value="<?php echo (isset($_POST['server']) ? htmlspecialchars($_POST['server']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
</html>
