<?php
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}
else {
  // user is authenticated, now create a session variable to hold their permissions
  require_once("includes.php");
  $res=$con->query("SELECT * FROM user_permissions LEFT JOIN permissions USING(permission_id)");
  while ($row = $res->fetch_assoc()) {
    $permissions[] = $row['permission_name'];
  }
}
?>
