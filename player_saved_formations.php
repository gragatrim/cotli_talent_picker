<?php
include_once "navigation.php";
$game_defines = new GameDefines();
$game_json = $game_defines->game_json;

if (!empty($_POST['user_id']) && !empty($_POST['user_hash']) && !empty($_POST['server']) || !empty($_POST['raw_user_data'])) {
  $user_info = new UserDefines($_POST['server'], $_POST['user_id'], $_POST['user_hash'], $_POST['raw_user_data']);
  $saved_form_html = generate_saved_forms($user_info->formation_saves['campaigns'], $game_defines);
  $saved_form_html .= generate_saved_forms($user_info->formation_saves['challenges'], $game_defines);
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
  Raw User Data: <input autocomplete="off" type="text" name="raw_user_data" value="<?php echo (isset($_POST['raw_user_data']) ? htmlspecialchars($_POST['raw_user_data']) : ''); ?>"><br>
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
