<?php require_once('authenticate.php'); ?>
<!doctype html>

<html>
  <head>
    <title>Phone Witness</title>
    <?php include 'style.php'; ?>
    <script src="/js/jquery-3.3.1.min.js"></script>
  </head>
  <script>
    var currentCount = 0;
    function timedPhoneCall() {
      document.getElementById("bellButton").style.display = "none";
      document.getElementById("activityPage").style.display = "none";
      document.getElementById("waitMsg").style.display = "inline";
      window.countdownInterval = setInterval(phoneCallCountDown, 1000);
    }
    function makePhoneCall() {
      document.getElementById("showNext").style.display = "inline";
      document.getElementById("waitMsg").style.display = "none";
    }
    function displayActivityPage() {
      document.getElementById("bellButton").style.display = "block";
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
    function playNotificationSound() {
      disableBell();
      var randomNum = Math.floor(Math.random() * 10)+1;
      var notification = new Audio('audio/notification' + randomNum + '.mp3');
      notification.play();
    }
    function disableBell() {
      var bellButton = document.getElementById("bellButton");
      bellButton.disabled = true;
      setTimeout(enableBell, 15000);
    }
    function enableBell() {
      var bellButton = document.getElementById("bellButton");
      bellButton.disabled = false;
    }
  </script>
  <body onload="timedPhoneCall();">
    <p id="waitMsg" style="display: none;">Please pass this device to the next person.<br><h1 id="countDown"></h1></p>
    <p id="showNext" style="display:none;">Click the link below when ready to make a call:<br><br>
      <a href="#" onclick="displayActivityPage(); playNotificationSound(); reloadData();">Make a Call</a>
    </p>
    <button type="button" onclick="playNotificationSound();" style="width:auto;" id="bellButton"><img src="images/bell.png"></button>
    <div id="activityPage" style="display:block;"></div>
  </body>
</html>
