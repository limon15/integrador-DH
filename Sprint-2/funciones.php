<?php

	session_start();

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
	}

	// == FUNCTION - crearUsuario ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de subir imagen
		- Con estos datos, genera un array nuevo
		- Usa la función traerUltimoID() para generar un ID para cada usuario
		- Retorna el array con el usuario final
	*/
	function crearUsuario($data, $imagen) {
		$usuario = [
			'id' => traerUltimoID(),
			'name' => $data['name'],
			'apellidos' => $data['apellidos'],
			'correo' => $data['correo'],
			'usuario' => $data['usuario'],
			'telefono' => $data['telefono'],
			'clave' => password_hash($data['clave'], PASSWORD_DEFAULT),
			'rclave' => password_hash($data['rclave'], PASSWORD_DEFAULT),
			'foto' => 'img/' . $data['correo'] . '.' . pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION)
		];

	   return $usuario;
	}



	// == FUNCTION - validar ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de subir imagen
		- Valida en el 1er submit que todos los campos son obligatorios
		- Usa la función existeEmail() para verificar que no haya registros con el mismo correo
		- Retorna un array de errores que puede estar vacio
	*/
	function validar($data, $archivo) {
		$errores = [];

		$name = trim($_POST['name']);
		$apellidos = trim($_POST['apellidos']);
		$correo = trim($_POST['correo']);
		$usuario = trim($_POST['usuario']);
		$telefono = trim($_POST['telefono']);
		$clave = trim($_POST['clave']);
		$rclave = trim($_POST['rclave']);


		// Valido cada campo del formulario y por cada error genero una posición en el array de errores ($errores) que inicialmente estaba vacío

		if ($name == '') { // Si el nombre está vacio
			$errores['name'] = "Completá tus nombres";
		}
		if ($apellidos == '') { // Si el apellido está vacio
			$errores['apellidos'] = "Completá tus apellidos";
		}
		if ($usuario == '') { // Si el usuario está vacio
			$errores['usuario'] = "Completá tu usuario";
		}
		if ($telefono == '') { // Si el teléfono está vacio
			$errores['telefono'] = "Completá tu teléfono";
		} elseif (!is_numeric($telefono)) {
			$errores['telefono'] = "El número de teléfono no debe contener letras"; //Si no es un número de teléfono
		}
		if ($correo == '') { // Si el correo está vacio
			$errores['correo'] = "Completá tu correo";
		} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			// Si el correo no es un formato valido
			$errores['correo'] = "Poné un correo real";
		} elseif (existeEmail($correo)) { // Si el correo ya está registrado vacio
			$errores['correo'] = "Este correo ya existe. Intentá ingresar desde la opcion INGRESA AQUI";
		}

		if ($clave == '' || $rclave == '') { // Si la contraseña o repetir contraseña está(n) vacio(s)
			$errores['clave'] = "Completá tus claves";
		} elseif (strlen($clave) < 7 || strlen($rclave) < 7) {
			$errores['clave'] = "La clave debe tener al menos 7 caracteres"; // Si la clave tiene menos de 7 caracteres
		} elseif ($clave != $rclave) {
			$errores['clave'] = "Tus contraseñas no coinciden"; // Si las claves no coinciden
		}

		if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) { // Si no subieron ninguna imagen
			$errores['avatar'] = "Subí una imagen";
		} else {
			$ext = strtolower(pathinfo($_FILES[$archivo]['name'], PATHINFO_EXTENSION));

			if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
				$errores['avatar'] = "El formato del archivo no es el admitido. Por favor subí una imagen con formato JPG o PNG";
			}

		}

		return $errores;
	}



	// == FUNCTION - traerTodos ==
	/*
		- NO recibe parámetros
		- Lee el JSON y arma un array de arrays de usuarios, cada línea en el JSON será un array de 1 usuario
		- Retorna el array con todos los usuarios
	*/
	function traerTodos() {
		// Traigo la data de todos los usuarios de 'usuarios.json'
		$todosJson = file_get_contents('usuarios.json');

		// Esto me arma un array con todos los usuarios
		$usuariosArray = explode(PHP_EOL, $todosJson);

		// Saco el último elemento que es una línea vacia
		array_pop($usuariosArray);

		// Creo un array vacio, para guardar los usuarios
		$todosPHP = [];

		// Recorremos el array y generamos por cada usuario un array del usuario
		foreach ($usuariosArray as $usuario) {
			$todosPHP[] = json_decode($usuario, true);
		}

		return $todosPHP;
	}



	// == FUNCTION - traerUltimoID ==
	/*
		- NO recibe parámetros
		- Usa la función traerTodos()
		- Retorna un número. En el 1er usuario registrado devuelve 1 y en los siguientes al ID actual le suma 1
	*/
	function traerUltimoID(){
		// me traigo todos los usuarios
		$usuarios = traerTodos();

		if (count($usuarios) == 0) {
			return 1;
		}

		// En caso de que haya usuarios agarro el ultimo usuario
		$elUltimo = array_pop($usuarios);

		// Pregunto por le ID de ese ultimo usuario
		$id = $elUltimo['id'];

		// A ese ID le sumo 1, para asignarle el nuevo ID al usuario que se esta registrando
		return $id + 1;
	}

	// == FUNCTION - existeEmail ==
	/*
		- Recibe un parámetro -> $_POST['correo']
		- Usa la función traerTodos()
		- Retorna un array del usuario si encuentra el correo. De no encontrarlo, retorna false
	*/
	function existeEmail($correo){
		// Traigo todos los usuarios
		$todos = traerTodos();

		// Recorro ese array
		foreach ($todos as $unUsuario) {
			// Si el mail del usuario en el array es igual al que me llegó por POST, devuelvo al usuario
			if ($unUsuario['correo'] == $correo) {
				return $unUsuario;
			}
		}

		return false;
	}



	// == FUNCTION - guardarImagen ==
	/*
		- Recibe un parámetro -> el nombre del campo de la imagen
		- Se encarga de guardar el archivo de imagen en la ruta definida
		- Retorna un array de errores si los hay
	*/
	function guardarImagen($laImagen){
		$errores = [];

		if ($_FILES[$laImagen]['error'] == UPLOAD_ERR_OK) {
			// Capturo el nombre de la imagen, para obtener la extensión
			$nombreArchivo = $_FILES[$laImagen]['name'];
			// Obtengo la extensión de la imagen
			$ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
			var_dump($ext);
			// Capturo el archivo temporal
			$archivoFisico = $_FILES[$laImagen]['tmp_name'];

			// Pregunto si la extensión es la deseada
			if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
				// Armo la ruta donde queda gurdada la imagen
				$dondeEstoyParado = dirname(__FILE__);

				$rutaFinalConNombre = $dondeEstoyParado . '/img/' . $_POST['correo'] . '.' . $ext;

				// Subo la imagen definitivamente
				move_uploaded_file($archivoFisico, $rutaFinalConNombre);
			} else {
				$errores['imagen'] = 'El formato tiene que ser JPG, JPEG, PNG';
			}
		} else {
			// Genero error si no se puede subir
			$errores['imagen'] = 'No subiste nada';
		}

		return $errores;
	}




	// == FUNCTION - guardarUsuario ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de la imagen
		- Usa la función crearUsuario()
		- Su función principal es guardar al usuario
		- Retorna el usuario para poder auto-loguear después del registro
	*/
	function guardarUsuario($data, $imagen){

		$usuario = crearUsuario($data, $imagen);

		$usuarioJSON = json_encode($usuario);

		// Inserta el objeto JSON en nuestro archivo de usuarios
		file_put_contents('usuarios.json', $usuarioJSON . PHP_EOL, FILE_APPEND);

		// Devuelvo al usuario para poder auto loguearlo después del registro
		return $usuario;
	}



	// == FUNCTION - validarLogin ==
	/*
		- Recibe un parámetro -> $_POST
		- Usa la función existeEmail()
		- Retorna un array de errores que puede estar vacio
	*/
	function validarLogin($data) {
		$arrayADevolver = [];
		$correo = trim($data['correo']);
		$clave = trim($data['clave']);

		if ($correo == '') {
			$arrayADevolver['correo'] = 'Completá tu correo';
		} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			$arrayADevolver['correo'] = 'Poné un formato de correo válido';
		} elseif (!$usuario = existeEmail($correo)) {
			$arrayADevolver['correo'] = 'Este correo no está registrado';
		} else {
			// Si el mail existe, me guardo al usuario dueño del mismo
			// $usuario = existeEmail($correo);

 			// Pregunto si coindice la password escrita con la guardada en el JSON
      	if (!password_verify($clave, $usuario["clave"])) {
         	$arrayADevolver['clave'] = "Credenciales incorrectas";
      	}
		}

		return $arrayADevolver;
	}



	// FUNCTION - loguear
	/*
		- Recibe un parámetro -> el usuario
		- Guarda en sesión el ID del usuario que recibe
		- Redirecciona a perfil.php
	*/
	function loguear($usuario) {
		// Guardo en $_SESSION el ID del USUARIO
	   $_SESSION['id'] = $usuario['id'];
		header('location: perfil.php');
		exit;
	}

	// FUNCTION - estaLogueado
	/*
		- No recibe parámetros
		- Pregunta si está guardado en SESIÓN el ID del $usuarios
	*/
	function estaLogueado() {
		return isset($_SESSION['id']);
	}




	// == FUNCTION - traerId ==
	/*
		- Recibe un parámetro -> $id:
		- Devuelve el usuario si encuentra a alguno con ese ID
		- Devuelve false si no hay usuarios con ese ID
	*/
	function traerPorId($id){
		// me traigo todos los usuarios
		$todos = traerTodos();

		// Recorro el array de todos los usuarios
		foreach ($todos as $usuario) {
			if ($id == $usuario['id']) {
				return $usuario;
			}
		}

		return false;
	}

	function persistirDato($data){
		if (isset($data)) { // Si envían algo por $_POST
			echo $data;
		}
	}
