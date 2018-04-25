function dropDown(id) {
  var selectBox = document.getElementById(id);
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    alert(selectedValue);
}
