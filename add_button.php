<!doctype html>
<html>
  <head>
    <script src="frmHelper.js"></script>
    <title>Add Button</title>
    <?php include 'style.php'; ?>

  </head>
  <body onload="frmButton.button_name.focus();">

    <?php include 'navbar.php'; ?>
    <h1>Add Button</h1>
    <form action="insert_button.php" name="frmButton" method="post">
      <input type="hidden" name="button_group_id" value="<?php echo $_GET['button_group_id']; ?>">

      <label for="button_name">Button Display Name:</label><br>
      <input type="text" name="button_name"><br><br>

      <label for="button_order">Button Order (Blank for alphabetical):</label><br>
      <input type="number" name="button_order"><br><br>

      <label for="confirm_message">Confirmation Message:</label><br>
      <input type="text" name="confirm_message" size="50"><br><br>

      <label for="confirm_message">Status (Sets the status of the resident. Leave blank unless this is the final outcome):</label><br>
      <select name="status_id">
        <option value="0">&nbsp;</option>
        <?php
          require_once("mysqlConnect.php");
          $res=$con->query("
            SELECT * FROM status_list
              ");
          while ($row = $res->fetch_assoc()) {
            echo '<option value="' . $row["status_id"] . '">' . $row["status_name"] . '</option>';
          }
        ?>
      </select>
        <br><br>

      <label for="html_instead">HTML Instead (This will use HTML instead of a button):</label><br>
      <textarea name="html_instead" cols="100" rows="8"></textarea><br><br>

      <button name="addButton" type="submit">Add Button</button>
      <button onclick="window.history.back()" type="button">Cancel</button>
    </form>

  </body>
</html>
