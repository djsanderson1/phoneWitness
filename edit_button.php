<!doctype html>
<html>
  <head>
    <title>Edit Button</title>
    <?php include 'style.php'; ?>
    <style>
    td:nth-child(1) {
      font-weight: bold;
      background-color: #333;
      vertical-align: top;
      text-shadow: 2px 2px #000;
    }
    td:nth-chile(2) {
      vertical-align: top;
    }
    td {
      border-top: 1px solid white;
      padding: 5px;
    }
    table {
      border-spacing: 0px;
    }
    </style>
  </head>
  <body onload="frmButton.button_display.focus();">
    <?php include 'navbar.php'; ?>
    <h1>Edit Button</h1>

    <hr />
    <form action="update_button.php" name="frmButton" method="post">
    <table>

        <?php
        require_once('displayHelper.php');
        if(is_numeric($_GET['button_id'])) {
          $button_id = $_GET['button_id'];
        } else {
          $button_id = 0;
        }
        require_once('mysqlConnect.php');
        $sql_button_details = "
         SELECT *
         FROM buttons
         LEFT JOIN button_groups USING(button_group_id)
         WHERE button_id = " . $button_id . " ORDER BY button_order ASC, button_display ASC";
        // exit($sql_button_details);
        $res=$con->query($sql_button_details);
        while ($row = $res->fetch_assoc()) {
          $qry_button_id = $row['button_id'];
          $qry_button_display = $row['button_display'];
          $qry_button_order = $row['button_order'];
          $qry_confirm_message = $row['confirm_message'];
          $qry_button_group_name = $row['button_group_name'];
          $qry_html_instead = $row['html_instead'];
          $qry_status_id = $row['status_id'];
          $qry_next_button_id = $row['next_button_id'];

          // This var holds the query string for getting button list
          $sql_button_list = "SELECT * FROM buttons ORDER BY button_display";

          // This var holds the query string for getting status list
          $sql_status_list = "SELECT * FROM status_list ORDER BY status_name";

          // This sets the variable to hold the actual query results for the button list
          $res_button_list=$con->query($sql_button_list);

          // This sets the variable to hold the actual query results for the status list
          $res_status_list=$con->query($sql_status_list);

          echo '<tr>
            <td>Button ID:</td>
            <td>' . $qry_button_id . '</td>
            <input type="hidden" name="button_id" value="' . $qry_button_id . '">
          </tr>
          <tr>
            <td><label for="button_display">Button Display:</label></td>
            <td><input type="text" name="button_display" value="' . $qry_button_display . '"></td>
          </tr>
          <tr>
            <td><label for="button_display">Resident Status:</label></td>
            <td><input type="text" name="button_display" value="' . $qry_button_display . '"></td>
          </tr>
          <tr>
            <td><label for="button_order">Button Order:</label></td>
            <td><input type="number" name="button_order" value="' . $qry_button_order . '"></td>
          </tr>
          <tr>
            <td><label for="confirm_message">Confirmation Message:</label></td>
            <td><input type="text" name="confirm_message" value="' . $qry_confirm_message . '"></td>
          </tr>
          <tr>
            <td>Button Group</td>
            <td>' . $qry_button_group_name . '</td>
          </tr>
          <tr>
            <td><label for="html_instead">HTML Instead:</label></td>
            <td>
            <textarea name="html_instead">' . $qry_html_instead . '</textarea>
            </td>
          </tr>
          <tr>
            <td></td><td><button type="submit">Save Changes</button></td>
          </tr>';
        }
        ?>
</table>
</form>
      </table>
      <hr />
  </body>
</html>
