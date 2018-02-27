<!doctype html>
<html>
  <head>
    <title>Territories</title>
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
      echo '
      <tr>
        <td><a href="territoryDetails.php?territory_id=' . $row["territory_id"] . '">' . $row["territory_number"] . '</a></td>
        <td>' . $row["last_import_date"] . '</td>
        <td>' . $row["last_worked_date"] . '</td>
        <td><a href="' . $row["territoryImageUrl"] . '"><img src="' . $row["territoryImageUrl"] . '" height="50"></a></td>
        <td><a onclick="result = confirm(' . "'Are you sure that you want to delete territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'deleteTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}">Del</a> |
            <a href="refreshTerritory.php?territory_id=' . $row["territory_id"] . '" title="This refreshes the territory, marking all residents as not worked.">Refresh</a>
        </td>
      </tr>
      ';
    }
    ?>
    </tbody>
  </table>
  </body>
</html>
