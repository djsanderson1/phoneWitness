<!doctype html>
<html>
  <head>
    <title>Button Details</title>
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
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Button Details</h1>

    <hr />

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
          echo '<tr>
            <td>Button ID:</td>
            <td>' . $qry_button_id . '</td>
          </tr>
          <tr>
            <td>Button Display:</td>
            <td>' . $qry_button_display . '</td>
          </tr>
          <tr>
            <td>Button Order:</td>
            <td>' . $qry_button_order . '</td>
          </tr>
          <tr>
            <td>Confirmation Message:</td>
            <td>' . $qry_confirm_message . '</td>
          </tr>
          <tr>
            <td>Button Group</td>
            <td>' . $qry_button_group_name . '</td>
          </tr>
          <tr>
            <td>HTML Instead</td>
            <td><strong>HTML Preview:</strong><br>
              ' . html2specialchars($qry_html_instead) . '
              <br><br><strong>Actual HTML Code</strong><br>
              <code>' . $qry_html_instead . '</code>
            </td>
          </tr>';
        }
        ?>
</table>
      </table>
      <hr />
  </body>
</html>
