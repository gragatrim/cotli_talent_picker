<?php
include "navigation.php";
include "game_defines.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

if (!empty($_POST)) {
  $saved_form_html = '';
  $saved_form_html .= '<b>' . $game_defines->objectives[$_POST['dungeon_id']]->name . '</b><br>';
  $saved_form = array(0 => $_POST['slot_1'],
                  1 => $_POST['slot_2'],
                  2 => $_POST['slot_3'],
                  3 => $_POST['slot_4'],
                  4 => $_POST['slot_5'],
                  5 => $_POST['slot_6'],
                  6 => $_POST['slot_7'],
                  7 => $_POST['slot_8'],
                  8 => $_POST['slot_9'],
                  9 => $_POST['slot_10'],
                  10 => $_POST['slot_11'],
                  11 => $_POST['slot_12'],
                  12 => $_POST['slot_13'],
                  13 => $_POST['slot_14'],
                  14 => $_POST['slot_15']);
  $saved_form_html .= '<div style="float: left;margin-right:40px;">Generated form';
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

?>
<div style="color:red;">This will only show dungeon formations</div>
<div style="color:red;">The slots count from the rightmost top slot down and to the left(sorry no images yet of empty forms)</div>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  Dungeon Id: <input type="text" name="dungeon_id" value="<?php echo (isset($_POST['dungeon_id']) ? htmlspecialchars($_POST['dungeon_id']) : ''); ?>"><br>
  Slot 1: <input type="text" name="slot_1" value="<?php echo (isset($_POST['slot_1']) ? htmlspecialchars($_POST['slot_1']) : ''); ?>"><br>
  Slot 2: <input type="text" name="slot_2" value="<?php echo (isset($_POST['slot_2']) ? htmlspecialchars($_POST['slot_2']) : ''); ?>"><br>
  Slot 3: <input type="text" name="slot_3" value="<?php echo (isset($_POST['slot_3']) ? htmlspecialchars($_POST['slot_3']) : ''); ?>"><br>
  Slot 4: <input type="text" name="slot_4" value="<?php echo (isset($_POST['slot_4']) ? htmlspecialchars($_POST['slot_4']) : ''); ?>"><br>
  Slot 5: <input type="text" name="slot_5" value="<?php echo (isset($_POST['slot_5']) ? htmlspecialchars($_POST['slot_5']) : ''); ?>"><br>
  Slot 6: <input type="text" name="slot_6" value="<?php echo (isset($_POST['slot_6']) ? htmlspecialchars($_POST['slot_6']) : ''); ?>"><br>
  Slot 7: <input type="text" name="slot_7" value="<?php echo (isset($_POST['slot_7']) ? htmlspecialchars($_POST['slot_7']) : ''); ?>"><br>
  Slot 8: <input type="text" name="slot_8" value="<?php echo (isset($_POST['slot_8']) ? htmlspecialchars($_POST['slot_8']) : ''); ?>"><br>
  Slot 9: <input type="text" name="slot_9" value="<?php echo (isset($_POST['slot_9']) ? htmlspecialchars($_POST['slot_9']) : ''); ?>"><br>
  Slot 10: <input type="text" name="slot_10" value="<?php echo (isset($_POST['slot_10']) ? htmlspecialchars($_POST['slot_10']) : ''); ?>"><br>
  Slot 11: <input type="text" name="slot_11" value="<?php echo (isset($_POST['slot_11']) ? htmlspecialchars($_POST['slot_11']) : ''); ?>"><br>
  Slot 12: <input type="text" name="slot_12" value="<?php echo (isset($_POST['slot_12']) ? htmlspecialchars($_POST['slot_12']) : ''); ?>"><br>
  Slot 13: <input type="text" name="slot_13" value="<?php echo (isset($_POST['slot_13']) ? htmlspecialchars($_POST['slot_13']) : ''); ?>"><br>
  Slot 14: <input type="text" name="slot_14" value="<?php echo (isset($_POST['slot_14']) ? htmlspecialchars($_POST['slot_14']) : ''); ?>"><br>
  Slot 15: <input type="text" name="slot_15" value="<?php echo (isset($_POST['slot_15']) ? htmlspecialchars($_POST['slot_15']) : ''); ?>"><br>
</div>
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
$all_crusaders = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Crusader Name</th></tr>';
foreach($game_defines->crusaders AS $crusader) {
  $all_crusaders .= '<tr><td class="borderless">' . $crusader->id . '</td><td class="borderless">' . $crusader->name . '</td></tr>';
}
$all_crusaders .= '</table>';
echo $all_crusaders;
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
</html>
