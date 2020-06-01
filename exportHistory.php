<!DOCTYPE html>
<?php
  require_once('authenticate.php');

?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Export History</title>
  <?php include 'style.php'; ?>
</head>
<body>
  <?php
    include 'navbar.php';
  ?><h1>Export History</h1>
  <p>Click the date to re-download that export file.</p>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Territory Number</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include 'mysqlConnect.php';
        $user_id = $_SESSION['userID'];
        $res=$con->query("
          SELECT export_date, file_path,
          COALESCE(territory_number,'') AS territory_number
          FROM phonewitness.address_exports
          LEFT JOIN residents using (address_export_id)
          LEFT JOIN territories using(territory_id)
          INNER JOIN users ON users.publisher_id = address_exports.publisher_id
          WHERE users.user_id = ".$user_id."
          AND file_path IS NOT NULL
          GROUP BY address_export_id
          ORDER BY address_export_id DESC
        ");
        while ($row = $res->fetch_assoc()) {
          $sExportDate = strtotime($row['export_date']);
          $export_date = date('n/j/Y', $sExportDate);
          if($row["territory_number"] > 0) {
            $territory_number = $row["territory_number"];
          } else {
            $territory_number = "";
          }

          echo "
            <tr>
              <td><a href='".$row["file_path"]."'>$export_date</a></td>
              <td>$territory_number</td>
            </tr>";
        }
      ?>
    </tbody>
  </table>
</body>
</html>
