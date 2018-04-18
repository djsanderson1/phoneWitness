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
      $territory_id = $_GET['territory_id'];
      $res=$con->query("
      SELECT COUNT(*) AS total_addresses
      FROM residents
      WHERE (exported_address IS NULL OR exported_address = 0 OR number_of_tries >= 3)
      AND status_id2 <> 3
      AND territory_id = " . $territory_id
          );
      while ($row = $res->fetch_assoc()) {
        echo $row["total_addresses"];
      }
      if(isset($_POST['howMany'])) {

        $howMany = $_POST['howMany'];
        if(!$howMany) {
          $howMany = 0;
        }
        if($howMany > 0) {
          $res=$con->query("
          SELECT *
          FROM residents
          WHERE exported_address IS NULL OR exported_address = 0
            AND territory_id = " . $territory_id . "
            AND status_id2 <> 3
            AND number_of_tries >= 3
          LIMIT " . $howMany);
          while ($row = $res->fetch_assoc()) {
            if($addressList == "") {
              $addressList = $row["name"];
            }
            $addressList = $addressList . "\n" . $row["name"];
            echo $row["total_addresses"];
          }
      }
      $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
      $txt = "John Doe\n";
      fwrite($myfile, $txt);
      $txt = "Jane Doe\n";
      fwrite($myfile, $txt);
      fclose($myfile);
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
