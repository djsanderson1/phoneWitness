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
if(!isset($_POST["territory_id"]) ) {
  exit("Form not submitted. Please press back button on browser and try submitting the form again.");
}
require_once('authenticate.php');

// set up form field vars
$name = $_POST["name"];
$status = $_POST["status"];
$address = $_POST["address"];
$phone = $_POST["phone"];
$last_called = $_POST["last_called"];
$number_of_tries = $_POST["number_of_tries"];
$last_called_line = "'$last_called'";
if($last_called === '') {
  $last_called_line = "NULL";
}
function fixBlankInt($int) {
  if($int == '') {
    return "NULL";
  } else {
    return $int;
  }
}
$status = fixBlankInt($status);
$number_of_tries = fixBlankInt($number_of_tries);
$territory_id = $_POST["territory_id"];
$sql =
"INSERT INTO residents
    (
      name,
      status_id,
      address,
      phone_number,
      last_called_date,
      number_of_tries,
      territory_id
    )

    values
    (
      '$name',
      $status,
      '$address',
      '$phone',
      $last_called_line,
      $number_of_tries,
      $territory_id
    )
";
include 'mysqlConnect.php';
$successMsg = "Resident Added";
$failMsg = "Add Resident Failed";
noResponseSQL($sql,$successMsg,$failMsg);
 ?>
</body>
</html>
