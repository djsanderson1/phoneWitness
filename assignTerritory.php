<?php
require_once('authenticate.php');
require_once('mysqlConnect.php');
  $territory_id = $_GET['territory_id'];
  $assigned_publisher_id = $_GET['assigned_publisher_id'];
  $sql = "
    UPDATE territories
       SET assigned_publisher_id = $assigned_publisher_id
     WHERE territory_id = $territory_id";
  noResponseSQL($sql);
  header('Location: territoryDetails.php?territory_id='.$territory_id.'&export_sortby=returned_date&export_sortdir=desc');
?>
