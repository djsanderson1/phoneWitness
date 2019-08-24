function territoryActionList(id,territory_number) {
  var selectBox = document.getElementById(id);
  var territory_id = id.substr(12);
  var selectedValue = selectBox.options[selectBox.selectedIndex].value;
  if(confirm(selectedValue)) {
    switch(selectedValue) {
      case "delete":
        var msg = "Are you sure you want to delete territory number " + territory_number + "?";
        var url = "deleteTerritory.php?territory_id=" + territory_id;
        confirmedRedirect(url,msg);
        break;
      case "export":
        var url = "exportTerritory.php?territory_id=" + territory_id;
        location.href=url;
        break;
      case "refresh":
        var msg = "Are you sure you want to refresh territory number " + territory_number + "?";
        var url = "refreshTerritory.php?territory_id=" + territory_id;
        confirmedRedirect(url,msg);
        break;
      case "viewExport":
        var url = "viewExportedAddresses.php?territory_id=" + territory_id;
        location.href=url;
        break;
    }
  }
}
function confirmedRedirect(url,msg) {
  if(confirm(msg)) {
    location.href=url;
  }
}
