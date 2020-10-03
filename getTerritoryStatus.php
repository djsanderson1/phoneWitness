<?php
/* This page will need to be run for updates

*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('authenticate.php');
require_once('functions/api/territoryHelper.php');
/*
$client_id = "4edf19f4e7aa4391aeb0b15399b7c895";
$client_secret = "61f6462b01e5453e982ac616e4fd5050";
*/
$client_id = "e2a4ca79d56a4de8a078746d8c61319b";
$client_secret = "8930b0e816a648ebaa09ea4e60baddc8";
$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/getTerritoryStatus.php';
$url = territoryHelperAuthLink($client_id, $redirect_uri);
$code = getGet("code");
echo '<a href="'.$url.'">Authenticate</a><br>code: '.$code;
echo '<br><a href="'.$redirect_uri.'">Reset</a>';
if($code != "") {

  echo '
  <form action="https://territoryhelper.com/api/token" method="post">
    <input type="text" name="grant_type" value="authorization_code">
    <input type="text" name="code" value="'.$code.'">
    <input type="text" name="redirect_uri" value="'.$redirect_uri.'">
    <input type="text" name="client_id" value="'.$client_id.'">
    <input type="text" name="client_secret" value="'.$client_secret.'">
    <input type="submit">
  </form>';
  /*
  echo 'test';
  //The url you wish to send the POST request to
$url = 'https://territoryhelper.com/api/token';

//The data you want to send via POST
$fields = [
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'redirect_uri'  => $redirect_uri,
    'client_id'     => $client_id,
    'client_secret' => $client_secret
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init($url);

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);
curl_close($ch);
echo 'mytest';
echo $result;
*/
}
 ?>
