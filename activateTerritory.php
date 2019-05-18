<?php
require_once('authenticate.php');
  include 'mysqlConnect.php';
  if(isset($_GET["territory_id"])) {
  $con->query("
    DELETE FROM territory_queue
    WHERE territory_id = " . $_GET['territory_id']
  );
  include 'mysqlConnect.php';
  if($con->query("
    INSERT INTO territory_queue
    (
      territory_id,
      order_number
    )
    VALUES
    (
      ".$_GET['territory_id'].",
      (select max(order_number)+1 FROM territory_queue as thisTerritory)
    )
  ")) {
      header('Location: territories.php?activated='.$_GET['territory_id']);
  } else {
    printf("Error: %s\n", $con->error);
  }

}

 ?>
