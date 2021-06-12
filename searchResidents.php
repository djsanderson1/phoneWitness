<?php
  require_once('authenticate.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Search for Residents</title>
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
    <h1>Search for Residents</h1>
    <form action="
      <?php
        echo $_SERVER['SCRIPT_NAME'];
      ?>
    " method="post">
      <input type="text" name="searchText">
      <button type="submit">Search</button>
    </form>
    <table>
      <thead>
        <th>Territory</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Last Called</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        $searchText = '';
        if(isset($_POST['searchText'])) {
          $searchText = $_POST['searchText'];
        }
        if($searchText != '') {
          include 'mysqlConnect.php';
          $residentsQuery =
            "SELECT *, CONCAT(IF(status2.status_name IS NULL, '', status2.status_name), ' ', IF(status_list.status_name IS NULL, '', status_list.status_name))  AS new_status
               FROM residents
               LEFT JOIN status_list USING(status_id)
               LEFT JOIN status_list AS status2 ON residents.status_id2 = status2.status_id
               LEFT JOIN territories USING(territory_id)
              WHERE CONCAT(name, address, phone_number) LIKE '%" . $searchText . "%'";
          echo "test";
          $res=$con->query($residentsQuery) or die($con->error);
          while ($row = $res->fetch_assoc()):
          $resident_id = $row['resident_id'];
          $name = $row['name'];
          $phone = $row['phone_number'];
          $address = $row['address'];
          $last_called = strtotime($row['last_called_date']);
          $status = $row['new_status'];
          $territory_number = $row['territory_number'];
          $territory_id = $row['territory_id'];
          ?>
        <tr>
          <td><?php echo $territory_number; ?></td>
          <td><?php echo $name; ?></td>
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
            <a href="editResident.php?resident_id=<?php echo $resident_id; ?>&territory_id=<?php echo $territory_id; ?>">Edit</a>
          </td>
        </tr>
      <?php endwhile;
    }
      ?>
      </tbody>
    </table>
  </body>
</html>
