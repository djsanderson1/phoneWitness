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

 ?>
