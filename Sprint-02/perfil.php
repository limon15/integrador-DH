<?php
	require_once('funciones.php');

	if (!estaLogueado()) {
		header('location: login.php');
		exit;
	}

	$usuario = traerPorId($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Welcome!</h1>
  </body>
</html>
