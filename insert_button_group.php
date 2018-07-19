<?php
if(!empty($_POST["button_group_order"])) {
  $button_group_order = $_POST["button_group_order"];
} else {
  $button_group_order = 0;
}
$next_button_group_id = $_POST["next_button_group_id"];
$button_group_name = $_POST["button_group_name"];
$action_url = $_POST["action_url"];
require_once 'mysqlConnect.php';
$sql = "
      INSERT INTO button_groups
      (
        button_group_name,
        next_button_group_id,
        button_group_order,
        action_url
        )

      VALUES (" .
        "'" . $button_group_name . "'" . "," .
        "'" . $next_button_group_id . "'" . "," .
        "'" . $button_group_order . "'" . "," .
        "'" . $action_url . "'" . 
      ")";
echo $sql . '<br>';
noResponseSQL($sql);
$newURL = 'settings.php';
// header('Location: '.$newURL);
?>
