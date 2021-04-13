<?php
include_once "utility.php";
include_once "talents.php";
include_once "game_defines.php";
include_once "user_defines.php";
?>
<html>
<head>
<link rel="shortcut icon" href="./favicon.ico">
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

.mission_gear_upgrade {
  color: goldenrod;
  font-weight: bold;
}

.mission_enchantment {
  color: blue;
  font-weight: bold;
}

.mission_gold {
  color: red;
  font-weight: bold;
}

.mission_red_rubies {
  color: mediumvioletred;
  font-weight: bold;
}

.mission_chest {
  color: coral;
  font-weight: bold;
}

.mission_buff {
  color: dimgray;
  font-weight: bold;
}

.mission_idols {
  color: #6a0499;
  font-weight: bold;
}

.mission_claim_crusader {
  color: magenta;
  font-weight: bold;
}

.mission_crafting_recipe {
  color: cadetblue;
  font-weight: bold;
}

.mission_crafting_materials {
  color: green;
  font-weight: bold;
}

.gem_solvent {
  color: navy;
  font-weight: bold;
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
  var targetImage = ev.target;
  var replacingImage = document.getElementById(data);
  var replacingImageParent = replacingImage.parentNode;
  var swappedSize = 40;
  if (replacingImage.width == 48) {
    swappedSize = 48;
  }
  replacingImage.setAttribute("width", 40);
  replacingImage.setAttribute("height", 40);
  var redX = document.createElement("img");
  redX.setAttribute("src", "./images/empty_slot.png");
  redX.setAttribute("width", 48);
  redX.setAttribute("height", 48);
  redX.id = data;
  var originalTd = document.getElementById("td_" + targetImage.id);

  replacingImage.id = "img_form_" + data.split("_").pop();
  targetImage.parentNode.replaceChild(replacingImage, targetImage);

  if(document.getElementById("td_" + targetImage.id.split("_").pop()) !== null && replacingImageParent.id.split("_")[0] == "td") {
    var replacedCrusader = targetImage;
    var replacedCrusaderOriginalElement = document.getElementById(targetImage.id.split("_").pop());
    targetImage.setAttribute("width", swappedSize);
    targetImage.setAttribute("height", swappedSize);
    targetImage.setAttribute("style", '');

    replacingImage.parentNode.replaceChild(replacingImage, replacingImage);

    targetImage.id = targetImage.id.split("_").pop();
    replacedCrusaderOriginalElement.parentNode.replaceChild(targetImage, replacedCrusaderOriginalElement);

    replacingImageParent.appendChild(redX);
  } else {
    targetImage.setAttribute("width", swappedSize);
    targetImage.setAttribute("height", swappedSize);
    targetImage.setAttribute("style", '');
    if (targetImage.src.split("/").pop() == 'empty_slot.png' && data.substring(0,8) !== 'img_form') {
      targetImage.id = data;
    }
    replacingImageParent.appendChild(targetImage);
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
  redX.id = 'img_form_crusader';

  var previousImageDiv = document.getElementById(data).parentNode;

  var previousImage = document.getElementById(data);
  previousImage.id = data.split("_").pop();
  previousImage.setAttribute("width", 48);
  previousImage.setAttribute("height", 48);
  previousImage.setAttribute("style", '');

  var originalTd = document.getElementById("td_" + data);
  if (originalTd === null) {
    originalTd = document.getElementById("td_" + data.split("_").pop());
  }
  previousImageDiv.replaceChild(redX, previousImageDiv.childNodes[0]);
  originalTd.replaceChild(previousImage, originalTd.childNodes[0]);
}
</script>
</head>
<body>
<a href="./dungeon_calc.php">Dungeon Calculator</a> | <a href="./cotli_talents.php">Talent Picker</a> | <a href="./player_history.php">Player History</a>
| <a href="./create_achievement_wiki.php">Create achievement wiki</a> | <a href="./create_crusader_wiki.php">Create crusader wiki</a> | <a href="./create_event_wiki.php">Create event wiki</a>
| <a href="./player_saved_formations.php">View saved formations</a> | <a href="./create_formations_visual.php">Create formations</a><a href="./create_formations.php">(old method)</a> | <a href="./user_profile.php">User profile</a>
| <a href="./runes.php">View Rune Info</a>(<a href="./fifth_runes.php">5th scaling)</a>
| <a href="./best_mission_crusaders.php">Mission Calc(beta)</a>
| <a href="https://github.com/gragatrim/cotli_talent_picker">Github</a>
<br>
