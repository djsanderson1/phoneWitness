<?php require_once('authenticate.php'); ?>
<?php
$territory_id = $_GET['territory_id'];
require_once('mysqlConnect.php');
$sql = '
      DELETE FROM territories
      WHERE territory_id = ' . $territory_id;
noResponseSQL($sql);
$sql = '
      DELETE FROM residents
      WHERE territory_id = ' . $territory_id;
noResponseSQL($sql);
$newURL = 'territories.php';
header('Location: '.$newURL);
 ?>
