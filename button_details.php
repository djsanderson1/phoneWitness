<!doctype html>
<html>
  <head>
    <title>Button Details</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Button Details</h1>

    <hr />


        <?php
        if(is_numeric($_GET['button_id'])) {
          $button_id = $_GET['button_id'];
        } else {
          $button_id = 0;
        }
        require_once('mysqlConnect.php');
        $res=$con->query("
         SELECT *
         FROM buttons
         WHERE button_id = " . $button_id);
        while ($row = $res->fetch_assoc()) {
          $inner=$con->query("
            SELECT *
            FROM buttons WHERE button_group_id = " . $row['button_group_id'] . "
          ");
          $buttons = '';
          while ($innerRow = $inner->fetch_assoc()) {
            if($buttons === '') {
              $buttons .= '<a href="button_details.php?button_id=' . $innerRow['button_id'] . '">' . $innerRow['button_display'] . '</a>';
            }
            else {
              $buttons .= ', <a href="button_details.php?button_id=' . $innerRow['button_id'] . '">' . $innerRow['button_display'] . '</a>';
            }
          }
          echo '
            <tr>
              <td>' . $row['button_group_name'] . '</td>
              <td>' . $buttons . '</td>
              <td>
                <a href="add_button.php?button_group_id=' . $row['button_group_id'] . '">Add Button</a><br>
                <a href="delete_button_group.php?button_group_id=' . $row['button_group_id'] . '" onclick="return confirm(\'Are you sure you want to delete this button group?\');">Delete Group</a>
              </td>
            </tr>
          ';
        }
        ?>

      </table>
      <hr />
  </body>
</html>
