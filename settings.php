<?php
$campaignModeTypeID = 1;

function getCampaignMode() {
  global $campaignModeTypeID;
  $qry = "SELECT *
    FROM settings
    WHERE congregation_id = 1 and setting_type_id = $campaignModeTypeID";
  include("mysqlConnect.php");
  $res = $con->query($qry);
  while ($row = $res->fetch_assoc()) {
    return $row['setting_value'];
  }
}

function setUserSetting($setting_type_id = 0, $value = "", $user_id = $_SESSION["userID"]) {
  $deleteQuery = "DELETE FROM settings WHERE user_id = '$user_id' AND setting_type_id = '$setting_type_id'";
  $insertQuery = "INSERT INTO settings
    (
      user_id,
      setting_type_id,
      setting_value
    )

    VALUES (
      '$user_id',
      '$setting_type_id',
      '$value'
    )";
  include("mysqlConnect.php");
  noResponseSQL($deleteQuery);
  noResponseSQL($insertQuery);
}

function getUserSetting($setting_type_id = 0, $user_id = $_SESSION["userID"]) {
  $qry = "SELECT *
    FROM settings
    WHERE user_id = $user_id
      AND setting_type_id = $setting_type_id";
  include("mysqlConnect.php");
  $res = $con->query($qry);
  while ($row = $res->fetch_assoc()) {
    return $row['setting_value'];
  }
}
 ?>
