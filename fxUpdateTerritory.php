    <?php
/* fxUpdateTerritory.php

Purpose:
---------------------------------------------------------------------------------------
Purpose of this file is to hold the variety of functions needed to modify a territory.
---------------------------------------------------------------------------------------

Details:
---------------------------------------------------------------------------------------
This has everything except for the functions to create the territory which is in
the fxCreateTerritory.php file.
---------------------------------------------------------------------------------------

Functions List:
---------------------------------------------------------------------------------------
updateTerritoryLastWorkedDate($territory_id, $lastWorkedDate) - This will update the last
  worked date for this territory.

updateTerritoryImportDate($)
---------------------------------------------------------------------------------------

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
    function updateTerritoryImageURL($territory_id = 0, $imageURL='') {
      if($imageURL != '' AND $territory_id != 0) {
        $sql = "
          UPDATE territories
             SET territoryImageUrl = '" . $imageURL . "'
            WHERE territory_id = " . $territory_id;
      }
      noResponseSQL($sql);
    }
    ?>
