<?php
	// require_once 'script.php';
	// require_once 'funciones.php';
	require_once 'soporte.php';
	require_once 'script.php';
	// return hayConexion();
	// return consultaDB();
	if(!hayConexion()){
	  header("location:botones.php");
	  exit();
	}elseif(consultaDB() == false){
	  header("location:botones.php");
	  exit();
	}


	if ($auth->estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	// Array de errores vacío
	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {

		// Valido y guardo en errores
		$errores = $validator->validateRegister($db, 'avatar');

	if (empty($errores)) {

		$errores = $db->guardarImagen('avatar', $correo);

		if (empty($errores)) {
			$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
			$avatar = 'img/' . $correo . '.' . $ext;

			$usuario = new Usuario($_POST["name"], $_POST["apellidos"], $_POST["correo"], $_POST["usuario"], $_POST["telefono"],$_POST["clave"], $avatar);

			/* En la variable $usuario, guardo al usuario creado con la función crearUsuario()
			la cual recibe los datos de $_POST y el avatar */
			$usuarioGuardado = $db->guardarUsuario($usuario, $db);

			// Logueo al usuario y por lo tanto no es necesario el re-direct
			// loguear($usuario);
			header('location: ingresar.php');
      exit;
		}
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <title>Formulario de registro</title>
  </head>
  <body>

  <div class="container">
    <header>
			<div class="logo">
				<img src="images/logo-farmacia.png" width="150" alt="">
				<a href="#">FARMACIAS DE TURNO</a>
			</div>
			<nav>
				<a href="./index.php">Inicio</a>
				<a href="#Ayuda">Ayuda</a>
				<a href="#">Descuentos</a>
	      <a href="#">Quiénes somos</a>
        <a href="./ingresar.php">Iniciar sesión</a>
			</nav>
		</header>
    <div class="bienvenida">
      <h2 class="bienvenida-titulo">¡BIENVENIDO!</h2>
        <p class="bienvenida-parrafo">¿Buscás la farmacia de turno más cercada a tu domicilio?
        <br>Estás es el lugar correcto. Pero antes que nada, <a class="bienvenida-a" href="ingresar.php">iniciá sesión</a> o <a  class="bienvenida-a" href="#CrearCuenta">registrate.</a></p>
    </div>
    <a name="CrearCuenta" id="c"></a>
    <form method="post" enctype="multipart/form-data" class="form-registrar">
      <h2 class="form-titulo">CREA UNA CUENTA</h2>
      <div class="contenedor-inputs">
						<input type="text" name="name" placeholder="<?= isset($errores['name']) ? $errores['name'] : "Nombres" ?>" class="input-48 <?= isset($errores['name']) ? 'error' : '' ?>" value="<?= $validator->persistirDato('name') ?>">

		        <input type="text" name="apellidos" placeholder="<?= isset($errores['apellidos']) ? $errores['apellidos'] : "Apellidos" ?>" class="input-48  <?= isset($errores['apellidos']) ? 'error' : '' ?>" value="<?php $validator->persistirDato('apellidos') ?>">

		        <input type="email" name="correo" placeholder="<?= isset($errores['correo']) ? $errores['correo'] : "Correo" ?>" class="input-48  <?= isset($errores['correo']) ? 'error' : '' ?>" value="<?php $validator->persistirDato('correo') ?>">

		        <input type="text" name="usuario" placeholder="<?= isset($errores['usuario']) ? $errores['usuario'] : "Usuario" ?>" class="input-48 <?= isset($errores['usuario']) ? 'error' : '' ?>" value="<?php $validator->persistirDato('usuario') ?>">

		        <input type="password" name="clave" placeholder="<?= isset($errores['clave']) ? $errores['clave'] : "Ingresá una contraseña" ?>" class="input-48 <?= isset($errores['clave']) ? 'error' : '' ?>">

		        <input type="password" name="rclave" placeholder="<?= isset($errores['clave']) ? $errores['clave'] : "Repetí tu contraseña" ?>" class="input-48 <?= isset($errores['clave']) ? 'error' : '' ?>">

		        <input type="tel" name="telefono" placeholder="<?= isset($errores['telefono']) ? $errores['telefono'] : "Teléfono de contacto" ?>" class="input-48 <?= isset($errores['telefono']) ? 'error' : '' ?>" value="<?php $validator->persistirDato('telefono') ?>">

						<input class="input-48 <?= isset($errores['avatar']) ? 'error' : '' ?>" type="file" name="avatar">
									<span class="error-avatar" style="<?= !isset($errores['avatar']) ? 'display: none;' : '' ; ?>">
										<?= isset($errores['avatar']) ? $errores['avatar'] : '' ;?>
									</span>
						<input type="submit" value="Registrar" class="btn-enviar">

		        <p class="form-link">¿Ya tienes una cuenta?<a href="ingresar.php">Ingresa aquí</a></p>
	    </div>

    </form>
    <a name="Ayuda" id="a"></a>
    <section class="preguntas-frecuentes">
      <div class="wrap">
      <h2 class="FAQS">Preguntas frecuentes</h2>
      <details>
        <summary>¿Qué información puedo obtener en esta web?</summary>
        <p>En nuestra web podrás:
          <ul class="listaFAQ">
            <li><strong>Localizar las farmacias de turno más cercanas</strong> a tu domicilio.</li>
            <li>Obtener ubicación, teléfono y otros <strong>datos útiles de las farmacias que buscas</strong>.</li>
            <li><strong>Compartir por redes sociales o Whatsapp</strong> la información que buscaste.</li>
            <li><strong>Guardar las farmacias que buscaste</strong> para obtener rápidamente su información desde tu perfil. También vas a poder marcarlas como "Visitada".</li>
            <li><strong>Hacer tu propia valoración de la farmacia que visitaste</strong> y ver cómo la puntúan otros usuarios.</li>
            <li>Subscribirte a nuestro newsletter y <strong>recibir ofertas especiales de farmacias de tu zona</strong>.</li>
            <li>Consultar <strong>información de entidades sanitarias</strong>.</li>
          </ul></p>
      </details>
      <details>
         <summary>¿Cómo localizo la farmacia de turno más cercana a mi domicilio?</summary>
         <p>Ingresá a nuestra web<a href="https://www.farmaciasdeturno.com/">Farmacias de Turno.</a><br>Aplicá los prefiltros necesarios, podrás buscar por nombre de farmacia y/o zona.</p>
      </details>
      <details>
         <summary>¿Cómo puntúo una farmacia?</summary>
         <p>Antes que nada <a href="https://www.farmaciasdeturno.com/login.html">iniciá sesión o registrate.</a>Sólo los usuarios registrados podrán puntuar una farmacia.
           Para poder valorar una farmacia tendrás que previamente buscarla y marcarla como "VISITADA", luego podrás valorarla con una puntuación de 1 a 5 estrellas y si querés, agregar un comentario sobre tu experiencia.</p>
      </details>
      <details>
         <summary>¿Cómo puedo acceder fácilmente a descuentos y ofertas de farmacias cercanas?</summary>
         <p>¡Muy fácil! Subscribite a nuestro<a href="https://www.farmaciasdeturno.com/login.html">newsletter</a>y vas a estar recibiendo ofertas y descuentos en tu zona ¡Especiales para vos ♥!</p>
      </details>
    <div class="image-bottom">
        <h3>¿Dudas, quejas, recomendaciones?<br> Contactanos a través de nuestro formulario.</h3>
    </div>
    </div>
    </section>

    <footer>
      <section class="links">
        <a href="./perfil.php">Inicio</a>
        <a href="#Ayuda">Ayuda</a>
        <a href="#">Descuentos</a>
        <a href="#">Quiénes somos</a>
        <a href="./ingresar.php">Iniciar sesión</a>
      </section>
      <div class="social">
        <a href="#"><i class="ion-social-facebook-outline"></i></a>
        <a href="#"><i class="social ion-social-twitter-outline"></i></a>
        <a href="#"><i class="social ion-social-instagram-outline"></i></a>
        <a href="#"><i class="social ion-social-linkedin-outline"></i></a>
        <a href="#"><i class="social ion-social-youtube-outline"></i></a>
      </div>
      <section class="links">
        <p>farmaciasdeturno TM Copyright © 2018 All rights reserved to farmaciasdeturno.com.</p>
      </section>
    </footer>
  </div>
  </body>
</html>
