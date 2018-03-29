<?php
echo '
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body, button, h2 {
  ';
include 'mysqlConnect.php';
$res=$con->query("SELECT * FROM styles");
while ($row = $res->fetch_assoc()) {
  $style_value = $row['style_value'];
  $style_name = $row['style_name'];
  echo $style_name . ':' . $style_value . ';';
}
echo '
}
ul.navbar {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}
@media only screen and (min-device-width: 500px) {
  li.navbar {
      float: left;
  }
}
@media only screen and (max-device-width: 499px) {
  li.navbar {
      text-align: left;
  }
  body {
    width: 100%;
  }
}
li.navbar a.navbar {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change the link color to #111 (black) on hover */
li.navbar a:hover {
    background-color: #111;
}
th {
  background-color: #555;
}
table {
  border: 1px white solid;
}
a {
  color: lightgreen;
  text-decoration: underline;
  cursor: pointer;
}
button {
  background-color: #cccccc;
  color: black;
  font-weight: bold;
  margin: 10px;
}
h2 {
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 10px;
  line-height: 14px;
}
label {
  font-weight: bold;
}
</style>';
?>
