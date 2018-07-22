<?php
if(!empty($_POST["button_order"])) {
  $button_order = $_POST["button_order"];
} else {
  $button_order = 0;
}
$button_name = $_POST["button_name"];
$html_instead = $_POST["html_instead"];
$confirm_message = $_POST["confirm_message"];
$button_group_id = $_POST["button_group_id"];
require_once 'mysqlConnect.php';
$sql = "
      INSERT INTO buttons
      (
        button_display,
        confirm_message,
        button_order,
        html_instead,
        button_group_id
        )

      VALUES (" .
        "'" . $button_name . "'" . "," .
        "'" . $confirm_message . "'" . "," .
        "'" . $button_order . "'" . "," .
        "'" . $html_instead . "'" . "," .
        "'" . $button_group_id . "'" .
      ")";
/* Commented out this section if I'm not testing. When testing this will display
    the sql code on the screen so it's easy to view. */
echo $sql . '<br>';

noResponseSQL($sql);
$newURL = 'settings.php';
// When testing, comment out the line below so it doesn't redirect
//header('Location: '.$newURL);
?>
