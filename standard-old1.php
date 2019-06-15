<?php require_once('authenticate.php'); ?>
<!doctype html>
<html>
<head>
  <style>
    button {
      padding: 10px;
      font-size: 25pt;
      width: 400px;
    }
  </style>
  <title>Phone Calls View</title>
  <?php include 'style.php'; ?>
</head>
<body>

  <h2 class="phone_number">
<?php
include 'mysqlConnect.php';

if(isset($_GET["status_id"]) && isset($_GET["resident_id"])) {
  $con->query("
    UPDATE residents
    SET status_id = " . $_GET['status_id'] . ",
    last_called_date = date(now())
    WHERE resident_id = " . $_GET['resident_id']
  );
}
$res=$con->query("
SELECT *
  FROM territory_queue
  LEFT JOIN residents
  USING(territory_id)
  WHERE territory_queue.territory_id > 0
  AND (last_called_date < date(now()) OR last_called_date IS NULL)
  AND (status_id IN(1,2) OR status_id IS NULL)
   ORDER BY territory_queue.order_number, last_called_date, resident_id
   LIMIT 1
    ");
while ($row = $res->fetch_assoc()) {
  echo $row["phone_number"] . "<br><br>" . $row["address"];
  echo '
  </h2>
    <button type="button" onclick="result = confirm(' . "'Are you sure'" . '); if(result){location.href=' . "'standard.php?status_id=1&resident_id=" . $row["resident_id"] . "'" . '}">Disconnected</button><br>
    <button type="button" onclick="location.href=' . "'standard.php?status_id=2&resident_id=" . $row["resident_id"] . "'" . '">No Answer</button><br>
    <button type="button" onclick="location.href=' . "'standard.php?status_id=3&resident_id=" . $row["resident_id"] . "'" . '">Do Not Call</button><br>
    <button type="button" onclick="location.href=' . "'standard.php?status_id=4&resident_id=" . $row["resident_id"] . "'" . '">Contacted</button><br>
    <button type="button" onclick="location.href=' . "'standard.php?status_id=5&resident_id=" . $row["resident_id"] . "'" . '">Foreign Language</button><br>
  ';
}
?>
  </h2>
</body>
</html>
