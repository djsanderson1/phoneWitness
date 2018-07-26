<?php
function html2specialchars($str){
    $trans_table = array_flip(get_html_translation_table(HTML_ENTITIES));
    return strtr($str, $trans_table);
}
?>
