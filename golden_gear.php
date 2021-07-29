<?php
include "navigation.php";
if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) || !empty($_POST['raw_user_data'])) {
  $game_defines = new GameDefines();
  $game_json = $game_defines->game_json;
  if (empty($_POST['just_golden_gear'])) {
    $user_info = new UserDefines('', $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
  }
  $user_crusaders = '<div style="clear: both;font-weight: bold;">Updated as of patch version ' . $game_json->patch_version . '</div><table style="float: left; clear:both;"><tr>';
  $gear_level = array();
  for ($i = 1; $i < 21; $i++) {
    if (isset($_POST['level_' . $i])) {
      $gear_level[] = $i;
    }
  }
  $column_count = 0;
  foreach ($game_defines->crusaders AS $id => $crusader) {
    $crusader_name = '';
    $crusader_image_info = get_crusader_image($game_defines->crusaders[$crusader->id]->name);
    $image = $crusader_image_info['image'];
    $crusader_name = $crusader_image_info['name'];
    for ($i = 1; $i < 4; $i++) {
      if (!empty($game_defines->golden_gear[$id][$i])
      && (!empty($user_info->loot[$game_defines->golden_gear[$id][$i][4]->id])
          || !empty($user_info->loot[$game_defines->golden_gear[$id][$i][5]->id]))) {
        $crusader_loot_html[$i] = '<span style="background-color: gold;">';
      } else {
        $crusader_loot_html[$i] = '<span>';
      }
      //The 4 means it's accessing the GE data, 5 would be the GL. The names are the same so it doesn't matter
      $crusader_loot_html[$i] .= (!empty($game_defines->golden_gear[$id][$i][4]->name) ? $i . ':' . $game_defines->golden_gear[$id][$i][4]->name : $i . ':-') . '</span>';
    }
    if ($column_count > 4) {
      $user_crusaders .= '</tr></tr>';
      $column_count = 0;
    }
    $user_crusaders .= '<td><div style="clear:both;">' . $crusader->name . '<div style="float: left;height: 48px; width: 48px;background-repeat: no-repeat; background-size: contain;background-image: url(\'' . $image .'\')">' . $crusader_name . '</div></div><div style="clear: both;">' . implode('<br>', $crusader_loot_html) . '</div></td>';
    $column_count++;
  }
  $user_crusaders .= '</table>';
}

?>
<div style="color:red;">This will display all crusaders with thier golden gear and highlight in gold if you actually own it</div>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<div style="float: left;padding-right: 5px; clear: left;">
  User Id: <input type="text" name="user_id" size="1" value="<?php echo (isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''); ?>"><br>
  User Hash: <input type="password" name="user_hash" value="<?php echo (isset($_POST['user_hash']) ? htmlspecialchars($_POST['user_hash']) : ''); ?>"><br>
  <div>Fill out your user id and hash, or your raw user data, not both</div>
  Raw User Data: <input type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
  Just Display Golden Gear:<input type="checkbox" name= "just_golden_gear" value="1">
</div>
<input style="clear:both; float: left;" type="submit">
</form>
<?php
if (!empty($user_crusaders)) {
  echo $user_crusaders;
}
?>
</html>
