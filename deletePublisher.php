<?php
  require_once('authenticate.php');
  $publisher_id = $_GET['publisher_id'];
  require_once('mysqlConnect.php');
  $sql = '
        DELETE FROM publishers
        WHERE publisher_id = ' . $publisher_id;
  noResponseSQL($sql);
  $newURL = 'publishers.php';
  header('Location: '.$newURL);
  if (session_status() == PHP_SESSION_NONE) {
        session_start();
  }
  $_SESSION["publisherChange"] = '<span id="dataChanged">Publisher has been deleted</span>';
?>
