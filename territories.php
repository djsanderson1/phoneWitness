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
      echo '
      <tr style="$refreshedRowStyle">
        <td><a href="territoryDetails.php?territory_id=' . $row["territory_id"] . '">' . $row["territory_number"] . $refreshedMessage . '</a></td>
        <td>' . $row["last_import_date"] . '</td>
        <td>' . $row["last_worked_date"] . '</td>
        <td><a href="' . $row["territoryImageUrl"] . '"><img src="' . $row["territoryImageUrl"] . '" height="50"></a></td>
        <td>
        <select name="actionList" onChange="territoryActionList(this.id,' . $row["territory_number"] . ')" id="territory_id' . $row["territory_id"] . '">
          <option>-- Please Select an Action --</option>
          <option value="delete">Delete Territory</option>
          <option value="export">Export Addresses</option>
          <option value="refresh">Refresh Territory</option>
          <option value="viewExport">View Exported Addresses</option>
        </select><br>
        <a onclick="result = confirm(' . "'Are you sure that you want to delete territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'deleteTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}">Del</a> |
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
