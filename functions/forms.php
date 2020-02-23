<?php
function getCheckboxSetting($value) {
  if($value == '1') {
    return 'checked';
  } else {
    return '';
  }
}

function textField($fieldName, $currentValue = "", $label="") {
  $fieldLabel = fieldLabel($fieldName, $label);
  return '<tr>'.$fieldLabel.'<td><input type="text" name="'.$fieldName.'" id="'.$fieldName.'" value="'.$currentValue.'"></td></tr>';
}

function passwordField($fieldName = "", $currentValue = "", $label="") {
  $fieldLabel = fieldLabel($fieldName, $label);
  return '<tr>'.$fieldLabel.'<td><input type="password" name="'.$fieldName.'" value="'.$currentValue.'"></td></tr>';
}

function fieldLabel($fieldName, $label = "") {
  if($label == "") {
    $label = $fieldName;
  }
  return '<td><label for="'.$fieldName.'">'.$label.': </label></td>';
}

function checkUsername($username, $user_id) {
  include('/mysqlConnect.php');
  $sql = "select count(*) as same_names from users where user_id <> $user_id and username = '".$username."'";
  $res=$con->query($sql) or die($con->error);
  while ($row = $res->fetch_assoc()) {
    $same_names = $row['same_names'];
    if($same_names > 0) {
      return 'Username is duplicate. Try something else.';
    } else {
      return 'ok';
    }
  }
}

function updateFromForm($post = 0, $table = 0, $keyField = 0, $keyValue = 0, $table2 = '', $keyField2 = '') {
  if($post === 0 or $table === 0 or $keyField === 0 or $keyValue === 0) {
    return "Missing Field Error:<br><br>Table: $table<br>Key Field: $keyField<br>Key Value: $keyValue";
  }
  $join = '';
  if($table2 != '' && $keyField2 != '') {
    $join = ' left join '.$table2." on $table2.$keyField2 = $table.$keyField2 ";
  }
  $sql = 'update '.$table.'
   '.$join.'
   set ';
  $counter = 0;
  foreach($_POST as $key =>$value){
    if($keyField == $key) {
      $keyValue = $value;
    } else {
      $formFields[$key] = $value;
    }
  }
  $lastCount = count($formFields);
  foreach($formFields as $key =>$value) {
    $counter++;
    $fieldValue = "'$value'";
    if($value == '') {
      $fieldValue = "null";
    }
    $sql .= "$key = $fieldValue";
    if($counter != $lastCount) {
      $sql .= ',
      ';
    }
  }
  $where = "
  where $table.$keyField = $keyValue";
  // echo $sql.$where;
  include('/mysqlConnect.php');
  noResponseSQL($sql.$where, '<strong>User Profile Updated!</strong>', "<strong style='color: red;'>Update Failed!</strong>");
}
 ?>
