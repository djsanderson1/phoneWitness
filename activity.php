<!doctype html>
<html>
<head>
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
  <?php include 'style.php';

  ?>
  
</head>
<body onload="playNotificationSound();">
  Phone numbers ready to call:
  <?php
    require_once("functions/publishers/getPublishers.php");
    if(!isset($_SESSION)) {
      session_start();
    }
    $publisher_id = getPublisherFromUser($_SESSION["userID"]);
    $sql = "
    SELECT count(*) AS ready_to_call FROM residents
    LEFT JOIN territory_queue using(territory_id)
    INNER JOIN territories ON territories.territory_id = territory_queue.territory_id
    WHERE (status_id IN(1,2) OR status_id IS NULL) AND phone_number IS NOT NULL AND phone_number <> ''
    AND territory_queue.order_number > 0
    AND (number_of_tries < 3 OR number_of_tries IS NULL)
    AND status_id2 IS NULL
    AND (last_called_date < date(now()) OR last_called_date IS NULL)
    AND territories.assigned_publisher_id = '$publisher_id'
    AND (residents.last_accessed_time < DATE_SUB(NOW(), INTERVAL 1 HOUR) OR residents.last_accessed_time IS NULL)
        ";
    $res=$con->query($sql);
    while ($row = $res->fetch_assoc()) {
      echo $row["ready_to_call"];
      if($row['ready_to_call'] == 0) {
        echo '<br><br>No phone numbers available. Please wait until tomorrow or check out more territory.<h3><a href="standard.php">Back</a>';
        exit;
      }
    }
  ?><br>

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
    last_called_time = time(now()),
    number_of_tries = COALESCE(number_of_tries,0)+1
    WHERE resident_id = " . $_GET['resident_id']
  );
  $territory_id = getTerritoryFromResident($resident_id);
  $lastWorkedDate = date("Y-m-d");

  updateTerritoryLastWorkedDate($territory_id, $lastWorkedDate);
  header('Location: betweenCalls.php?from=activityPage');
}
include 'mysqlConnect.php';
$res=$con->query("
SELECT *
  FROM territory_queue
  LEFT JOIN residents
  USING(territory_id)
  LEFT JOIN territories ON territories.territory_id = territory_queue.territory_id
  WHERE territory_queue.territory_id > 0
  AND (last_called_date < date(now()) OR last_called_date IS NULL)
  AND (status_id IN(1,2) OR status_id IS NULL)
  AND (status_id2 NOT IN(3,6) OR status_id2 IS NULL)
  AND (number_of_tries < 3 OR number_of_tries IS NULL)
  AND (phone_number IS NOT NULL)
  AND (phone_number <> '')
  AND (residents.last_accessed_time < DATE_SUB(NOW(), INTERVAL 1 HOUR) OR residents.last_accessed_time IS NULL)
  AND territories.assigned_publisher_id = '$publisher_id'
   ORDER BY territory_queue.order_number, last_called_date, resident_id
   LIMIT 1
    ");
while ($row = $res->fetch_assoc()) {
  // Line below displays resident's name for campaign mode
  echo $row["name"] . '<br><br>';
  echo "<a href='tel:" . $row["phone_number"] . "' id='phoneNumber'>" . $row["phone_number"] . "</a><br><br>" . $row["address"];
  echo '</h2>';
  /* commented out for campaign mode */
  echo '</h2>';
  require_once("settings.php");
  $lblContacted = "Contacted";
  $dlgContacted = "Did you contact someone?";
  if(getCampaignMode() === "checked") {
    // lbl is short for label
    $lblContacted = "Completed";
    $dlgContacted = "Did you remember to write down the address if you didn\'t talk to a person?";
  }
  $btnStart = '<button type="button" onclick="result = confirm(';
  echo $btnStart . "'Was this number disconnected?'" . '); if(result){$.get(' . "'activity.php?status_id=1&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="disconnected">Disconnected</button><br class="disconnected">';
  echo $btnStart . "'Did nobody answer?'" . '); if(result){$.get(' . "'activity.php?status_id=2&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="noAnswer">No Answer</button><br class="noAnswer">';
  echo $btnStart . "'Is this a do not call?'" . '); if(result){$.get(' . "'activity.php?status_id=3&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="doNotCall">Do Not Call</button><br class="doNotCall">';
  echo $btnStart . "'$dlgContacted'" . '); if(result){$.get(' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="contacted">'.$lblContacted.'</button><br class="contacted">';
  echo $btnStart . "'Did you find interest with a person who speaks a foreign language?'" . '); if(result){$.get(' . "'activity.php?status_id=5&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="foreignLanguage">Foreign Language</button><br class="foreignLanguage">';
  echo $btnStart . "'Does this person sleep during the day?'" . '); if(result){$.get(' . "'activity.php?status_id=6&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="daySleeper">Day Sleeper</button><br class="daySleeper">';
  echo $btnStart . "'Mismatched Address / Phone?'" . '); if(result){$.get(' . "'activity.php?status_id=8&resident_id=" . $row["resident_id"] . "'" . ');timedPhoneCall();}" class="mismatch">Mismatched Address / Phone</button><br class="mismatch">';
  echo '<a href="standard.php" style="color:black;cursor:default;" class="noselect">Skip to Next</a>';
  if(!isset($_GET["status_id"]) && !isset($resident_id)) {
    $sql = "update residents SET last_accessed_time = now() WHERE resident_id = ".$row['resident_id'];
    noResponseSQL($sql);
  }
}

?>
  </h2>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><a href="logout.php" class="navbar">Logout</a>
</body>
</html>
