<?php
require_once 'mysqlConnect.php';
$sql = "
        DELETE FROM buttons WHERE button_id = " . $_GET['button_id'];
/* Commented out this section if I'm not testing. When testing this will display
    the sql code on the screen so it's easy to view.
echo $sql . '<br>';
*/
noResponseSQL($sql);
$newURL = 'settings.php';
// When testing, comment out the line below so it doesn't redirect
header('Location: '.$newURL);
?>
