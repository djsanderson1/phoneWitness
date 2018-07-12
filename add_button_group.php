<!doctype html>
<html>
  <head>
    <title>Settings</title>
    <?php include 'style.php'; ?>
    <style>
      div#orderHelp {
        display: none;
        background-color: gray;
      }
      .helpQuestion {
        font-weight: bold;
        font-size: 150%;
        cursor: pointer;
      }
    </style>
  </head>
  <body onload="frmButtonGroup.button_group_name.focus();">
    <div id="orderHelp">The order is what is used to determine which group will displayed first.
      It uses this to sort so you can put spaces between the numbers. This means if you put the
      first item as "10" and the next as "20" and you then realize you want to add something between
      these you can just put something as 15 so that you don't have to go back and change the order
      on all the existing items.
    </div>
    <?php include 'navbar.php'; ?>
    <h1>Add Button Group</h1>
    <form action="insert_button_group.php" name="frmButtonGroup">
      <label for="button_group_name">Button Group Name:</label><br>
      <input type="text" name="button_group_name"><br><br>

      <label for="button_group_order">Button Group Order:</label><span class="helpQuestion" onmouseover="document.getElementById('orderHelp').style.display='block'">?</span><br>
      <input type="text" name="button_group_order"><br><br>
      <button name="addButton" type="submit">Add Button Group</button>
      <button onclick="goBack()">Cancel</button>
    </form>


<script>
function goBack() {
    window.history.back();
}
function showHelp(helpName) {
  document.getElementById(helpName).style.display="block";
}
</script>
  </body>
</html>
