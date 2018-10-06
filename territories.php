<!doctype html>
<html>
  <head>
    <title>Territories</title>
    <script src="dropDown.js"></script>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Territories</h1>
    <p>Here's the list of territories we have:</p>
    <table>
        <thead>
        <tr>
          <th>Territory Number</th>
          <th>Last Import Date</th>
          <th>Last Worked Date</th>
          <th>Territory Image</th>
          <th>Available to Export</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    include 'mysqlConnect.php';
    $res=$con->query("SELECT * FROM territories");
    while ($row = $res->fetch_assoc()) {

      if(isset($_GET['refreshed'])) {
        $db_territory_id = $row['territory_id'];
        $url_territory_id = $_GET['refreshed'];
        if($db_territory_id == $url_territory_id) {
            $thisTerritoryRefreshed = True;
            $refreshedRowStyle = "background-color: #ccc;";
            $refreshedMessage = " - Territory Refreshed! Stay Fresh!";
          } else {
            $thisTerritoryRefreshed = False;
            $refreshedRowStyle = "";
            $refreshedMessage = "";
          }
        } else {
          $thisTerritoryRefreshed = False;
          $refreshedRowStyle = "";
          $refreshedMessage = "";
        }
        $qryFilterMostly = "((address_export_id IS NULL OR address_export_id = 0) AND (status_id2 <> 3 OR status_id2 IS NULL))
                    AND (
                      number_of_tries >= 3
                      OR phone_number IS NULL
                      OR phone_number = '')
                    AND territory_id = " . $row['territory_id'];
        $res2=$con->query("SELECT COUNT(*) AS available_to_export FROM residents WHERE " . $qryFilterMostly);
        while ($row2 = $res2->fetch_assoc()) {
          global $available_to_export;
          $available_to_export = $row2['available_to_export'];
        }
      echo '
      <tr style="$refreshedRowStyle">
        <td><a href="territoryDetails.php?territory_id=' . $row["territory_id"] . '&export_sortby=returned_date&export_sortdir=desc">' . $row["territory_number"] . $refreshedMessage . '</a></td>
        <td>' . $row["last_import_date"] . '</td>
        <td>' . $row["last_worked_date"] . '</td>
        <td><a href="' . $row["territoryImageUrl"] . '"><img src="' . $row["territoryImageUrl"] . '" height="50"></a></td>
        <td>' . $available_to_export . '</td>
        <td><a onclick="result = confirm(' . "'Are you sure that you want to delete territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'deleteTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}">Del</a> |
            <a href="export_addresses.php?territory_id=' . $row["territory_id"] . '">Export</a> |
            <a onclick="result = confirm(' . "'Are you sure that you want to refresh territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'refreshTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}" title="This refreshes the territory, marking all residents as not worked.">Refresh</a>
        </td>
      </tr>
      ';
    }
    ?>
    </tbody>
  </table>
  </body>
</html>
