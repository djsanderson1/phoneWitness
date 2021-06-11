<?php
  require_once('authenticate.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php
    if($territory_number > 0) {
      echo "Residents of Territory #$territory_number";
    } else {
      echo "Call History";
    }
     ?></title>
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
    <h1><?php
    if($territory_number > 0) {
      echo "Residents of Territory #$territory_number";
    } else {
      echo "Call History";
    }
     ?></h1>
    <p><a href="addResident.php?territory_id=<?php echo $territory_id; ?>">Add New Resident</a></p>
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
        if($territory_id > 0) {
          $residentsQuery =
            "SELECT *, CONCAT(IF(status2.status_name IS NULL, '', status2.status_name), ' ', IF(status_list.status_name IS NULL, '', status_list.status_name))  AS new_status
               FROM residents
               LEFT JOIN status_list USING(status_id)
               LEFT JOIN status_list AS status2 ON residents.status_id2 = status2.status_id
              WHERE territory_id = $territory_id";
        } else {
          $residentsQuery =
            "SELECT *, CONCAT(status_name, ' ', IF(do_not_call = 'y', 'DNC', '')) AS new_status
            FROM residents
            INNER JOIN status_list USING(status_id)
            ORDER BY last_called_date desc,
            last_called_time desc";
        }
        $res=$con->query($residentsQuery) or die($con->error);
        while ($row = $res->fetch_assoc()):
          $resident_id = $row['resident_id'];
          $name = $row['name'];
          $phone = $row['phone_number'];
          $address = $row['address'];
          $last_called = strtotime($row['last_called_date']);
          $status = $row['new_status'];
          ?>
        <tr>
          <td><?php echo $name ?></td>
          <td><?php echo $row['phone_number']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo date('n/j/Y', $last_called) . " " . $row['last_called_time']; ?></td>
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
