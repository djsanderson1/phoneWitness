<!doctype html>

<html>
  <head>
    <title>Phone Witness</title>
    <?php include 'style.php'; ?>
  </head>
  <script>
    function timedPhoneCall() {
      setTimeout(makePhoneCall, 10000);
    }
    function makePhoneCall() {
      document.getElementById("showNext").style.display = "inline";
      document.getElementById("waitMsg").style.display = "none";
    }
  </script>
  <body onload="timedPhoneCall();">
    <p id="waitMsg">Please pass this device to the next person.</p>
    <p id="showNext" style="display:none;">Click the link below when ready to make a call:<br><br>
      <a href="activity.php">Make a Call</a>
    </p>
  </body>
</html>
