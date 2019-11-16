<!doctype html>
<?php require_once('authenticate.php');
  require_once('functions/forms.php');
  require_once('mysqlConnect.php');
  $user_id = $_SESSION["userID"];
  $sql = "select * from users left join publishers using(publisher_id) where user_id = $user_id";
  $res=$con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    global $username, $password, $first_name, $last_name, $phone1, $email, $street_address, $city, $state, $zip;
    $username = $row['username'];
    $password = $row['password'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $phone1 = $row['phone1'];
    $email = $row['email'];
    $street_address = $row['street_address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
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
  $submitButton = '<tr><td><button type="submit">Update Profile</button></td></tr>';
  $form = $formStart.$usernameField.$passwordField.$emailField.$first_nameField.
    $last_nameField.$phoneField.$addressField.$cityField.$stateField.$zipField.$submitButton.$formEnd;
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
  } else {
    echo $form;
  }
   ?>
</body>
</html>
