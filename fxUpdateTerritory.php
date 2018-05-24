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
require_once('mysqlConnect.php');
    function updateTerritoryLastWorkedDate($territory_id=0, $lastWorkedDate='') {
      if($lastWorkedDate != '' AND $territory_id != 0) {
        $sql = "
          UPDATE territories
             SET last_worked_date = '" . $lastWorkedDate . "'
           WHERE territory_id = " . $territory_id;
        noResponseSQL($sql);
      }
    }
    function updateTerritoryImportDate($territory_id = 0, $importDate='') {
      if($importDate != '' AND $territory_id != 0) {
        $sql = "
          UPDATE territories
             SET last_import_date = '" . $importDate . "'
           WHERE territory_id = " . $territory_id;
        noResponseSQL($sql);
      }
    }
    ?>
