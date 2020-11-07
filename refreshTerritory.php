<?php
require_once('authenticate.php');
  include 'mysqlConnect.php';
  if(isset($_GET["territory_id"])) {
  $con->query("
    UPDATE residents
    SET status_id = NULL,
    last_called_date = NULL,
    number_of_tries = NULL,
    address_export_id = NULL
    WHERE (status_id2 <> 3 or status_id2 IS NULL)
      and (status_id <> 3 or status_id IS NULL)
      AND territory_id = " . $_GET['territory_id']
  );
  header('Location: territories.php?refreshed='.$_GET['territory_id']);
}
?>
