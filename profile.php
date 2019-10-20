<!doctype html>
<?php require_once('authenticate.php');
  function textField($fieldName, $currentValue = "", $label="") {
    $fieldLabel = fieldLabel($fieldName, $label);
    return '<tr>'.$fieldLabel.'<td><input type="text" name="'.$fieldName.'" id="'.$fieldName.'" value="'.$currentValue.'"></td></tr>';
  }
  function passwordField($fieldName = "", $currentValue = "", $label="") {
    $fieldLabel = fieldLabel($fieldName, $label);
    return '<tr>'.$fieldLabel.'<td><input type="password" name="'.$fieldName.'" value="'.$currentValue.'"></td></tr>';
  }
  function fieldLabel($fieldName, $label = "") {
    if($label == "") {
      $label = $fieldName;
    }
    return '<td><label for="'.$fieldName.'">'.$label.': </label></td>';
  }
  function checkUsername($username, $user_id) {
    include('mysqlConnect.php');
    $sql = "select count(*) as same_names from users where user_id <> $user_id and username = '".$username."'";
    $res=$con->query($sql) or die($con->error);
    while ($row = $res->fetch_assoc()) {
      $same_names = $row['same_names'];
      if($same_names > 0) {
        return 'Username is duplicate. Try something else.';
      }
    }
  }
  require_once('mysqlConnect.php');
  $user_id = $_SESSION["userID"];
  $sql = "select * from users left join publishers using(publisher_id) where user_id = $user_id";
  $res=$con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    global $username, $password, $first_name, $last_name, $phone1;
    $username = $row['username'];
    $password = $row['password'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $phone1 = $row['phone1'];
  }
  $thisPage = $_SERVER['SCRIPT_NAME'];
  $formStart = '<form action="'.$thisPage.'" method="post">
    <input type="hidden" name="user_id" value="'.$user_id.'">
    <table align="center"><thead><tr><th colspan="2">User Profile</th></tr></thead>';
  $formEnd = '</table></form>';
  $usernameField = textField('username', $username, 'Username');
  $passwordField = passwordField('password', $password, 'Password');
  $first_nameField = textField('first_name', $first_name, 'First Name');
  $last_nameField = textField('last_name', $last_name, 'Last Name');
  $phoneField = textField('phone1', $phone1, 'Phone');
  $submitButton = '<tr><td><button type="submit">Update Profile</button></td></tr>';
  $form = $formStart.$usernameField.$passwordField.$first_nameField.$last_nameField.$phoneField.$submitButton.$formEnd;
?>
<html><head>
<?php include("style.php"); ?>
</head>
<body>
  <?php
  if(isset($_POST['username'])) {
    $frmUsername = $_POST['username'];
    $frmUserID = $_POST['user_id'];
    $checkUserName = checkUsername($frmUsername, $frmUserID);
    echo $checkUserName;
  }
  echo $form; ?>
</body>
</html>
