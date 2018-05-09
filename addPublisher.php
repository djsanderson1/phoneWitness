<?php
if (isset($_POST['first_name'])) {
  include 'mysqlConnect.php';
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $congregation = $_POST['congregation'];
  $phone1 = $_POST['phone1'];
  $phone2 = $_POST['phone2'];
  $street_address = $_POST['street_address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $qryString = "
    INSERT INTO publishers
    (
      first_name,
      last_name,
      congregation,
      phone1,
      phone2,
      street_address,
      city,
      state,
      zip
      )

    VALUES (
      '" . $first_name . "',
      '" . $last_name . "',
      '" . $congregation . "',
      '" . $phone1 . "',
      '" . $phone2 . "',
      '" . $street_address . "',
      '" . $city . "',
      '" . $state . "',
      '" . $zip . "'
      )
    ";
  $con->query($qryString);
  include 'style.php';
  include 'navbar.php';
  exit("Publisher Added Successfully");
  // header('Location: admin.php');
}
?>
<!doctype html>
<html>
  <head>
    <title>Add Publisher</title>
    <?php include 'style.php'; ?>
  </head>
  <body onload="addPublisher.first_name.focus();">
    <?php include 'navbar.php'; ?>
    <br>
    <form action="addPublisher.php" name="addPublisher" method="post">
      <table>
        <tr>
          <td><label for="first_name">First Name</label></td>
          <td><input type="text" name="first_name"></td>
        </tr>
        <tr>
          <td><label for="last_name">Last Name</label></td>
          <td><input type="text" name="last_name"></td>
        </tr>
        <tr>
          <td><label for="congregation">Congregation</label></td>
          <td><input type="text" name="congregation" value="Volcano View"></td>
        </tr>
        <tr>
          <td><label for="phone1">Phone 1</label></td>
          <td><input type="text" name="phone1"></td>
        </tr>
        <tr>
          <td><label for="phone2">Phone 2</label></td>
          <td><input type="text" name="phone2"></td>
        </tr>
        <tr>
          <td><label for="street_address">Street Address</label></td>
          <td><input type="text" name="street_address"></td>
        </tr>
        <tr>
          <td><label for="city">City</label></td>
          <td><input type="text" name="city"></td>
        </tr>
        <tr>
          <td><label for="state">State</label></td>
          <td><input type="text" maxlength="2" name="state"></td>
        </tr>
        <tr>
          <td><label for="zip">Zip</label></td>
          <td><input type="text" name="zip"></td>
        </tr>
        <tr>
          <td colspan="2"><button type="submit">Add Publisher</button></td>
        </tr>
      </table>
    </form>
  </body>
</html>
