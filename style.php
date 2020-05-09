<?php
echo '
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body, button, h2 {
  ';
include 'mysqlConnect.php';
$res=$con->query("SELECT * FROM styles");
while ($row = $res->fetch_assoc()) {
  $style_value = $row['style_value'];
  $style_name = $row['style_name'];
  echo $style_name . ':' . $style_value . ';';
}
require_once("settings.php");
if(getCampaignMode() === "checked") {
  $noDisplay = "display: none;";
  $display = "display: inline;";
  $mismatch = $noDisplay;
  $daySleeper = $noDisplay;
  $foreignLanguage = $noDisplay;
  $contacted = $display;
  $doNotCall = $display;
  $noAnswer = $noDisplay;
  $disconnected = $noDisplay;
} else {
  $noDisplay = "display: none;";
  $display = "display: inline;";
  $mismatch = $display;
  $daySleeper = $display;
  $foreignLanguage = $display;
  $contacted = $display;
  $doNotCall = $display;
  $noAnswer = $display;
  $disconnected = $display;
}
echo '
}
.mismatch {
  '.$mismatch.'
}
.disconnected {
  '.$disconnected.'
}
.noAnswer {
  '.$noAnswer.'
}
.doNotCall {
  '.$doNotCall.'
}
.contacted {
  '.$contacted.'
}
.foreignLanguage {
  '.$foreignLanguage.'
}
.daySleeper {
  '.$daySleeper.'
}
ul.navbar {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}
@media only screen and (min-device-width: 500px) {
  li.navbar {
      float: left;
  }
}
@media only screen and (max-device-width: 499px) {
  li.navbar {
      text-align: left;
  }
  body {
    width: 100%;
  }
}
li.navbar a.navbar {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change the link color to #111 (black) on hover */
li.navbar a:hover {
    background-color: #111;
}
th {
  background-color: #555;
}
table {
  border: 1px white solid;
}
a {
  color: lightgreen;
  text-decoration: underline;
  cursor: pointer;
}
button {
  background-color: #cccccc;
  color: black;
  font-weight: bold;
  margin: 10px;
}
.button {
  background-color: #333;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
.button:hover {
  background-color: #999;
}
h2 {
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 10px;
  line-height: 14px;
}
label {
  font-weight: bold;
}
.territoryImage {
  width: 90%;
  max-width: 500px;
}
table {
    border-spacing: 0px;
}
td {
    border-top: #333333 1px solid;
}
tr:hover {
    background-color: #333333;
}
#dataChanged {
  background-color: #333;
  font-size: 12pt;
  font-weight: bold;
  color: #fff;
}
.nohover:hover {
  background-color: inherit;
}
th a {
    padding: 10px;
}
th a:hover {
  background-color: black;
}
</style>';
?>
