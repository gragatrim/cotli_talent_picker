<?php
include "navigation.php";

if (!empty($_POST) && is_numeric($_POST['max_area_reached']) && is_numeric($_POST['t2_11ths_completed'])) {
  $average_bi_drop = get_bi_drop_total($_POST['max_area_reached'], $_POST['t2_11ths_completed']);
}
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
T2 11ths Completed: <input type="text" name="t2_11ths_completed" value="<?php echo (isset($_POST['t2_11ths_completed']) ? $_POST['t2_11ths_completed'] : 9); ?>"><br>
Max area completed in FP: <input type="text" name="max_area_reached" value="<?php echo (isset($_POST['max_area_reached']) ? $_POST['max_area_reached'] : 5761); ?>"><br>
<input type="submit">
</form>
<?php
if (!empty($average_bi_drop)) {
  echo "<div>Average BI drop for area " . $_POST['max_area_reached'] . " is " . sprintf('%.2e', $average_bi_drop) . " idols</div>";
}
