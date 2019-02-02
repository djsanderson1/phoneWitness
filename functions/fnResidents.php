<?php
function getTerritoryFromResident($resident_id) {
global $con;
  $sql = "
    SELECT territory_id
    FROM residents INNER JOIN territories USING(territory_id)
    WHERE resident_id = " . $resident_id . "
    LIMIT 1";

  $res=$con->query($sql);
  if($res) {
    while ($row = $res->fetch_assoc()) {
      return $row['territory_id'];
    }
  } else {
    echo "error in query";
  }

}
 ?>
