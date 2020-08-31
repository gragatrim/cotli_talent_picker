<?php
include "navigation.php";
include "game_defines.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

if (!empty($_POST)) {
  $saved_form_html = '';
  $saved_form_html .= '<b style="float: left; clear: left;">' . $game_defines->objectives[$_POST['dungeon_id']]->name . '</b><br>';
  $saved_form = array();
  foreach($_POST AS $id => $input) {
    if (is_numeric($input) && $input > -1 && is_numeric($id)) {
      $slot_id = $input - 1;
      $saved_form[$slot_id] = $id;
    }
  }
  $saved_form_html .= '<div style="float: left;margin-right:40px;clear: left;">';
  $saved_form_html .= generate_formation_image($saved_form, $game_defines->objectives[$_POST['dungeon_id']]->name, $game_defines->crusaders);
  $saved_form_html .= '</div>';
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

$all_crusaders = '<table style="float: left;clear: left;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Crusader Name</th></tr><tr>';
$column_count = 0;
foreach($game_defines->crusaders AS $crusader) {
  if ($column_count >= 6) {
    $all_crusaders .= '</tr><tr>';
    $column_count = 0;
  }
  $value = !empty($_POST[$crusader->id]) ? htmlspecialchars($_POST[$crusader->id]) : "";
  $all_crusaders .= '<td class="borderless"><input style="width: 30px;" type="text" id="' . $crusader->id . '" name="' . $crusader->id . '" value="' . $value . '"></td><td class="borderless">' . $crusader->name . '</td>';
  $column_count++;
}
$all_crusaders .= '</tr></table>';
?>
<div style="color:red;">This will only show dungeon formations</div>
<div style="color:red;">The slots count from the rightmost top slot down and to the left(sorry no images yet of empty forms)</div>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  Dungeon Id: <input type="text" name="dungeon_id" value="<?php echo (isset($_POST['dungeon_id']) ? htmlspecialchars($_POST['dungeon_id']) : ''); ?>"><br>
</div>
<div style="float: left; clear: left;">Enter the slot you want the crusader in next to their name</div>
<?php echo $all_crusaders; ?>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
$all_dungeons = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Dungeon Name</th></tr>';
foreach ($game_defines->objectives AS $objective) {
    if ($objective->campaign_id == 29) {
      $all_dungeons .= '<tr><td class="borderless">' . $objective->id . '</td><td class="borderless">' . $objective->name . '</td></tr>';
    }
}
$all_dungeons .= '</table>';
echo $all_dungeons;
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
</html>
