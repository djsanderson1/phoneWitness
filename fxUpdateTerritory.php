    <?php
/* fxUpdateTerritory.php
Created: 5/13/2018 by DJ Sanderson
Purpose of this file is to hold the variety of functions needed to modify a territory.
This has everything except for the functions to create the territory which is in
the fxCreateTerritory.php file. Below is a listing of all functions and what they do:

importResidents($territory_number) - Runs the actual import of residents. This requires that you have
  a list of residents passed by a form.

frmUploadResidents() - This is the form for uploading residents.

inpUploadResidents() - This is the form field element for uploading residents list.

updateTerritoryImage() - This is the code that actually deals with the image file(s) for a
  territory.

*/
    function importResidents($territory_number) {
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
        $insertTerritoryQueue = "INSERT INTO territory_queue
                    (territory_id, order_number)
                    VALUES
                    ('" . $getTerritoryID . "', (select max(order_number) from territory_queue)+1)
        ";
        if($con->query($insertTerritoryQueue)) {
          echo "Insert of Territory Queue Successful<br>";
        }
        else {
          echo "Insert of Territory Queue Failed-";
          printf("Error: %s\n", $con->error);
          echo "<br><br>Query is: " . $insertTerritoryQueue;
        }
        $res=$con->query($getTerritoryID);
        global $territory_id;
        while ($row = $res->fetch_assoc()) {
          $territory_id = $row["territory_id"];
        }
        $importResidents = "load data LOCAL infile 'C:/wamp64/www/phoneWitness/" . $target2_file . "' into table residents
          FIELDS TERMINATED BY ','
          IGNORE 1 LINES
          (
            name, address, phone_number, do_not_call, day_sleeper

            ) SET territory_id = " . $territory_id;
        if($con->query($importResidents)) {
          echo "Import of Residents Successful<br>";
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
        if($con->query($updateResidentsFirst)) {
          echo "Update2 of Residents Successful<br>";
        }
        else {
          echo "Update2 of Residents Failed-";
          printf("Error: %s\n", $con->error);
          echo "<br><br>";
        }
      }
    }
    // In updateTerritoryImage the $territorySide argument can be 1 for front or 2 for back
    // Make sure to also name the fields in form territoryImage1 and territoryImage2
    function updateTerritoryImage($territoryNumber, $territorySide) {
      if(!empty($territoryNumber)) {
        $imgTarget_dir = "images/";
        $path = $_FILES['territoryImage'.$territorySide]['name'];
        $imgExtension = pathinfo($path, PATHINFO_EXTENSION);
        $target_file = $imgTarget_dir . $territoryNumber . "-" . $territorySide . "." . $imgExtension;
        if(move_uploaded_file($_FILES["territoryImage"]["tmp_name"], $target_file)) {
          echo "Territory image upload successful.<br>";
        }
        else {
          echo "Territory image upload failed.<br>";
        }
      }
    }
    ?>
