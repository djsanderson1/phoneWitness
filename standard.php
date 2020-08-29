<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
<head><title>Phone Calls View</title>
<?php include 'style.php'; ?>
</head>
<body>
  <h3>Welcome to CallMaster</h3>
  You have logged in as "user"<br><br>
  Congregation: Volcano View, Albuquerque<br>
  Group: Sanderson Home<br><br>
  Territories ready for check in: <?php
    include 'mysqlConnect.php';
    $res=$con->query("
    SELECT territory_number FROM territories
    WHERE territory_number NOT IN (
      SELECT distinct (territory_number) FROM
      phonewitness.residents
      left join territory_queue using(territory_id)
      left join territories ON territories.territory_id = territory_queue.territory_id
      left join address_exports USING(address_export_id)
      WHERE (residents.status_id IS NULL
      AND residents.address_export_id IS NULL) OR
      (
        residents.address_export_id IS NOT NULL AND
        address_exports.returned_date IS NOT NULL
        )

    )
        ");
    while ($row = $res->fetch_assoc()) {
      echo $row["territory_number"].', ';
    }
  ?><br><br>
  Phone numbers ready to call:
  <?php
  require_once("functions/publishers/getPublishers.php");
  $publisher_id = getPublisherFromUser($_SESSION["userID"]);
    $res=$con->query("
    select count(*) AS ready_to_call from residents
    left join territory_queue using(territory_id)
    inner join territories ON territories.territory_id = territory_queue.territory_id
    where (status_id IN(1,2) OR status_id IS NULL) AND phone_number IS NOT NULL AND phone_number <> ''
    AND territory_queue.order_number > 0
    AND (number_of_tries < 3 OR number_of_tries IS NULL)
    AND status_id2 IS NULL
    AND (last_called_date < date(now()) OR last_called_date IS NULL)
    AND territories.assigned_publisher_id = '$publisher_id'
    AND (residents.last_accessed_time < DATE_SUB(NOW(), INTERVAL 1 HOUR) OR residents.last_accessed_time IS NULL)
        ");
    while ($row = $res->fetch_assoc()) {
      echo $row["ready_to_call"];
    }
  ?>
  <h1><a href="betweenCalls.php">Next >> </a></h1>
  <h2 style="margin-left: 0px; padding: 0px;"><a style=" color: blue;" href="https://drive.google.com/folderview?id=0B-6FV4qKXxPbTUlGejRqVEo3dWs" target="_blank">Sample Phone Presentations</a></h2>
<br><br><br><br>
<a href="logout.php" class="navbar">Logout</a>
  <!--
  Estimated time to complete: hrs mins<br> -->
</body>
</html>
