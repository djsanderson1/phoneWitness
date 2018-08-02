<?php
if(!empty($_POST["button_order"])) {
  $button_order = $_POST["button_order"];
} else {
  $button_order = 0;
}
$button_display = $_POST["button_display"];
$button_id = $_POST["button_id"];
$html_instead = $_POST["html_instead"];
$confirm_message = $_POST["confirm_message"];
require_once 'mysqlConnect.php';
$sql = "
      UPDATE buttons SET
        button_display = '" . htmlspecialchars($button_display, ENT_QUOTES) . "',
        confirm_message = '" . htmlspecialchars($confirm_message, ENT_QUOTES) . "',
        button_order = '" . $button_order . "',
        html_instead = '" . htmlspecialchars($html_instead, ENT_QUOTES) . "'
      WHERE
      button_id = '" . $button_id . "'
      ";
/* Commented out this section if I'm not testing. When testing this will display
    the sql code on the screen so it's easy to view.
echo $sql . '<br>';
*/
noResponseSQL($sql);
$newURL = 'settings.php';
// When testing, comment out the line below so it doesn't redirect
 header('Location: '.$newURL);
?>
