<?php $con = mysqli_connect("localhost","root","","phoneWitness");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
  else {
    if(!function_exists('noResponseSQL')) {
      function noResponseSQL($sql,$successMsg='',$failMsg='') {
        if($con->query($importResidents)) {
          echo $successMsg;
        }
        else {
          echo $failMsg;
          printf("Error: %s\n", $con->error);
          echo "<br><br>";
        }
      }
    }
  }
?>
