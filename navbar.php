<?php require_once('authenticate.php');
if($_SESSION["userTypeID"] == 1) {
echo '
<ul class="navbar">
  <li class="navbar"><a href="/admin.php" class="navbar">Home</a></li>
  <li class="navbar"><a href="/searchResidents.php" class="navbar">Search</a></li>
  <li class="navbar"><a href="/addTerritory.php" class="navbar">Add Territory</a></li>
  <li class="navbar"><a href="/territories.php" class="navbar">Territories</a></li>
  <li class="navbar"><a href="/residents.php" class="navbar">Call History</a></li>
  <li class="navbar"><a href="/publishers.php" class="navbar">Publishers</a></li>
  <li class="navbar"><a href="/users.php" class="navbar">Users</a></li>
  <li class="navbar"><a href="/logout.php" class="navbar">Logout</a></li>
</ul>';
} else {
  echo '
  <ul class="navbar">
    <li class="navbar"><a href="/export.php" class="navbar">Export</a></li>
    <li class="navbar"><a href="/exportHistory.php" class="navbar">Export History</a></li>
    <li class="navbar"><a href="/profile.php" class="navbar">Profile</a></li>
    <li class="navbar"><a href="/logout.php" class="navbar">Logout</a></li>
  </ul>';
}
?>
