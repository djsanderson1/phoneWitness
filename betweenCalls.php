<!doctype html>

<html>
  <head>
    <title>Phone Witness</title>
    <?php include 'style.php'; ?>
  </head>
  <script>
    function timedPhoneCall() {
      document.getElementById("activityPage").style.display = "none";
      document.getElementById("waitMsg").style.display = "inline";
      setTimeout(makePhoneCall, 30000);
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
  </script>
  <body>
    <p id="waitMsg" style="display: none;">Please pass this device to the next person.</p>
    <p id="showNext" style="display:none;">Click the link below when ready to make a call:<br><br>
      <a href="#" onclick="displayActivityPage(); playNotificationSound(); reloadData();">Make a Call</a>
    </p>
    <div id="activityPage" style="display:block;"><?php include 'activity.php'; ?></div>
  </body>
</html>
