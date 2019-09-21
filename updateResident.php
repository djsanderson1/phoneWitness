<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Resident</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Edit Resident</h1>
<?php

// check for post fields and if not exit with error
if(!isset($_POST["resident_id"]) ) {
  exit("Form not submitted. Please press back button on browser and try submitting the form again.");
}
require_once('authenticate.php');

// set up form field vars
$name = $_POST["name"];
$status = $_POST["status"];
$address = $_POST["address"];
$phone = $_POST["phone"];
$last_called = $_POST["last_called"];
$resident_id = $_POST["resident_id"];
$number_of_tries = $_POST["number_of_tries"];
$last_called_line = "last_called_date = '$last_called'";
if($last_called === '') {
  $last_called_line = "last_called_date = NULL";
}
$sql =
"UPDATE residents
    SET
 name = '$name',
 status_id = '$status',
 address = '$address',
 phone_number = '$phone',
 $last_called_line,
 number_of_tries = $number_of_tries
  WHERE resident_id = $resident_id";
include 'mysqlConnect.php';
$successMsg = "Resident Updated";
$failMsg = "Resident Update Failed";
noResponseSQL($sql,$successMsg,$failMsg);
 ?>
</body>
</html>
