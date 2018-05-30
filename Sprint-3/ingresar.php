<?php
	require_once('soporte.php');
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

	// Variables para persistencia
	$correo = '';

	// Array de errores vacío
	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {
		$correo = trim($_POST['correo']);

		$errores = $validator->validarLogin($db);

		if (empty($errores)) {
			$usuario = $db->existeEmail($correo);

			$auth->loguear($usuario->getId());

			// Seteo la cookie
			if (isset($_POST["rememberusername"])) {
	        setcookie('id', $usuario['id'], time() + 3600 * 24 * 30);
	      }

			header('location: perfil.php');
			exit;
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
    <title>Iniciar sesión</title>
  </head>
  <body>
    <div class="container">
      <header>
    		<div class="logo">
    			<img src="images/logo-farmacia.png" width="150" alt="">
    		    <a href="#">FARMACIAS DE TURNO</a>
    		</div>
    		<nav>
    			<a href="./ingresar.php">Inicio</a>
    			<a href="#Ayuda">Ayuda</a>
    			<a href="#">Descuentos</a>
    	    <a href="#">Quiénes somos</a>
          <a href="./ingresar.php">Iniciar sesión</a>
    		</nav>
    	</header>

    <form method="post" class="form-registrar" enctype="multipart/form-data">
      <h2 class="form-titulo">INICIAR SESIÓN</h2>
      <div class="contenedor-inputs">
				<div class="formu-control">
					<input type="email" name="correo" placeholder="Ingresá tus email" class="<?= isset($errores['email']) ? 'input-error' : NULL ?>" value="<?= $validator->persistirDato('correo') ?>">
					<span class="error-text" style="<?= isset($errores['correo']) ? 'display: block;' : NULL ?>"><?= isset($errores['correo']) ? $errores['correo'] : NULL ?></span>
				</div>
				<div class="formu-control">
					<input type="password" name="clave" placeholder="Insertá una contraseña" class="<?= isset($errores['clave']) ? 'input-error' : NULL ?>" value="<?php $validator->persistirDato('clave')?>">
					<span class="error-text" style="<?= isset($errores['clave']) ? 'display: block;' : NULL ?>"><?= isset($errores['clave']) ? $errores['clave'] : NULL ?></span>
				</div>
        <input type="submit" value="Ingresar" class="btn-enviar">

        <label for="rememberusername" class="input-100">
          <input type="checkbox" name="rememberusername" checked="checked">
          Recordar nombre de usuario
        </label>
        <p class="form-link">¿No tienes una cuenta?<a href="index.php">Regístrate</a></p>
      </form>
    </div>

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
