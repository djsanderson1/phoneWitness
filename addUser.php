<?php
require_once('authenticate.php');
if (isset($_POST['username'])) {
  include 'mysqlConnect.php';
  $username = $_POST['username'];
  $password = $_POST['password'];
  $type = $_POST['user_type_id'];
  $publisher_id = $_POST['publisher_id'];
  $qryString = "
    INSERT INTO users
    (
      username,
      password,
      user_type_id,
      publisher_id
      )

    VALUES (
      '" . $username . "',
      '" . $password . "',
      '" . $type . "',
      '" . $publisher_id . "'
      )
    ";
  $con->query($qryString);
  include 'style.php';
  include 'navbar.php';
  header('Location: users.php');
}
?>
<!doctype html>
<html>
  <head>
    <title>Add User</title>
    <?php include 'style.php'; ?>
  </head>
  <body onload="addUser.username.focus();">
    <?php include 'navbar.php'; ?>
    <br>
    <form action="addUser.php" name="addUser" method="post">

      <table>
        <tr class="nohover">
          <td><label for="username">Username</label></td>
          <td><input type="text" name="username"></td>
        </tr>
        <tr class="nohover">
          <td><label for="password">Password</label></td>
          <td><input type="password" name="password" autocomplete="new-password"></td>
        </tr>
        <tr class="nohover">
          <td><label for="user_type_id">User Type</label></td>
          <td>
            <select name="user_type_id">
                <?php $res2=$con->query("SELECT * FROM user_types");
                while ($row2 = $res2->fetch_assoc()) :
                  $statusDisplayName = $row2['user_type_name'];
                  $thisStatusID = $row2['user_type_id'];
                ?>
                <option value="<?php echo $thisStatusID; ?>" <?php if($thisStatusID==3) {echo "selected";} ?>><?php echo $statusDisplayName; ?></option>
              <?php endwhile; ?>
              </select>
          </td>
        </tr>
        <tr class="nohover">
          <td><label for="publisher_id">Publisher</label></td>
          <td>
            <?php
            require_once 'functions/publishers/getPublishers.php';
            activePublishersDropDown(); ?>
          </td>
        </tr>
        <tr class="nohover">
          <td colspan="2"><button type="submit">Add User</button><button type="button" onclick="window.history.back();">Cancel</button></td>
        </tr>
      </table>
    </form>
  </body>
</html>
