<!doctype html>
<html>
  <head>
    <title>Territory Details</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Territory Details</h1>
    <p>Below are the details for territory number:
      <?php
      include 'mysqlConnect.php';
      $res=$con->query("SELECT * FROM territories LEFT JOIN territory_queue USING(territory_id) where territory_id = " . $_GET['territory_id']);
      while ($row = $res->fetch_assoc()) {

        if($row['territoryImageUrl'] == "") {
          echo '<h3>No image</h3>';
        }
        else {

          echo '<img src="' . $row['territoryImageUrl'] . '">';

        }

        echo 'Territory Number: ' . $row['territory_number'] . '<br>
          Last Import Date: <br>
          Last Worked Date: <br>
        ';
      }
      ?>
      </p>
  </body>
</html>
