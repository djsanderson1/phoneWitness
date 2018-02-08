<?php require_once('authenticate.php');
if($_SESSION["userTypeID"] == 1) {
echo '
<ul class="navbar">
  <li class="navbar"><a href="admin.php" class="navbar">Home</a></li>
  <li class="navbar"><a href="addTerritory.php" class="navbar">Add Territory</a></li>
  <li class="navbar"><a href="territories.php" class="navbar">Territories</a></li>
  <li class="navbar"><a href="users.php" class="navbar">Users</a></li>
  <li class="navbar"><a href="logout.php" class="navbar">Logout</a></li>
</ul>';
} else {
  echo '
  <ul class="navbar">
    <li class="navbar"><a href="standard.php" class="navbar">Home</a></li>
    <li class="navbar"><a href="territories.php" class="navbar">Territories</a></li>
    <li class="navbar"><a href="logout.php" class="navbar">Logout</a></li>
  </ul>';
}
?>
