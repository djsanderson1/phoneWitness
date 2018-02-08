<?php
require_once('authenticate.php');
?>
<!doctype html>
<html>
  <head>
    <title></title>
  </head>
  <body>

  </body>
<?php
$_SESSION["authenticated"] = 'false';
echo $_SESSION["authenticated"];
 ?>
</html>
