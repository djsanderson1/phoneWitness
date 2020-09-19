<?php
function territoryHelperAuthLink($client_id, $redirect_uri) {
  return "https://territoryhelper.com/api/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri";
}
?>
