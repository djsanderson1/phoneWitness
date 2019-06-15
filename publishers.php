<?php require_once('authenticate.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Publishers</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php';

    // using session variable to know if the publisher was updated
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION["publisherChange"])) {
      echo $_SESSION["publisherChange"];
      unset($_SESSION["publisherChange"]);
    }
    ?>
    <h1>Publishers</h1>
    <p><a href="addPublisher.php">Add New Publisher</a></p>
    <table>
      <thead>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        include 'mysqlConnect.php';
        $res=$con->query("SELECT * FROM publishers order by last_name ASC, first_name ASC");
        while ($row = $res->fetch_assoc()):
          $publisher_id = $row['publisher_id'];
          ?>
        <tr>
          <td><?php echo $row['last_name']?></td>
          <td><?php echo $row['first_name']?></td>
          <td><?php echo $row['phone1']?></td>
          <td><?php echo $row['email']?></td>
          <td>
            <a href="editPublisher.php?publisher_id=<?php echo $publisher_id ?>">View</a> |
            <a href="editPublisher.php?publisher_id=<?php echo $publisher_id ?>">Edit</a> |
            <a href="deletePublisher.php?publisher_id=<?php echo $publisher_id ?>" onclick="return confirm('Are you sure you want to delete this publisher?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </body>
</html>
