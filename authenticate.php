<?php
session_start();
require_once("mysqlConnect.php");
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}
else {
  // user is authenticated, now create a session variable to hold their permissions

  $res=$con->query("SELECT * FROM user_permissions LEFT JOIN permissions USING(permission_id)");
$permissions = array();
  while ($row = $res->fetch_assoc()) {
    $permissions[] = $row['permission_name'];
  }
}
?>
