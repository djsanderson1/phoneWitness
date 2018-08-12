<?php
function html2specialchars($str){
    $trans_table = array_flip(get_html_translation_table(HTML_ENTITIES));
    return strtr($str, $trans_table);
}
function getVar($str, $blankValue) {
  if (isset($_GET[$str])) {
      return $_GET($str);
  }
  else {
    if(isset($_POST[$str])) {
      return $_POST[$str];
    }
    else {
      if(isset(${$str})) {
        return ${$str};
      }
      else {
        return $blankValue;
      }
    }
  }
}
?>
