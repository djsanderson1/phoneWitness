<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
  <head>
    <title>Add Territory</title>
    <?php include 'style.php'; ?>
    <style>
    p {
      font-weight: normal;
      font-size: 12pt;
      width: 50%;
    }
    </style>
  </head>
  <body>
    <?php include 'navbar.php';
    if(isset($_POST["territoryNumber"])){
      $territory_number = $_POST["territoryNumber"];
    }
    if(!empty($territory_number)) {
      $imgTarget_dir = "images/";
      $target_file = $imgTarget_dir . "territoryFront-" . $territory_number . "." . substr(basename($_FILES["territoryImage"]["name"]),-3);
      $imgSuccessFront = False;
      if(move_uploaded_file($_FILES["territoryImage"]["tmp_name"], $target_file)) {
        echo "territory image moved to " . $target_file . "<br>";
        $imgSuccessFront = True;
      }
      else {
        echo "move failed for " . $target_file . "<br>";
      }
      $importTarget_dir = "territories/";
      $target2_file = $importTarget_dir . basename($_FILES['residentImport']['name']);
      if(move_uploaded_file($_FILES['residentImport']['tmp_name'], $target2_file)) {
        echo "territory import moved to " . $target2_file . "<br>";
      }
      else {
        echo "move failed for " . $target2_file . "<br>";
      }
      include 'mysqlConnect.php';
      $insertTerritory = "INSERT INTO territories
                  (territory_number)
                  VALUES
                  ('" . $territory_number . "')
      ";
      if($con->query($insertTerritory)) {
        echo "Insert of Territory Successful<br>";
      }
      else {
        echo "Insert of Territory Failed-";
        printf("Error: %s\n", $con->error);
        echo "<br><br>Query is: " . $insertTerritory;
      }
      $res=$con->query("
      SELECT last_insert_id() AS territory_id
          ");
      while ($row = $res->fetch_assoc()) {
        global $territory_id;
        $territory_id = $row['territory_id'];
      }
      $res=$con->query("
      select max(order_number) AS maxOrderNumber from territory_queue
          ");
      while ($row = $res->fetch_assoc()) {
        $nextQueueNumber = $row['maxOrderNumber']+1;
      }
      $insertTerritoryQueue = "INSERT INTO territory_queue
                  (territory_id, order_number)
                  VALUES
                  ('" . $territory_id . "', $nextQueueNumber)
      ";
      if($con->query($insertTerritoryQueue)) {
        echo "Insert of Territory Queue Successful<br>";
      }
      else {
        echo "Insert of Territory Queue Failed-";
        printf("Error: %s\n", $con->error);
        echo "<br><br>Query is: " . $insertTerritoryQueue;
      }
      $importResidents = "load data infile 'C:/wamp64/www/phoneWitness/" . $target2_file . "' into table residents
        FIELDS TERMINATED BY ','
        IGNORE 1 LINES
        (
          name, address, phone_number, do_not_call, day_sleeper, melissa_address_key

          ) SET territory_id = " . $territory_id;
      if($con->query($importResidents)) {
        echo "Import of Residents Successful<br>";
        require_once('fxUpdateTerritory.php');
        $importDate = date("Y-m-d");
        updateTerritoryImportDate($territory_id, $importDate);
        if($imgSuccessFront) {
          updateTerritoryImageURL($territory_id, $target_file);
        }
      }
      else {
        echo "Import of Residents Failed-";
        printf("Error: %s\n", $con->error);
        echo "<br><br>";
      }
      $updateResidentsFirst = "update residents set status_id2 = 3 where do_not_call = 'y'";
      if($con->query($updateResidentsFirst)) {
        echo "Update1 of Residents Successful<br>";
      }
      else {
        echo "Update1 of Residents Failed-";
        printf("Error: %s\n", $con->error);
        echo "<br><br>";
      }
      $updateResidentsSecond = "update residents set status_id2 = 6 where day_sleeper = 'y'";
      if($con->query($updateResidentsSecond)) {
        echo "Update2 of Residents Successful<br>";
      }
      else {
        echo "Update2 of Residents Failed-";
        printf("Error: %s\n", $con->error);
        echo "<br><br>";
      }
    }
    ?>
    <h1>Add a Territory</h1>
    <form action="addTerritory.php" enctype="multipart/form-data" method="post">
      <label for="territoryNumber"><strong>Territory Number:</strong></label><br>
      <input type="text" name="territoryNumber"><br><br>
      <label for="territoryImage"><strong>Picture of Territory:</strong></label><br>
      <input type="file" name="territoryImage" id="territoryImage"><br><br>
      <label for="residentImport"><strong>Resident Import File:</strong><br>
        <p>This file must have the information formatted in a certain way. It will need to be a csv
        with the following field order and headings: Name, Address, Phone, Do Not Call,
        Day Sleeper, Melissa Address Key(MAk). The Do Not Call and Day Sleeper must have a single character "y"
        for yes if they are Do Not Calls or Day Sleepers. If not, simply leave the field for day sleepers blank.</p>
      </label><br>

      <input type="file" name="residentImport" id="residentImport"><br><br>
      <input type="submit" value="Add Territory">
    </form>
  </body>
</html>
