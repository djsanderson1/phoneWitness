<?php
$_SESSION["authenticated"] = 'false';
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}
?>
