<?php require_once('authenticate.php');

echo '<ul class="navbar">';
if(in_array("admin",$permissions)) {
  echo '<li class="navbar"><a href="admin.php" class="navbar">Home</a></li>';
}


echo '<li class="navbar"><a href="standard.php" class="navbar">Phone Witnessing</a></li>';

echo '<li class="navbar"><a href="addTerritory.php" class="navbar">Add Territory</a></li>';

echo '<li class="navbar"><a href="territories.php" class="navbar">Territories</a></li>';

echo '<li class="navbar"><a href="publishers.php" class="navbar">Publishers</a></li>';

echo '<li class="navbar"><a href="users.php" class="navbar">Users</a></li>';

echo '<li class="navbar"><a href="logout.php" class="navbar">Logout</a></li>';

echo '</ul>';
?>
