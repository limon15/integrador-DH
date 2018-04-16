<?php
	require_once('funciones.php');

	if (!estaLogueado()) {
		header('location: ingresar.php');
		exit;
	}

	$usuario = traerPorId($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <title>Perfil</title>
  </head>
  <body>
		<div class="container">
      <header>
    		<div class="logo">
    			<img src="images/logo-farmacia.png" width="150" alt="">
    		    <a href="#">FARMACIAS DE TURNO</a>
    		</div>
    		<nav>
    			<a href="./perfil.php">Inicio</a>
    			<a href="#Ayuda">Ayuda</a>
    			<a href="#">Descuentos</a>
    	    <a href="#">Quiénes somos</a>
          <a href="./logout.php">CERRAR SESION</a>
    		</nav>
    	</header>
			<div class="bienvenida">
	      <h2 class="bienvenida-titulo">¡Bienvenido/a <?=$usuario['name']?>!</h2>
	        <p class="bienvenida-parrafo">Ahora podés buscar la farmacia de turno más cercana a tu ubicación.
	        <br>Recordá dejar una valoración de la farmacia para futuros visitantes. Esperamos que disfrutes de la página ☺</p>
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
        <a href="./logout.php">CERRAR SESION</a>
			</section>
			<div class="social">
				<a href="#"><i class="ion-social-facebook-outline"></i></a>
				<a href="#"><i class="social ion-social-twitter-outline"></i></a>
			</div>
		</footer>
  </div>
  </body>
</html>
