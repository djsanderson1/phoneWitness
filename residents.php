<?php require_once('authenticate.php');
if(isset($_GET["territory_id"])) {
  $territory_id = $_GET["territory_id"];
  include 'mysqlConnect.php';
  $territory_number = '0';
  $res=$con->query("SELECT territory_number FROM territories WHERE territory_id = $territory_id");
  while ($row = $res->fetch_assoc()) {
    $territory_number = $row['territory_number'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Residents of Territory #<?php echo $territory_number ?></title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php';

    // using session variable to know if the publisher was updated
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION["residentChange"])) {
      echo $_SESSION["residentChange"];
      unset($_SESSION["residentChange"]);
    }
    ?>
    <h1>Residents of Territory #<?php echo $territory_number ?></h1>
    <p><a href="addResident.php">Add New Resident</a></p>
    <table>
      <thead>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Last Called</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        include 'mysqlConnect.php';
        $res=$con->query("SELECT * FROM residents INNER JOIN status_list USING(status_id) ORDER BY last_called_date desc") or die($con->error);
        while ($row = $res->fetch_assoc()):
          $resident_id = $row['resident_id'];
          $name = $row['name'];
          $phone = $row['phone_number'];
          $address = $row['address'];
          $last_called = strtotime($row['last_called_date']);
          $status = $row['status_name'];
          ?>
        <tr>
          <td><?php echo $name ?></td>
          <td><?php echo $row['phone_number']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo date('n/j/Y', $last_called); ?></td>
          <td>
            <?php

              echo $status;

            ?>
          </td>
          <td>
            <a href="viewResident.php?resident_id=<?php echo $resident_id; ?>&territory_id=<?php echo $territory_id; ?>">View</a> |
            <a href="editResident.php?resident_id=<?php echo $resident_id; ?>&territory_id=<?php echo $territory_id; ?>">Edit</a> |
            <a href="deleteResident.php?resident_id=<?php echo $resident_id; ?>&territory_id=<?php echo $territory_id; ?>" onclick="return confirm('Are you sure you want to delete this resident?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </body>
</html>
