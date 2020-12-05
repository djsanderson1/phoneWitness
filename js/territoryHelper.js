// th is short for Territory Helper
function thAuthLink(client_id=0, redirect_uri="") {
  var url = "https://territoryhelper.com/api/auth?response_type=code&client_id=";
  url += client_id;
  url += "&redirect_uri=";
  url += redirect_uri;
  return url;
}
function thTokenRequest(code, redirect_uri, client_id, client_secret, tokenReturn) {
  // code requires a hidden element with an id of tokenReturn to return the JSON into
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(tokenReturn).innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "https://territoryhelper.com/api/token");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var fields = "grant_type=authorization_code&code=";
  fields += code;
  fields += "&redirect_uri=";
  fields += redirect_uri;
  fields += "&client_id=";
  fields += client_id;
  fields += "&client_secret=";
  fields += client_secret;
  xhttp.send(fields);
}
function thGetMyTerritories(tokenReturn) {
  /* this pulls the data from the html element with the id of tokenReturn
    It also has to convert tokenReturn's innerHTML from JSON to individual variables
    and send this data to populateMyTerritories.php
  */
}
