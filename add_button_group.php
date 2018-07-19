<!doctype html>
<html>
  <head>
    <title>Settings</title>
    <?php include 'style.php'; ?>

  </head>
  <body onload="frmButtonGroup.button_group_name.focus();">

    <?php include 'navbar.php'; ?>
    <h1>Add Button Group</h1>
    <form action="insert_button_group.php" name="frmButtonGroup" method="post">
      <label for="button_group_name">Button Group Name:</label><br>
      <input type="text" name="button_group_name"><br><br>

      <label for="button_group_order">First Button Group?:</label>
      <input type="checkbox" name="button_group_order" value="1"><br><br>

      <label for="next_button_group_id">Next Button Group?:</label><br>
      <select name="next_button_group_id">
        <option value="0">-- Select Next Button Group --</option>
      <?php
      require_once 'mysqlConnect.php';
      $res=$con->query("
      SELECT * FROM button_groups
          ");
      while ($row = $res->fetch_assoc()) {
      echo '<option value="' . $row["button_group_id"] . '">' . $row["button_group_name"] . '</option>';
    }
    ?>
      </select><br><br>
      <label for="next_button_group_id">Url to Execute:</label><br>
      <input type="text" name="action_url"><br>This will forward to the above URL instead of displaying a button group. Only the last button group can have this filled in.<br><br>
      <button name="addButton" type="submit">Add Button Group</button>
      <button onclick="goBack()">Cancel</button>
    </form>



  </body>
</html>
