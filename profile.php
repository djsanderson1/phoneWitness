<!doctype html>
<?php require_once('authenticate.php');
  require_once('functions/forms.php');
  require_once('mysqlConnect.php');
  $user_id = $_SESSION["userID"];
  $trailer = 3;
  $apartment = 4;
  $gated = 5;
  $sql = "SELECT *,
    trailer.setting_value AS trailer_value
    apartment.setting_value AS apartment_value
    gated.setting_value AS gated_value
    FROM users
    LEFT JOIN publishers USING(publisher_id)
    LEFT JOIN (
      select * from settings
       where user_id = $user_id
         and setting_type_id = '$trailer' LIMIT 1) AS trailer ON trailer.user_id = users.user_id
    LEFT JOIN (
      select * from settings
       where user_id = $user_id
         and setting_type_id = '$apartment' LIMIT 1) AS apartment ON apartment.user_id = users.user_id
    LEFT JOIN (
      select * from settings
       where user_id = $user_id
         and setting_type_id = '$gated' LIMIT 1) AS gated ON gated.user_id = users.user_id
    WHERE user_id = $user_id";
  $res=$con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    global  $username,
            $password,
            $first_name,
            $last_name,
            $phone1,
            $email,
            $street_address,
            $city,
            $state,
            $zip,
            $trailer_value,
            $apartment_value,
            $gated_value;
    $username         = $row['username'];
    $password         = $row['password'];
    $first_name       = $row['first_name'];
    $last_name        = $row['last_name'];
    $phone1           = $row['phone1'];
    $email            = $row['email'];
    $street_address   = $row['street_address'];
    $city             = $row['city'];
    $state            = $row['state'];
    $zip              = $row['zip'];
    $trailer_value    = $row['trailer_value'];
    $apartment_value  = $row['apartment_value'];
    $gated_value      = $row['gated_value'];
  }
  $thisPage = $_SERVER['SCRIPT_NAME'];
  $formStart = '<form action="'.$thisPage.'" method="post">
    <table align="center"><thead><tr><th colspan="2">User Profile</th></tr></thead>';
  $formEnd = '</table></form>';
  $usernameField = textField('username', $username, 'Username');
  $emailField = textField('email', $email, 'Email');
  $passwordField = passwordField('password', $password, 'Password');
  $first_nameField = textField('first_name', $first_name, 'First Name');
  $last_nameField = textField('last_name', $last_name, 'Last Name');
  $phoneField = textField('phone1', $phone1, 'Phone');
  $addressField = textField('street_address', $street_address, 'Street Address');
  $cityField = textField('city', $city, 'City');
  $stateField = textField('state', $state, 'State');
  $zipField = textField('zip', $zip, 'Zip');
  $submitButton = '<tr><td colspan="2"><button type="submit">Update Profile</button></td></tr>';
  $exportSettings = '
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <th colspan="2">When exporting I want...</th>
    </tr>
    <tr>
      <td colspan="2">
        <input type="checkbox" name="trailer" id="trailer"' . getCheckboxSetting($value) . '>
        <label for="trailer">Trailer Parks</label>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="checkbox" name="apartments" id="apartments">
        <label for="apartments">Apartments</label>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="checkbox" name="gated" id="gated">
        <label for="gated">Gated Communities</label>
      </td>
    </tr>';
  $form = $formStart.$usernameField.$passwordField.$emailField.$first_nameField.
    $last_nameField.$phoneField.$addressField.$cityField.$stateField.$zipField.$exportSettings.$submitButton.$formEnd;
?>
<html><head>
<?php include("style.php"); ?>
</head>
<body>
  <?php
  require_once('navbar.php');
  if(isset($_POST['username'])) {
    $frmUsername = $_POST['username'];
    if(checkUsername($frmUsername, $_SESSION["userID"]) != 'ok') {
      echo checkUsername($frmUsername, $_SESSION["userID"]);
      exit;
    }
    echo updateFromForm($_POST, 'users', 'user_id', $_SESSION["userID"], 'publishers', 'publisher_id');
    setUserSetting($setting_type_id = 0, $value = "");
  } else {
    echo $form;
  }
   ?>
</body>
</html>
