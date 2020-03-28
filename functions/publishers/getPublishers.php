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

function getPublisherFromUser($user_id = '') {
  if($user_id == '') {
    $user_id = $_SESSION["userID"];
  }
  $qry = "SELECT publisher_id FROM users where user_id = $user_id";
  include('mysqlConnect.php');
  $res=$con->query($qry) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    $publisher_id = $row['publisher_id'];
  }
  return $publisher_id;
}

function activePublishersDropDown($name='publisher_id') {
  echo '<select name="' . $name . '" id="' . $name . '"><option value="0"></option>';
  $res = activePublishers();
  while ($row = $res->fetch_assoc()) {
    echo '<option value="' . $row['publisher_id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
  }
  echo '</select>';
}

function getMaxWeeklyExports($publisher_id = 0) {
  include('mysqlConnect.php');
  if($publisher_id > 0) {
    $sql = "select setting_value from settings where publisher_id = $publisher_id limit 1";
    $res = $con->query($sql) or die($con->error);
    $rowCount = 0;
    while ($row = $res->fetch_assoc()) {
      $rowCount++;
      $maxWeeklyExports = $row['setting_value'];
    }
    if($rowCount > 0) {
      return $maxWeeklyExports;
    } else {
      $user_type_id = getUserTypeFromPublisher();
      if($user_type_id > 0) {
        $sql2 = "
          select setting_value
            from settings
           where user_type_id = $user_type_id
            and publisher_id is null
            and setting_type_id = 2";
        $res2 = $con->query($sql2) or die($con->error);
        $rowCount = 0;
        while ($row = $res->fetch_assoc()) {
          $rowCount++;
          $maxWeeklyExports = $row['setting_value'];
        }
        return $maxWeeklyExports;
      } else {
        return getDefaultMaxExports();
      }
    }
  } else {
    return getDefaultMaxExports();
  }
}

function getDefaultMaxExports() {
  include('mysqlConnect.php');
  $sql2 = "
    select setting_value
      from settings
     where user_type_id = 3
      and publisher_id is null
      and setting_type_id = 2";
  $res2 = $con->query($sql2) or die($con->error);
  $rowCount = 0;
  while ($row = $res->fetch_assoc()) {
    $rowCount++;
    $maxWeeklyExports = $row['setting_value'];
  }
  return $maxWeeklyExports;
}

// function gets the total number of exported addresses for this week. Week starts on Saturday.
function getThisWeeksExports($publisher) {
  include 'mysqlConnect.php';
  $lastSaturday = getLastSaturday();
  $sql = "
    SELECT count(*) as thisWeeksExports
      from residents
      inner join address_exports using(address_export_id)
    where publisher_id = $publisher
      and export_date between '$lastSaturday' AND curdate()";
  $res = $con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    return $row['thisWeeksExports'];
  }
}

function getLastSaturday() {
  include 'mysqlConnect.php';
  $sql = "SELECT
    if(weekday(curdate()) >= 5,
      date_sub(curdate(), interval weekday(curdate()) - 5 day),
      date_sub(curdate(), interval weekday(curdate()) + 2 day)) AS last_saturday_date";
  $res = $con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    return $row['last_saturday_date'];
  }
}

function getUserTypeFromPublisher($publisher_id = 0) {
  include('mysqlConnect.php');
  $sql = "select user_type_id from users where publisher_id = $publisher_id";
  $res = $con->query($sql) or die($con->error);
  $rowCount = 0;
  while ($row = $res->fetch_assoc()) {
    $rowCount++;
    $user_type_id = $row['user_type_id'];
  }
  if($rowCount > 0) {
    return $user_type_id;
  } else {
    return 0;
  }
}

function getRemainingWeeklyExports($publisher_id = 0) {
  if($_SESSION["userTypeID"] != 1 && $_SESSION["userTypeID"] != 4) {
    $publisherMax = 80 - getThisWeeksExports($publisher_id);
    return $publisherMax;
  } else {
    // code below runs if admin user
    return 10000;
  }
}
?>
