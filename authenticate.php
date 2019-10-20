<?php
$csExportUserTypeID = 3;
$csStandardUserTypeID = 2;

session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
} else {

// code for export user
switch($_SESSION["userTypeID"]) {
  case $csExportUserTypeID:
    switch (basename($_SERVER['PHP_SELF'])) {
      case 'export_addresses.php':
        break;

      case 'profile.php':
        break;

      default:
        echo 'You do not have access to this page. Please go <a href="javascript:history.back()">back</a>.';
        exit;
        break;
    }
  break;
  case $csStandardUserTypeID:
  switch (basename($_SERVER['PHP_SELF'])) {
    case 'standard.php':
      break;
    case 'betweenCalls.php':
      break;

    default:
      echo 'You do not have access to this page. Please go <a href="javascript:history.back()">back</a>.'.basename($_SERVER['PHP_SELF']);
      exit;
      break;
  }
break;
}

}
?>
