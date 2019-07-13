<?php
/* functions/getPublishers.php
This file contains all functions for viewing publisher information of any kind.
*/
function activePublishers($fieldList='*', $fieldOrder='first_name ASC, last_name ASC') {
  include('mysqlConnect.php');
  $res=$con->query("
  SELECT $fieldList
  FROM publishers
  ORDER BY $fieldOrder") or die($con->error);
  return $res;
}

function activePublishersDropDown($name='publisher_id') {
  echo '<select name="' . $name . '" id="' . $name . '">';
  $res = activePublishers();
  while ($row = $res->fetch_assoc()) {
    echo '<option value="' . $row['publisher_id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
  }
  echo '</select>';
}
?>
