
<?php
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        include 'mysqlConnect.php';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $dbUser_type_id = '';
        $dbPassword = '';
        $dbUsername = '';
        $dbUser_id = '';
        $res=$con->query("SELECT * FROM users where username = '$username'");
        while ($row = $res->fetch_assoc()) {
          $dbUser_type_id = $row['user_type_id'];
          $dbPassword = $row['password'];
          $dbUsername = $row['username'];
          $dbUser_id = $row['user_id'];
        }
        if(
          $username == $dbUsername
          && $username != ''
          && $password == $dbPassword
          )
        {
            session_start();
            $_SESSION["authenticated"] = 'true';
            $_SESSION["userTypeID"] = $dbUser_type_id;
            $_SESSION["userID"] = $dbUser_id;
            if($dbUser_type_id == 1) {
              header('Location: admin.php');
            }
            else {
              header('Location: standard.php');
            }

        }
        else {
            header('Location: login.php');
        }

    } else {
        header('Location: login.php');
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Login</title>
    <?php include 'style.php'; ?>
</head>
<body onload="document.getElementById('username').focus();">
<div id="page">
    <!-- [banner] -->
    <header id="banner">
        <hgroup>
            <h1>Login</h1>
        </hgroup>
    </header>
    <!-- [content] -->
    <section id="content">
        <form id="login" method="post" action="login.php">
          <table>
            <tr>
              <td><label for="username">Username:</label></td>
              <td><input id="username" name="username" type="text" required></td>
            </tr>
            <tr>
              <td><label for="password">Password:</label></td>
              <td><input id="password" name="password" type="password" required></td>
            </tr>
            <tr>
              <td><input type="submit" value="Login"></td>
            </tr>
          </table>
        </form>
    </section>
    <!-- [/content] -->
</div>
<!-- [/page] -->
</body>
</html>
<?php } ?>
