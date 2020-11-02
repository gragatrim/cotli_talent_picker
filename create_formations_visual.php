<?php
include "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

if (!empty($_POST) && !empty($_POST['formation_id'])) {
  $saved_form_html = '';
  $saved_form_html .= '<b style="float: left; clear: left;">' . $game_defines->campaign_formations[$_POST['formation_id']]['name'] . '</b><br>';
  $saved_form = array(0 => -1,
                      1 => -1,
                      2 => -1,
                      3 => -1,
                      4 => -1,
                      5 => -1,
                      6 => -1,
                      7 => -1,
                      8 => -1,
                      9 => -1,
                      10 => -1,
                      11 => -1,
                      12 => -1,
                      13 => -1,
                      14 => -1);
  foreach($_POST AS $id => $input) {
    if (is_numeric($input) && $input > -1 && is_numeric($id)) {
      $slot_id = $input - 1;
      $saved_form[$slot_id] = $id;
    }
  }
  $saved_form_html .= '<div style="float: left; clear: left; position: relative; height: 400px; width: 500px; background-color: lightgray; border: 1px solid;">';
  $saved_form_html .= generate_formation_image($saved_form, $game_defines->campaign_formations[$_POST['formation_id']]['name'], $game_defines->crusaders, $game_defines->campaign_formations);
  $saved_form_html .= '</div>';
}

$all_crusaders_div = '<div style="float:left; clear: left; width: 75%;">';
foreach($game_defines->crusaders_in_seat_order AS $crusader_seat) {
  $all_crusaders_div .= '<div style="float: left;border: solid 2px; margin: 5px;">';
  foreach($crusader_seat AS $crusader) {
      $crusader_image_info = get_crusader_image($crusader->name);
      $image = $crusader_image_info['image'];
      if ($crusader_image_info['image'] != './images/empty_slot.png') {
        $all_crusaders_div .= '<div id="td_crusader' . $crusader->id . '" style="float: left; padding: 1px;"><img id="crusader' . $crusader->id. '" src="' . $image . '" draggable="true" ondragstart="drag(event)" width="48px" height="48px"></div>';
      }
  }
  $all_crusaders_div .= '</div>';
}
$all_crusaders_div .= '</div>';
?>
<div style="color:red;">This is still in "beta" some things might not work perfectly</div>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
Formation Id: <input type="text" name="formation_id" value="<?php echo (isset($_POST['formation_id']) ? htmlspecialchars($_POST['formation_id']) : ''); ?>"><br>
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php echo $all_crusaders_div; ?>
<?php
$all_formations = '<table style="float:right;" class="borderless"><tr><th class="borderless">Id</th><th class="borderless">Formation Name</th></tr>';
foreach ($game_defines->campaign_formations AS $id => $campaign_formations) {
  $all_formations .= '<tr><td class="borderless">' . $id . '</td><td class="borderless">' . $campaign_formations['name'] . '</td></tr>';
}
$all_formations .= '</table>';
echo $all_formations;
if (!empty($saved_form_html)) {
  echo $saved_form_html;
}
?>
<img style="float: left" src="./images/trash_can.jpg" height="100px" width="100px" ondrop="trashDrop(event)" ondragover="allowDrop(event)">
</html>
