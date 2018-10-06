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
          <h2>Exported Addresses</h2><table><thead><tr><th>Export Date</th><th>Publisher</th><th>Returned</th><th>Action</th></tr></thead>
        ';
        $resExport=$con->query("select DISTINCT(address_export_id), export_date, CONCAT(publishers.first_name, ' ', publishers.last_name) AS name, returned_date
                          from address_exports
                          INNER JOIN residents USING(address_export_id)
                          LEFT JOIN publishers USING(publisher_id)
                          where residents.territory_id = " . $_GET['territory_id'] .
                          " ORDER BY " . $_GET['export_sortby'] . " " . $_GET['export_sortdir']
                        ) or die($con->error);
        while ($rowExport = $resExport->fetch_assoc()) {
          echo '<tr><td>' . $rowExport['export_date'] . '</td><td>' . $rowExport['name'] . '</td><td>' . $rowExport['returned_date'] . '</td><td><a href="returnExport.php">Return</a></tr>';
        }
        echo '</table>';
      }
      ?>
      </p>
  </body>
</html>
