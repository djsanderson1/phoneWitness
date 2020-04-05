<!doctype html>
<?php
require_once('authenticate.php');
?>

<html>
 <head>
   <title>Admin</title>
   <?php include 'style.php'; ?>

 </head>
 <body onload="exportForm.howMany.focus();">
   <?php include 'navbar.php'; ?>
   <h2>Please select which type of export you would like to perform.</h2>
   <a href="export_addresses.php" class="button">Export Addresses</a>
   <a href="export_phone_numbers.php" class="button">Export Phone Numbers</a>
 </body>
</html>
