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
      WHERE residents.status_id IS NULL
    )
        ");
    while ($row = $res->fetch_assoc()) {
      echo $row["territory_number"].', ';
    }
  ?><br><br>
  Phone numbers ready to call:
  <?php
    $res=$con->query("
    select count(*) AS ready_to_call from residents
    left join territory_queue using(territory_id)
    where (status_id IN(1,2) OR status_id IS NULL) AND phone_number IS NOT NULL AND phone_number <> ''
    AND territory_queue.order_number > 0
    AND number_of_tries < 3
    AND status_id2 IS NULL
        ");
    while ($row = $res->fetch_assoc()) {
      echo $row["ready_to_call"];
    }
  ?>
  <h1><a href="activity.php">Next >> </a></h1>
<br><br><br><br>
<a href="logout.php" class="navbar">Logout</a>
  <!--
  Estimated time to complete: hrs mins<br> -->
</body>
</html>
