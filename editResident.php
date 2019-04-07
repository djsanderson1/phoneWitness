<?php require_once('authenticate.php');
$territory_id = '';
$resident_id = '';
if(isset($_GET["territory_id"])) {
  $territory_id = $_GET["territory_id"];
}
if(isset($_GET["resident_id"])) {
  $resident_id = $_GET["resident_id"];
}
include 'mysqlConnect.php';
$res=$con->query("SELECT * FROM residents WHERE resident_id = $resident_id");
while ($row = $res->fetch_assoc()) :
  $name = $row['name'];
  $phone = $row['phone_number'];
  $address = $row['address'];
  $last_called = $row['last_called_date'];
  $status_id = $row['status_id'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Resident</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Edit Resident</h1>
    <table>
      <tr>
        <td><label for="name">Name</label></td>
        <td><input name="" type="text" value="<?php echo $name ?>"></td>
      </tr>
      <tr>
        <td><label for="phone">Phone</label></td>
        <td><input name="" type="text" value="<?php echo $phone ?>"></td>
      </tr>
      <tr>
        <td><label for="address">Address</label></td>
        <td><input name="" type="text" value="<?php echo $address ?>"></td>
      </tr>
      <tr>
        <td><label for="last_called">Last Called</label></td>
        <td><input name="" type="text" value="<?php echo $last_called ?>"></td>
      </tr>
      <tr>
        <td><label for="status">Status</label></td>
        <td><select name="status">
            <?php $res2=$con->query("SELECT * FROM status_list");
            while ($row2 = $res2->fetch_assoc()) :
              $statusDisplayName = $row2['status_name'];
              $thisStatusID = $row2['status_id'];
            ?>
            <option value="<?php echo $thisStatusID; ?>"><?php echo $statusDisplayName; ?></option>
          <?php endwhile; ?>
          </select>
        </td>
      </tr>
    <?php endwhile; ?>
    </table>
  </body>
</html>
