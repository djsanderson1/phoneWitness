<?php
require_once('authenticate.php');
  include 'mysqlConnect.php';
  if(isset($_GET["territory_id"])) {
  $con->query("
    DELETE FROM territory_queue
    WHERE territory_id = " . $_GET['territory_id']
  );
}
header('Location: territories.php?activated='.$_GET['territory_id']);
 ?>
