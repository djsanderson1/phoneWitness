<?php
// these functions will be available in every page on the site

// Makes sure your $_GET variable isn't empty
function getGet($varname) {
  $returnVar = "";
  if(isset($_GET[$varname])) {
    $returnVar = $_GET[$varname];
  }
  return $returnVar;
}
 ?>
