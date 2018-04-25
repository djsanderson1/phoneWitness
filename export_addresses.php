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
      if(isset($_GET['territory_id'])) {
        $territory_id = $_GET['territory_id'];
        $res=$con->query("
        SELECT COUNT(*) AS total_addresses
        FROM residents
        WHERE (address_export_id IS NULL OR address_export_id = 0)
        AND number_of_tries >= 3
        AND (status_id2 <> 3 OR status_id2 IS NULL)
        AND territory_id = " . $territory_id
            );
        while ($row = $res->fetch_assoc()) {
          echo $row["total_addresses"];
        }
      }

      if(isset($_POST['howMany'])) {
        $territory_id = $_POST['territory_id'];
        $howMany = $_POST['howMany'];
        if(!$howMany) {
          $howMany = 0;
        }
        if($howMany > 0) {
          $addressList = "";
          $res=$con->query("
          SELECT *
          FROM residents
          WHERE (address_export_id IS NULL OR address_export_id = 0)
            AND territory_id = " . $territory_id . "
            AND (status_id2 <> 3 OR status_id2 IS NULL)
            AND number_of_tries >= 3
          LIMIT " . $howMany);
          while ($row = $res->fetch_assoc()) {
            if($row["status_id2"]==6) {
              $daySleeper = ",Day Sleeper";
            } else {
              $daySleeper = "";
            }
            if($addressList == "") {
              $addressList = $row["name"] . "," . $row["address"] . $daySleeper . "\r\n";
            }
            else {
              $addressList = $addressList . $row["name"] . "," . $row["address"] . $daySleeper . "\r\n";
            }

          }
          echo "addressList: <pre>" . $addressList . "</pre>";
      }
      $myfile = fopen("export.csv", "w") or die("Unable to open file!");
      fwrite($myfile, $addressList);
      fclose($myfile);
        $con->query("
          INSERT INTO
          address_exports
          (
            export_date,
            publisher_id
            )

            values (
              now(),
              '1'
              )
        ");
        $con->query("
          UPDATE residents
          SET address_export_id = last_insert_id(),
          last_called_date = date(now())
          WHERE (address_export_id IS NULL OR address_export_id = 0)
            AND territory_id = " . $territory_id . "
            AND (status_id2 <> 3 OR status_id2 IS NULL)
            AND number_of_tries >= 3
          LIMIT " . $howMany
        );
        header('Location: export.csv');
        }
      ?>
    <form action="export_addresses.php" name="exportForm" method="POST">
      <label for="howMany">How Many Addresses to Export?:</label>
      <input type="hidden" name="territory_id" value="<?php echo $territory_id; ?>">
      <input type="text" name="howMany"><br>
      <button type="submit">Export Now!</button>
    </form>
  </body>
</html>
