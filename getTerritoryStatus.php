<?php
/* This page will need to be run for updates

*/
require_once('authenticate.php');
require_once('functions/api/territoryHelper.php');
$client_id = "4edf19f4e7aa4391aeb0b15399b7c895";
$client_secret = "61f6462b01e5453e982ac616e4fd5050";
$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = territoryHelperAuthLink($client_id, $redirect_uri);
$code = getGet("code");
echo '<a href="'.$url.'">Authenticate</a><br>code: '.$code;
 ?>
