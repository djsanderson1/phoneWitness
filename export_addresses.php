<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
  <head>
    <title>Admin</title>
    <?php include 'style.php'; ?>
  </head>
  <body onload="exportForm.howMany.focus();">
    <?php include 'navbar.php'; ?>
    <h1>Export Addresses for territory number: <?php
    if(isset($_GET['territory_id'])) {
      $territory_id = $_GET['territory_id'];
      require_once('mysqlConnect.php');
      $res=$con->query("
      SELECT territory_number
        FROM territories
       WHERE territory_id = $territory_id");
      while ($row = $res->fetch_assoc()) {
        global $territory_number;
        $territory_number = $row["territory_number"];
        echo $territory_number;
      }
    }
    ?></h1>
    <p>Select how many addresses you want to export.</p>
    Available to export:
      <?php
      include 'mysqlConnect.php';
      $qryFilterMostly = "((address_export_id IS NULL OR address_export_id = 0) AND (status_id2 <> 3 OR status_id2 IS NULL))
                    AND (
                      number_of_tries >= 3
                      OR phone_number IS NULL
                      OR phone_number = '')
                    AND territory_id = ";
      if(isset($_GET['territory_id'])) {
        $territory_id = $_GET['territory_id'];
        $qryFilter = $qryFilterMostly . $territory_id;
      //  echo "<br>" . $qryFilter . "<br>";
        $res=$con->query("
        SELECT COUNT(*) AS total_addresses
        FROM residents
        WHERE" . $qryFilter
            );
        while ($row = $res->fetch_assoc()) {
          echo $row["total_addresses"];
        }
      //  echo "<br>" . $qryFilter;
      }
      if(isset($_POST['howMany'])) {
        $territory_id = $_POST['territory_id'];
        $qryFilter = $qryFilterMostly . $territory_id;
        $howMany = $_POST['howMany'];
        if(!$howMany) {
          $howMany = 0;
        }
        if($howMany > 0) {
          $addressList = "";
          $res=$con->query("
          SELECT *
          FROM residents
          LEFT JOIN territories USING(territory_id)
          WHERE" . $qryFilter . "
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
            global $territory_number;
            $territory_number = $row['territory_number'];
          }
      }
      $publisher_id = $_POST['publisher_id'];
      $sqlPublisherName = "
        SELECT first_name, last_name
        FROM publishers
        WHERE publisher_id = $publisher_id";
      $res=$con->query($sqlPublisherName);
      while ($row = $res->fetch_assoc()) {
        global $strPublisherFirstName, $strPublisherLastName;
        $strPublisherFirstName = $row['first_name'];
        $strPublisherLastName = $row['last_name'];
      }
      $todaysDate = date("m-d-Y");
      $exportFileName = "Territory Number " . $territory_number . " - " . $strPublisherFirstName . " " . $strPublisherLastName . " - " . $todaysDate . ".csv";
      $myfile = fopen($exportFileName, "w") or die("Unable to open file!");
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
              $publisher_id
              )
        ");
        $con->query("
          UPDATE residents
          SET address_export_id = last_insert_id(),
          last_called_date = date(now())
          WHERE " . $qryFilter . "
          LIMIT " . $howMany
        );
        echo '<meta http-equiv="refresh" content="1; url=/'.$exportFileName.'">';
        }
      ?>
    <form action="export_addresses.php" name="exportForm" method="POST">

      <input type="hidden" name="territory_id" value="<?php echo $territory_id; ?>">
      <label for="howMany">How Many Addresses to Export?:</label>
      <input type="text" name="howMany"><br><br>
      <label for="howMany">Publisher to check out to:</label>
      <select name="publisher_id" onchange="if(this.value.substring(0,12)=='addPublisher'){location = this.value}">
        <option value="0">-- Please select a publisher --</option>
        <?php
        include 'mysqlConnect.php';
        $res=$con->query("
          SELECT concat(first_name, ' ' ,last_name) AS full_name, publisher_id
          FROM publishers
          ORDER BY full_name");
        while ($row = $res->fetch_assoc()) {
          $full_name = $row["full_name"];
          $publisher_id = $row["publisher_id"];
          echo "<option value='" . $publisher_id . "'>" . $full_name . "</option>";
        }
        echo '<option value="addPublisher.php?territory_id=' . $territory_id . '" style="font-weight: bold;">Add a Publisher...</option>';
        ?>

      </select><br>
      <button type="submit">Export Now!</button>
    </form>
  </body>
</html>
