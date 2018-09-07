<!doctype html>
<html>
<head>
  <script type = "text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
    function playNotificationSound() {
      var notification = new Audio('audio/notification.mp3');
      notification.play();
    }
    function playButtonSound() {
      var playButton = new Audio('audio/playButton.mp3');
      playButton.play();
    }
  </script>
  <style>
    button {
      padding: 5px;
      font-size: 25pt;
      width: 300px;
      margin: 20px;
    }
    .noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
    }

  </style>
  <title>Phone Calls View</title>
  <?php include 'style.php'; ?>
</head>
<body onload="playNotificationSound();">
<button type="button" onclick="playButtonSound();" style="width:auto;"><img src="images/bell.png"></button>
  <h2 class="phone_number">
<?php
if(isset($_GET['resident_id'])) {
  $resident_id = $_GET['resident_id'];
}
require_once('fxUpdateTerritory.php');
require_once('fxGetResidentDetails.php');
if(isset($_GET["status_id"]) && isset($resident_id)) {
// uses status_id2 field for do not calls and day sleepers
  if($_GET['status_id']=="3" or $_GET['status_id']=="6") {
    $statusField = "status_id2";
  } else {
    $statusField = "status_id";
  }
  include 'mysqlConnect.php';
  $con->query("
    UPDATE residents
    SET " . $statusField . " = " . $_GET['status_id'] . ",
    last_called_date = date(now()),
    number_of_tries = COALESCE(number_of_tries,0)+1
    WHERE resident_id = " . $_GET['resident_id']
  );
  $territory_id = getTerritoryFromResident($resident_id);
  $lastWorkedDate = date("Y-m-d");

  updateTerritoryLastWorkedDate($territory_id, $lastWorkedDate);
  header('Location: betweenCalls.php');
}
include 'mysqlConnect.php';
$res=$con->query("
SELECT *
  FROM territory_queue
  LEFT JOIN residents
  USING(territory_id)
  WHERE territory_queue.territory_id > 0
  AND (last_called_date < date(now()) OR last_called_date IS NULL)
  AND (status_id IN(1,2) OR status_id IS NULL)
  AND (status_id2 NOT IN(3,6) OR status_id2 IS NULL)
  AND (number_of_tries < 3 OR number_of_tries IS NULL)
  AND (phone_number IS NOT NULL)
  AND (phone_number <> '')
   ORDER BY territory_queue.order_number, last_called_date, resident_id
   LIMIT 1
    ");
while ($row = $res->fetch_assoc()) {
  // Line below displays resident's name for campaign mode
  echo $row["name"] . '<br><br>';
  echo "<a href='tel:" . $row["phone_number"] . "'>" . $row["phone_number"] . "</a><br><br>" . $row["address"];
  echo '</h2>';
  /* commented out for campaign mode */
  echo '
  </h2>';
  require_once 'mysqlConnect.php';
  require_once 'displayHelper.php';
  $button_group_id = getVar('button_group_id',0);
  $sql = " select * FROM buttons INNER JOIN button_groups USING(button_group_id) where if($button_group_id>0, button_groups.button_group_id = $button_group_id, button_group_order = 1 )";
  $res2=$con->query($sql);
  while ($row2 = $res2->fetch_assoc()) {
  echo '
  <button type="button" onclick="result = confirm(' . "'" . $row2["confirm_message"] . "'" . '); if(result){location.href=' . "'activity.php?status_id=" . $row["status_id"] . "&resident_id=" . $row["resident_id"] . "&next_button_id=" . $row["next_button_id"] . "'" . '}">' . $row2['button_display'] . '</button><br>';
  /* commented out so the new automatic buttons will work
  <button type="button" onclick="result = confirm(' . "'Did nobody answer?'" . '); if(result){location.href=' . "'activity.php?status_id=2&resident_id=" . $row["resident_id"] . "'" . '}">No Answer</button><br>
  <button type="button" onclick="result = confirm(' . "'Is this a do not call?'" . '); if(result){location.href=' . "'activity.php?status_id=3&resident_id=" . $row["resident_id"] . "'" . '}">Do Not Call</button><br>
  <button type="button" onclick="result = confirm(' . "'Did you contact someone?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">Contacted</button><br>
  <button type="button" onclick="result = confirm(' . "'Did you find interest with a person who speaks a foreign language?'" . '); if(result){location.href=' . "'activity.php?status_id=5&resident_id=" . $row["resident_id"] . "'" . '}">Foreign Language</button><br>
  <button type="button" onclick="result = confirm(' . "'Does this person sleep during the day?'" . '); if(result){location.href=' . "'activity.php?status_id=6&resident_id=" . $row["resident_id"] . "'" . '}">Day Sleeper</button><br>
<a href="standard.php" style="color:black;cursor:default;" class="noselect">Skip to Next</a>
  ';
  */
  /* comment out for campaign mode
  echo '
  <button type="button" onclick="result = confirm(' . "'Did you contact someone for the Invitation?'" . '); if(result){location.href=' . "'activity.php?status_id=7&resident_id=" . $row["resident_id"] . "'" . '}">Contacted for Invitation</button><br> */
  /* commented out so the new automatic buttons will work
  echo '
  <button type="button" onclick="result = confirm(' . "'Mismatched Address / Phone?'" . '); if(result){location.href=' . "'activity.php?status_id=8&resident_id=" . $row["resident_id"] . "'" . '}">Mismatched Address / Phone</button>
  ';
  */
  }
}
?>
  </h2>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><a href="logout.php" class="navbar">Logout</a>
</body>
</html>
