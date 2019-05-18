<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
  <head>
    <title>Users</title>
    <script src="dropDown.js"></script>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Users</h1>
    <a href="addUser.php">Add User</a>
    <table>
        <thead>
        <tr>
          <th>Username</th>
          <th>Password</th>
          <th>User Type</th>
        </tr>
        </thead>
        <tbody>
    <?php
    include 'mysqlConnect.php';
    $res=$con->query("
      SELECT  *
        FROM  users
        LEFT JOIN user_types USING(user_type_id)
    ");
    while ($row = $res->fetch_assoc()) {

      echo '
      <tr><td>' . $row["username"] . '</td>
        <td>' . $row["password"] . '</td>
        <td>' . $row["user_type_name"] . '</td>
      </tr>
      ';
    }
    ?>
    </tbody>
  </table>
  </body>
</html>
