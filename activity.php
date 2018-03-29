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
include 'mysqlConnect.php';

if(isset($_GET["status_id"]) && isset($_GET["resident_id"])) {
  $con->query("
    UPDATE residents
    SET status_id = " . $_GET['status_id'] . ",
    last_called_date = date(now())
    WHERE resident_id = " . $_GET['resident_id']
  );
  header('Location: betweenCalls.php');
}
$res=$con->query("
SELECT *
  FROM territory_queue
  LEFT JOIN residents
  USING(territory_id)
  WHERE territory_queue.territory_id > 0
  AND (last_called_date < date(now()) OR last_called_date IS NULL)
  AND (status_id IN(1,2) OR status_id IS NULL)
  AND (exported_address = 0 OR exported_address IS NULL)
   ORDER BY territory_queue.order_number, last_called_date, resident_id
   LIMIT 1
    ");
while ($row = $res->fetch_assoc()) {
  echo "<a href='tel:" . $row["phone_number"] . "'>" . $row["phone_number"] . "</a><br><br>" . $row["address"];
  echo '
  </h2>
  <button type="button" onclick="result = confirm(' . "'Are you sure?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">Disconnected</button><br>
  <button type="button" onclick="result = confirm(' . "'Are you sure?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">No Answer</button><br>
  <button type="button" onclick="result = confirm(' . "'Are you sure?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">Do Not Call</button><br>
  <button type="button" onclick="result = confirm(' . "'Are you sure?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">Contacted</button><br>
  <button type="button" onclick="result = confirm(' . "'Are you sure?'" . '); if(result){location.href=' . "'activity.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '}">Foreign Language</button><br>
<a href="standard.php" style="color:black;cursor:default;" class="noselect">Skip to Next</a>
  ';
}
?>
  </h2>
</body>
</html>
