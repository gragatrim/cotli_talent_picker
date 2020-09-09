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
<div style="color:red;">The slots count from the rightmost top slot down and to the left(sorry no images yet of empty forms)</div>
<form style="float: left;" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
Formation Id: <input type="text" name="formation_id" value="<?php echo (isset($_POST['formation_id']) ? htmlspecialchars($_POST['formation_id']) : ''); ?>"><br>
</div>
<div style="float: left; clear: left;">Enter the slot you want the crusader in next to their name</div>
<?php echo $all_crusaders; ?>
<input style="clear:both; float: left;" type="submit">
</form>
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
</html>
