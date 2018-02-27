<?php
  include 'mysqlConnect.php';
  $con->query("
    UPDATE residents
    SET status_id = NULL,
    last_called_date = NULL,
    number_of_tries = NULL
    WHERE territory_id = " . $_GET['territory_id']
  );
  header('Location: territories.php');
?>
