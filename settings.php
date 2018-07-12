<!doctype html>
<html>
  <head>
    <title>Settings</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Welcome to the settings page</h1>

    <hr />
<h3><a href="add_button_group.php">Add Button Group</a></h3>
      <h3>Button Groups</h3>
      <table>
        <tr>
          <th>Name</th>
          <th>Buttons</th>
          <th>Action</th>
        </tr>
        <?php
        require_once('mysqlConnect.php');
        $res=$con->query("
         SELECT *
         FROM button_groups
         ORDER BY button_group_order ASC
            ");
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
                <a href="delete_button_group.php?button_group_id=' . $row['button_group_id'] . '">Delete Group</a>
              </td>
            </tr>
          ';
        }
        ?>

      </table>
      <hr />
  </body>
</html>
