<!doctype html>
<html>
  <head>
    <title>Admin</title>
    <?php include 'style.php'; ?>
  </head>
  <body onload="exportForm.howMany.focus();">
    <?php include 'navbar.php'; ?>
    <h1>Export Addresses</h1>
    <p>Select how many addresses you want to export.</p>
    Available to export:
      <?php
      include 'mysqlConnect.php';
      $res=$con->query("
      SELECT COUNT(*) AS total_addresses
      FROM residents
      WHERE exported_address IS NULL OR exported_address = 0
          ");
      while ($row = $res->fetch_assoc()) {
        echo $row["total_addresses"];
      }
      $howMany = $_POST['howMany'];
      if(!$howMany) {
        $howMany = 0;
      }
      if($howMany > 0) {
        $res=$con->query("
        SELECT *
        FROM residents
        WHERE exported_address IS NULL OR exported_address = 0
        LIMIT " . $howMany);
        while ($row = $res->fetch_assoc()) {
          echo $row["total_addresses"];
        }
        $con->query("
          UPDATE residents
          SET exported_address = 1,
          last_called_date = date(now())
          WHERE resident_id = " . $_GET['resident_id']
        );
      }
      ?>
    <form action="export_addresses.php" name="exportForm">
      <label for="howMany">How Many Addresses to Export?:</label>
      <input type="text" name="howMany"><br>
      <button type="submit">Export Now!</button>
    </form>
  </body>
</html>
