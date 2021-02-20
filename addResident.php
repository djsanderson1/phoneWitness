<?php require_once('authenticate.php');
$territory_id = '';
if(isset($_GET["territory_id"])) {
  $territory_id = $_GET["territory_id"];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Resident</title>
    <?php include 'style.php'; ?>
  </head>
  <body onload="addResident.name.focus();">
    <?php include 'navbar.php'; ?>
    <h1>Edit Resident</h1>
    <form action="insertResident.php" method="post" name="addResident">
      <input name="territory_id" type="hidden" value="<?php echo $territory_id; ?>">
      <table>
        <tr>
          <td><label for="name">Name</label></td>
          <td><input name="name" type="text"></td>
        </tr>
        <tr>
          <td><label for="phone">Phone</label></td>
          <td><input name="phone" type="text"></td>
        </tr>
        <tr>
          <td><label for="address">Address</label></td>
          <td><input name="address" type="text"></td>
        </tr>
        <tr>
          <td><label for="last_called">Last Called</label></td>
          <td><input name="last_called" type="date">
            <button type="button" onclick="document.getElementsByName('last_called')[0].value='';" style="font-size: 12pt">Clear</button>
          </td>
        </tr>
        <tr>
          <td><label for="name"># of Tries</label></td>
          <td><input name="number_of_tries" type="number" style="width: 30px;"></td>
        </tr>
        <tr>
          <td><label for="status">Status</label></td>
          <td><select name="status">
              <option value="0"></option>
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
        <tr>
          <td colspan="2"><button type="submit"><strong>Add Resident</strong></button></td>
        </tr>
      </table>
    </form>
  </body>
</html>
