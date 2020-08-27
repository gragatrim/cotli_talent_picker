<?php
function format($number) {
  $formatted_number = '';
  $decimal_position = strpos($number, '.');
  if (bccomp($number, '0', 40) === 0) {
    $formatted_number = '0';
  } else if (strpos($number, '0') === 0) {
    $ltrim = ltrim($number, '0.');
    $ltrim_strlen = strlen($ltrim);
    $number_strlen = strlen($number);
    $exponent = '-' . ($number_strlen - $ltrim_strlen - 1);
    $base = substr($ltrim,0,1);
    $decimal = substr($ltrim,1,2);
    $formatted_number = $base . "." . $decimal . "E" . $exponent;
  } else if ($decimal_position > 2 || ($decimal_position === false && strlen($number) > 3)) {
    if ($decimal_position !== false) {
      $exponent_value = (strlen(substr($number, 0, $decimal_position)) - 1);
    } else {
      $exponent_value = strlen($number) - 1;
    }
    $exponent = '+' . $exponent_value;
    $base = substr($number,0,1);
    $decimal = substr($number,1,2);
    $formatted_number = $base . "." . $decimal . "E" . $exponent;
  } else {
    $formatted_number = sprintf("%.2E", $number);
  }
  return $formatted_number;
}
?>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

.hidden {
  display: none;
}

.green {
  background: green;
}

.red {
  background: red;
}

.yellow {
  background: yellow;
}

.purple {
  background: #8f4aa5;
}

.brown {
  background: #a6611a;
}

.blue {
  background: #2c7bb6;
}

.legend {
  width: 350px;
}
</style>
</head>
<body>
<a href="./dungeon_calc.php">Dungeon Calculator</a> | <a href="./cotli_talents.php">Talent Picker</a> | <a href="./player_history.php">Player History</a>
<br>

