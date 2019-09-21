<?php
// all settings classes must be placed in this file
class settings {
  function __construct() {
    require_once("mysqlConnect.php");
    $this->getSettings();
  }
  public $congregationID = 1;
  public $getSettingsQuery = "
    SELECT *
    FROM settings
    WHERE congregation_id = " . $this->congregationID;
  protected $res = $con->query($this->getSettingsQuery);
  public function getSettings() {
    $counter = 0;
    while ($row = $res->fetch_assoc()) {
      $counter++;
      public $congregation_id[];
      public $setting_type_id[];
      public $setting_value[];
      $congregation_id[$counter] = $row['congregation_id'];
      $setting_type_id[$counter] = $row['setting_type_id'];
      $setting_value[$counter] = $row['setting_value'];
    }
    global $settingsCount = count($this->setting_value);
  }
}
class campaign extends settings {
  public function setMode($campaignMode) {
    $updateQuery = "
      UPDATE settings
      SET setting_value = " . $campaignMode . "
      WHERE congregation_id = " . $this->congregationID . "
      AND setting_type_id = 1";
    if($con->query($insertTerritory)) {
      echo "Insert of Territory Successful<br>";
    }
    else {
      echo "Insert of Territory Failed-";
      printf("Error: %s\n", $con->error);
      echo "<br><br>Query is: " . $insertTerritory;
    }
  }
  public function getMode() {
    $settingsCount = count($this->setting_value);
    $setting_type_id = $this->setting_type_id;
    $setting_value = $this->setting_value;
    $counter = 0;
    while($counter <= $settingsCount) {
      $counter++;
      if($setting_type_id[$counter] == 1) {
        return $setting_value[$counter];
      }
    }
  }
}
?>
