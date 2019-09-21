<?php require_once('authenticate.php'); ?>
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

        if($_GET['export_sortdir']==="asc") {
          $thisExportSortdir = 'desc';
        }
        else {
          $thisExportSortdir = 'asc';
        }
        echo $row['territory_number'] . '<br>';
        $territory_id = $_GET['territory_id'];
        echo '<a href="residents.php?territory_id='.$territory_id.'">View Residents</a>';
        if($row['territoryImageUrl'] == "") {
          echo '<h3>No image</h3>';
        }
        else {

          echo '<a href="' . $row['territoryImageUrl'] . '" target="_blank"><img src="' . $row['territoryImageUrl'] . '" class="territoryImage"></a>';

        }
        echo '
          <br>Last Import Date: '.$row['last_import_date'].'<br>
          Last Worked Date: '.$row['last_worked_date'].'<br>
          <button onclick="result = confirm(' . "'Are you sure that you want to delete territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'deleteTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}">Delete</button>
              <button href="export_addresses.php?territory_id=' . $row["territory_id"] . '">Export</button>
              <button onclick="result = confirm(' . "'Are you sure that you want to refresh territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'refreshTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}" title="This refreshes the territory, marking all residents as not worked.">Refresh</button>
          <h2>Exported Addresses</h2><table><thead>
          <tr><th><a href="?territory_id='.$_GET['territory_id'].'&export_sortby=export_date&export_sortdir='.$thisExportSortdir.'">Export Date</a></th>
          <th><a href="?territory_id='.$_GET['territory_id'].'&export_sortby=name&export_sortdir='.$thisExportSortdir.'">Publisher</a></th>
          <th><a href="?territory_id='.$_GET['territory_id'].'&export_sortby=returned_date&export_sortdir='.$thisExportSortdir.'">Returned</a></th>
          <th>Action</th>
          </tr></thead>
        ';
        $resExport=$con->query("select DISTINCT(address_export_id), export_date, CONCAT(publishers.first_name, ' ', publishers.last_name) AS name, returned_date
                          from address_exports
                          INNER JOIN residents USING(address_export_id)
                          LEFT JOIN publishers USING(publisher_id)
                          where residents.territory_id = " . $_GET['territory_id'] .
                          " ORDER BY " . $_GET['export_sortby'] . " " . $_GET['export_sortdir']
                        ) or die($con->error);
        while ($rowExport = $resExport->fetch_assoc()) {
          echo '<tr><td>' . $rowExport['export_date'] . '</td><td>' . $rowExport['name'] . '</td><td>' . $rowExport['returned_date'] . '</td><td><a href="returnExport.php?address_export_id=' . $rowExport['address_export_id'] . '&territory_id='.$_GET['territory_id'].'&export_sortby='.$_GET['export_sortby'].'&export_sortdir='.$_GET['export_sortdir'].'">Return</a></tr>';
        }
        echo '</table>';
      }
      ?>
      </p>
  </body>
</html>
