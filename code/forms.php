<?php

require_once "formvalidator.php";

function error_for($field_name) {
  global $errors;
  return array_key_exists($field_name, $errors) ? ' class="error"' : '';
}

function select_input($name, $label, $arr, $hint = null) {
  $output = '';
  $output .= '<p' . error_for($name) . '>';
  $output .= "<label for=\"$name\">$label</label>";
  if(!is_null($hint)) {
    $output .= "<span class=\"hint\"$hint</span>";
  }
  $output .= "<select name=\"$name\">";
  foreach($arr as $option) {
    $output .= "<option value=\"$option\"";
    if($_POST[$name] == $option) {
      $output .= ' selected="selected"';
    }
    $output .= ">$option</option>";
  }
  $output .= "</select>";
  return $output;
}

function text_input($name, $label, $hint = null, $maxlength = 40 ) {
  $output = '';
  $output .= '<p' . error_for($name) . '>';
  $output .= "<label for=\"$name\">$label</label>";
  if(!is_null($hint)) {
    $output .= "<span class=\"hint\">$hint</span>";
  }
  $output .= "<input type=\"text\" name=\"$name\" size=\"" . min(40, $maxlength). "\" maxlength=\"$maxlength\" value=\"" . htmlspecialchars($_POST[$name], ENT_QUOTES) . "\" />";
  $output .= '</p>';
  return $output;
}

function valid_referrer($page_name) {
  $valid_name = "http://www.cupwithlove.org/$page_name";
  $ref_page = $_SERVER["HTTP_REFERER"];
  
  return ($ref_page == $valid_name || $ref_page == str_replace('http://www.', 'http://', $valid_name));
}
?>