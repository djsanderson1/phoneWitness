<?php
include 'mysqlConnect.php';

if(isset($_GET["territory_id"])) {
  $con->query("
    UPDATE residents
    SET status_id = NULL,
    last_called_date = NULL
    WHERE territory_id = " . $_GET['territory_id']
  );
  header('Location: territories.php?refreshed='.$_GET['territory_id']);
}
 ?>
