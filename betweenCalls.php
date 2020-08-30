<?php require_once('authenticate.php'); ?>
<!doctype html>

<html>
  <head>
    <title>Phone Witness</title>
    <?php include 'style.php'; ?>
  </head>
  <script>
    var currentCount = 0;
    function timedPhoneCall() {
      document.getElementById("activityPage").style.display = "none";
      document.getElementById("waitMsg").style.display = "inline";
      window.countdownInterval = setInterval(phoneCallCountDown, 1000);
    }
    function makePhoneCall() {
      document.getElementById("showNext").style.display = "inline";
      document.getElementById("waitMsg").style.display = "none";
    }
    function displayActivityPage() {
      document.getElementById("showNext").style.display = "none";
      document.getElementById("activityPage").style.display = "block";
    }
    function reloadData() {
      $( "#activityPage" ).load( "activity.php" );
    }
    function phoneCallCountDown() {
      var countDown = document.getElementById("countDown");
      countDown.innerHTML = currentCount;
      if(currentCount > 0) {
        countDown.style.display = "inline";
        currentCount--;
      } else {
        countDown.style.display = "none";
        currentCount = 0;
        clearInterval(window.countdownInterval);
        makePhoneCall();
      }
    }
  </script>
  <body onload="timedPhoneCall();">
    <p id="waitMsg" style="display: none;">Please pass this device to the next person.<br><h1 id="countDown"></h1></p>
    <p id="showNext" style="display:none;">Click the link below when ready to make a call:<br><br>
      <a href="#" onclick="displayActivityPage(); playNotificationSound(); reloadData();">Make a Call</a>
    </p>
    <div id="activityPage" style="display:block;"><?php include 'activity.php'; ?></div>
  </body>
</html>
