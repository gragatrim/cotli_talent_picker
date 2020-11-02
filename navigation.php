<?php
include_once "utility.php";
include_once "game_defines.php";
include_once "user_defines.php";
?>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

table.borderless {
  border: none;
}

th.borderless {
  border: none;
}

td.borderless {
  border: none;
}

.hidden {
  display: none;
}

.colorblindblue {
  background: #016ba5;
}

.colorblindred {
  background: #ca4e0a;
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
  clear: left;
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

.formation_div {
  background-repeat: no-repeat;
  background-size: contain;
  height: 48px;
}

.Water {
  background: #0bc0ff;
}

.Air {
  background: #ffe00a;
}

.Earth {
  background: #3df93d;
}

.Fire {
  background: #d5100e;
}

.Soul {
  background: #a14ffb;
}

.globalClick {
  background: #54478c;
}

.selfDPS {
  background: #2c699a;
}

.globalDPS {
  background: #048ba8;
}

.maxLevel {
  background: #0db39e;
}

.gold {
  background: #16db93;
}

.missionEP {
  background: #83e377 ;
}

.missionGold {
  background: #b9e769;
}

.shareEP {
  background: #efea5a;

}

.missionSpeed {
  background: #f1c453;
}

.missionDouble {
  background: #f29e4c;
}

table.formation_table {
  height: 336px;
  width: 240px;
  border: none;
  background-color: #ccc;
}
td.formation_table {
  background-repeat: no-repeat;
  background-size: contain;
  border: none;
}
</style>
<script>
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  if (document.getElementById(data) === null) {
    return;
  }
  var previousImageElement = document.getElementById(data).parentNode;
  var previousImage = document.getElementById(data);
  var targetImage = ev.target;
  previousImage.setAttribute("width", 40);
  previousImage.setAttribute("height", 40);
  ev.target.parentNode.replaceChild(previousImage, ev.target);
  if (previousImageElement.id === "td_" + data && document.getElementById("td_" + ev.target.id) !== null) {
    //This handles putting the crusader back where they should go in the seat order
    var originalTd = document.getElementById("td_" + ev.target.id);
    targetImage.setAttribute("width", 48);
    targetImage.setAttribute("height", 48);
    originalTd.replaceChild(targetImage, originalTd.childNodes[0]);
    //This handles putting a red X in the seat where the crusader that was dropped came from
    var redX = document.createElement("img");
    redX.setAttribute("src", "./images/empty_slot.png");
    redX.setAttribute("width", 40);
    redX.setAttribute("height", 40);
    previousImageElement.appendChild(redX);
  } else {
    previousImageElement.appendChild(targetImage);
  }
}

function trashDrop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  if (document.getElementById(data) === null) {
    return;
  }
  var redX = document.createElement("img");
  redX.setAttribute("src", "./images/empty_slot.png");
  redX.setAttribute("width", 40);
  redX.setAttribute("height", 40);

  var previousImageDiv = document.getElementById(data).parentNode;

  var previousImage = document.getElementById(data);
  previousImage.setAttribute("width", 48);
  previousImage.setAttribute("height", 48);

  var originalTd = document.getElementById("td_" + data);
  previousImageDiv.replaceChild(redX, previousImageDiv.childNodes[0]);
  originalTd.replaceChild(previousImage, originalTd.childNodes[0]);
}
</script>
</head>
<body>
<a href="./dungeon_calc.php">Dungeon Calculator</a> | <a href="./cotli_talents.php">Talent Picker</a> | <a href="./player_history.php">Player History</a>
| <a href="./create_achievement_wiki.php">Create achievement wiki text</a> | <a href="./create_crusader_wiki.php">Create crusader wiki text</a> | <a href="./create_event_wiki.php">Create event wiki text</a>
| <a href="./player_saved_formations.php">View saved formations</a> | <a href="./create_formations.php">Create formations</a><a href="./create_formations_visual.php">(Visual editor)</a> | <a href="./user_profile.php">User profile</a>
| <a href="./runes.php">View Rune Info</a>
<br>

