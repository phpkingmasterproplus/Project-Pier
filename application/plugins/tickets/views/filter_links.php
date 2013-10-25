<?php
  $property_in_url = isset($params[$property_name]) ? $params[$property_name] : "";
  echo '<a class="btn btn-default btn-xs" href="'.get_url('tickets', 'index', array_merge($params, array($property_name=> ''))).'" '.($property_in_url == "" ? 'class="selected"' : '').'>'.lang('all').'</a> ';

  foreach ($properties as $property) {
    echo '&nbsp;&nbsp;';
    echo '<a'
         .' href="' . get_url('tickets', 'index', array_merge($params, array($property_name=> $property))). '"'
         .' class="btn btn-default btn-xs' . (preg_match("/^(.*,)?$property(,.*)?$/", $property_in_url) ? ' btn-info' : '') . '"'
         .'>'
         .lang($property).'</a>';

    if (preg_match("/^(.*,)?$property(,.*)?$/", $property_in_url)) {
      echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => preg_replace(array("/^$property,+/", "/,+$property,+/", "/,+$property$/", "/^$property$/"), array('', ',', '', ''), $property_in_url)))).'"><i class="icon icon-minus-sign"></i></a> ';
    } else {
      echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => ($property_in_url == "" ? $property : $property_in_url.','.$property)))).'"><i class="icon icon-plus-sign"></i></a>';
    }
  }
?>