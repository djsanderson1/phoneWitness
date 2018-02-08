<!doctype html>
<html>
  <head>
    <title>Add Territory</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php';
    if(isset($_POST["territoryNumber"])){
      $territory_number = $_POST["territoryNumber"];
    }
    if(!empty($territory_number)) {
      $imgTarget_dir = "images/";
      $target_file = $imgTarget_dir . basename($_FILES["territoryImage"]["name"]);
      if(move_uploaded_file($_FILES["territoryImage"]["tmp_name"], $target_file)) {
        echo "territory image moved to " . $target_file;
      }
      else {
        echo "move failed for " . $target_file . "<br>";
      }
      $importTarget_dir = "territories/";
      $target2_file = $importTarget_dir . basename($_FILES['residentImport']['name']);
      if(move_uploaded_file($_FILES['residentImport']['tmp_name'], $target2_file)) {
        echo "territory import moved to " . $target2_file;
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
      $getTerritoryID = "SELECT last_insert_id() AS territory_id";
      $res=$con->query($getTerritoryID);
      global $territory_id;
      while ($row = $res->fetch_assoc()) {
        $territory_id = $row["territory_id"];
      }
      $importResidents = "load data LOCAL infile '/var/www/html/" . $target2_file . "' into table residents
        FIELDS TERMINATED BY ','
        IGNORE 1 LINES
        (
          name, address, phone_number

          ) SET territory_id = " . $territory_id;
      if($con->query($importResidents)) {
        echo "Import of Residents Successful<br>";
      }
      else {
        echo "Import of Residents Failed-";
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
        This file must have the information formatted in a certain way. It will need to be a csv
        with the following field order and no field headings: Name, Phone, Address, City, State, Zip
      </label><br>

      <input type="file" name="residentImport" id="residentImport"><br><br>
      <input type="submit" value="Add Territory">
    </form>
  </body>
</html>
