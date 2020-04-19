<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
  <head>
    <title>Territories</title>
    <script src="/js/dropDown.js"></script>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Territories</h1>
    <h2>Active Territories</h2>
    <table>
        <thead>
        <tr>
          <th><a href="?sortby=territory_number">Territory Number</a></th>
          <th><a href="?sortby=last_import_date">Last Import Date</a></th>
          <th><a href="?sortby=last_worked_date">Last Worked Date</a></th>
          <th><a href="?sortby=territoryImageUrl">Territory Image</a></th>
          <th>Available to Export</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    // default sorting
    $defaultSortBy  = 'territory_number';
    $defaultSortDir = 'ASC';

    if(isset($_GET['sortby'])) {
      $sortby = $_GET['sortby'];
      if(isset($_SESSION['sortdir'])) {
        $existingSortdir = $_SESSION['sortdir'];
      } else {
        $existingSortdir = '';
      }
      if($existingSortdir == '') {
        $_SESSION['sortdir'] = $defaultSortDir;
      }
      if(isset($_SESSION['sortby'])) {
        $existingSortby = $_SESSION['sortby'];
      } else {
        $existingSortby = '';
      }
      $_SESSION['sortby'] = $sortby;
      $sortdir = $_SESSION['sortdir'];
      if($sortby == $existingSortby && $sortdir == $existingSortdir) {
        if($sortdir == 'ASC') {
          $_SESSION['sortdir'] = 'DESC';
        } else {
          $_SESSION['sortdir'] = 'ASC';
        }
      }
      $sortdir = $_SESSION['sortdir'];
    } else {
      $sortby = $defaultSortBy;
      $sortdir = $defaultSortDir;
    }
    if($sortby == 'territory_number') {
      $sortby = 'CAST(territory_number AS UNSIGNED)';
    }
    include 'mysqlConnect.php';
    $res=$con->query("
      SELECT  territories.territory_id,
              territories.territory_number,
              territories.last_import_date,
              territories.last_worked_date,
              territories.territoryImageUrl,
              territories.territory_status,
              territory_queue.order_number
        FROM  territories
    INNER JOIN territory_queue USING(territory_id)
    ORDER BY $sortby $sortdir
    ");
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
            <a onclick="result = confirm(' . "'Are you sure that you want to refresh territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'refreshTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}" title="This refreshes the territory, marking all residents as not worked.">Refresh</a>';
      if($row["order_number"] > 0) {
        $activateLinkPath = "deactivateTerritory.php?territory_id=".$row["territory_id"];
        $activateLinkText = "Deactivate";
      } else {
        $activateLinkPath = "activateTerritory.php?territory_id=".$row["territory_id"];
        $activateLinkText = "Activate";
      }
      echo '| <a href="' . $activateLinkPath . '">' . $activateLinkText . '</a>  </td>
      </tr>
      ';
    }
    ?>
    </tbody>
  </table>
<br>
  <h2>Inactive Territories</h2>
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
  $res=$con->query("
    SELECT  territories.territory_id,
            territories.territory_number,
            territories.last_import_date,
            territories.last_worked_date,
            territories.territoryImageUrl,
            territories.territory_status,
            territory_queue.order_number
      FROM  territories
  LEFT JOIN territory_queue USING(territory_id)
  WHERE order_number IS NULL");
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
          <a onclick="result = confirm(' . "'Are you sure that you want to refresh territory number: " . $row["territory_number"] . "?'" . '); if(result){location.href=' . "'refreshTerritory.php?territory_id=" . $row["territory_id"] . "'" . '}" title="This refreshes the territory, marking all residents as not worked.">Refresh</a>';
    if($row["order_number"] > 0) {
      $activateLinkPath = "deactivateTerritory.php?territory_id=".$row["territory_id"];
      $activateLinkText = "Deactivate";
    } else {
      $activateLinkPath = "activateTerritory.php?territory_id=".$row["territory_id"];
      $activateLinkText = "Activate";
    }
    echo '| <a href="' . $activateLinkPath . '">' . $activateLinkText . '</a>  </td>
    </tr>
    ';
  }
  ?>
  </tbody>
</table>
  </body>
</html>
