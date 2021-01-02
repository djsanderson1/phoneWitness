<?php
function getThClientID() {
  return "e2a4ca79d56a4de8a078746d8c61319b";
}
function getThClientSecret() {
  return "8930b0e816a648ebaa09ea4e60baddc8";
}
function getThRedirectUri() {
  return 'http://'.$_SERVER['HTTP_HOST'].'/getTerritoryStatus.php';
}
function territoryHelperAuthLink($client_id, $redirect_uri) {
  return "https://territoryhelper.com/api/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri";
}
?>
