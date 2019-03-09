<?php require_once('authenticate.php'); ?>
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
      <form action="admin.php">
      <div>
        <label for="campaignMode">Campaign Mode</label>
      </div>
      <div>
        <?php
          require_once("csSettings.php");
          $settings = New settings();
          $campaign = New campaign();
          $campaignMode=$campaign->getMode();
        ?>
        <input type="checkbox" name="campaignMode" <?php echo $campaignMode; ?>>
      </div>
    </div>
  </body>
</html>
