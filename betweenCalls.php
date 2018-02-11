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
    <p id="waitMsg">Please wait while the next phone number is loaded.</p>
    <p id="showNext" style="display:none;">Click the link below when ready to make a call:<br><br>
      <a href="standard.php">Make a Call</a>
    </p>
  </body>
</html>
