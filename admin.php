<?php
require_once('authenticate.php');
require_once("settings.php");
// if statement below checks for form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['campaignMode'])) {
      $campaignMode = $_POST['campaignMode'];
  } else {
    $campaignMode = "";
  }
  require_once("mysqlConnect.php");
  noResponseSQL("
    UPDATE settings
    SET setting_value = '" . $campaignMode . "'
    where congregation_id = 1
    AND setting_type_id = 1
    ");
  echo "Campaign Mode set to: $campaignMode";
  $_SERVER['REQUEST_METHOD'] == 'GET';
}
$campaignMode = getCampaignMode();
?>
<!doctype html>
<html>
  <head>
    <title>Admin</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Welcome to the admin homepage</h1>
    <p>From here you can click on the territories link to view or modify existing
      territories or click on the Add Territory link to add a new territory. You can
      also manage users from here as well.
    </p>
    <h2>Global Settings</h2>
    <div>
      <form action="admin.php" method="post">
      <div>
        <label for="campaignMode" style="font-size: 12pt;">Campaign Mode</label>

        <input type="checkbox" value="checked" name="campaignMode" <?php echo $campaignMode; ?>>
        <input type="submit">
      </div>
    </div>
  </body>
</html>
