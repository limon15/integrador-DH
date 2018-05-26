<?php
  	require_once 'script.php';
?>

<!doctype html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/styles.css">
<meta charset="UTF-8">
<title>Crear DB</title>
<link rel="stylesheet" href="">
</head>

<body class="align-middle">
	<h1><?= (isset($message)) ? $message : null?></h1>
  <body>
    <div class="container">
      <header>
    		<div class="logo">
    			<img src="images/logo-farmacia.png" width="150" alt="">
    		    <a href="#">FARMACIAS DE TURNO</a>
    		</div>
    		<nav>
    			<a href="./ingresar.php">No tienes una DB creada</a>
    		</nav>
    	</header>
      <form method="post">
            <div class="contenedor-inputs d-flex justify-content-between">
              <button class="btn btn-lg btn-primary" name="crearDB">Crear DB</button>
              <button class="btn btn-lg btn-primary" name="crearTable">Crear tabla</button>
              <button class="btn btn-lg btn-primary" name="migrarDatos">Migrar datos</button>
              <a type="button" class="btn btn-secondary btn-lg" href="index.php">Volver al index</a>
          </div>
  		</form>
    </div>
  </body>
</html>
