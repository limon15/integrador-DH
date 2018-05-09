<?php
  require_once('clases/usuario.php');
  require_once('clases/dbJSON.php');
  require_once('clases/validate.php');

$typeDB = 'json';

switch ($typeDB) {
  case 'json':
    $db = new dbJSON();
    break;
  case 'json':
    $db = new dbMYSQL();
    break;
  default:
    $db = NULL;
    break;
}


 ?>
