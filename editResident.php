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
$res=$con->query("SELECT * FROM residents WHERE resident_id = $resident_id LIMIT 1");
while ($row = $res->fetch_assoc()) :
  $name = $row['name'];
  $phone = $row['phone_number'];
  $address = $row['address'];
  $last_called = $row['last_called_date'];
  $status_id = $row['status_id'];
  $number_of_tries = $row['number_of_tries'];
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
    <form action="updateResident.php" method="post">
      <input name="resident_id" type="hidden" value="<?php echo $resident_id; ?>">
      <table>
        <tr>
          <td><label for="name">Name</label></td>
          <td><input name="name" type="text" value="<?php echo $name; ?>"></td>
        </tr>
        <tr>
          <td><label for="phone">Phone</label></td>
          <td><input name="phone" type="text" value="<?php echo $phone; ?>"></td>
        </tr>
        <tr>
          <td><label for="address">Address</label></td>
          <td><input name="address" type="text" value="<?php echo $address; ?>"></td>
        </tr>
        <tr>
          <td><label for="last_called">Last Called</label></td>
          <td><input name="last_called" type="date" value="<?php echo $last_called; ?>">
            <button type="button" onclick="document.getElementsByName('last_called')[0].value='';" style="font-size: 12pt">Clear</button>
          </td>
        </tr>
        <tr>
          <td><label for="name"># of Tries</label></td>
          <td><input name="number_of_tries" type="number" value="<?php echo $number_of_tries; ?>" style="width: 30px;"></td>
        </tr>
        <tr>
          <td><label for="status">Status</label></td>
          <td><select name="status">
              <?php $res2=$con->query("SELECT * FROM status_list");
              while ($row2 = $res2->fetch_assoc()) :
                $statusDisplayName = $row2['status_name'];
                $thisStatusID = $row2['status_id'];
              ?>
              <option value="<?php echo $thisStatusID; ?>" <?php if($thisStatusID == $status_id) {echo 'selected';} ?>><?php echo $statusDisplayName; ?></option>
            <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2"><button type="submit"><strong>Update</strong></button></td>
        </tr>
      <?php endwhile; ?>
      </table>
    </form>
  </body>
</html>
