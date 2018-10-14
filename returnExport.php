<?php
$address_export_id = $_GET['address_export_id'];
$territory_id = $_GET['territory_id'];
$export_sortby = $_GET['export_sortby'];
$export_sortdir = $_GET['export_sortdir'];
require_once('mysqlConnect.php');
$qry = "UPDATE address_exports SET returned_date = curdate() WHERE address_export_id = " . $address_export_id;
noResponseSQL($qry);
header('Location: territoryDetails.php?territory_id='.$territory_id.'&export_sortby='.$export_sortby.'&export_sortdir='.$export_sortdir);
 ?>
