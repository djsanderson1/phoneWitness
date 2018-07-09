<!doctype html>
<html>
  <head>
    <title>Settings</title>
    <?php include 'style.php'; ?>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <h1>Welcome to the settings page</h1>

    <h2>Buttons</h2>
    <p>Remember to click the Save button to save your changes! The system will only use status on the final list that gets displayed in your button group.</p>

      <form action="insert_button_group.php" method="post">
        Button Group Name: <input type="text" placeholder="My Button Group" name="button_group_name">
        <button type="submit">Add</button>
      </form>
      <h3>Button Groups</h3>
      <table>
        <tr>
          <th>Name</th>
          <th>Buttons</th>
          <th>Add Button</th>
        </tr>
        <?php
        require_once('mysqlConnect.php');
        $res=$con->query("
         
            ");
        while ($row = $res->fetch_assoc()) {
        echo '';
        }
        ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    <table>
      <tr>
        <th>Button Display</th>
        <th>Status</th>
        <th></th>
        <th></th>
      </tr>
    </table>
  </body>
</html>
