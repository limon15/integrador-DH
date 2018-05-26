<?php

	class Validator {
		public function validateRegister(DB $db, $archivo) {
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
				$errores['name'] = "Completa tu nombre";
			}

			if ($apellidos == '') {
				$errores['apellidos'] = "Completa tu apellido";
			}

			if ($correo == '') { // Si el email está vacio
				$errores['correo'] = "Completa tu email";
			} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
				// Si el email no es un formato valido
				$errores['correo'] = "Por favor poner un email de verdad, gatx.";
			} elseif ($db->existeEmail($correo)) { // Si el email ya está registrado vacio
				$errores['correo'] = "Este email ya existe.";
			}

			if ($usuario == '') {
				$errores['usuario'] = "Completá tu usuario";
			}

			if ($telefono == '') {
				$errores['telefono'] = "Completá tu teléfono";
			}

			if ($clave == '' || $rclave == '') { // Si la contraseña o repetir contraseña está(n) vacio(s)
				$errores['clave'] = "Por favor completa tus passwords";
			} elseif ($clave != $rclave) {
				$errores['clave'] = "Tus contraseñas no coinciden";
			}

			if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) { // Si no subieron ninguna imagen
				$errores['avatar'] = "Che subí una foto";
			} else {
				$ext = strtolower(pathinfo($_FILES[$archivo]['name'], PATHINFO_EXTENSION));

				if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
					$errores['avatar'] = "Formatos admitidos: JPG o PNG";
				}

			}

			return $errores;
		}

		public function persistirDato($input){
			if (isset($_POST[$input])) { // Si envían algo por $_POST
				return $_POST[$input];
			}
		}

		public function validarLogin(DB $db) {
			$arrayADevolver = [];
			$correo = trim($_POST['correo']);
			$clave = trim($_POST['clave']);

			if ($correo == '') {
				$arrayADevolver['correo'] = 'Completá tu email';
			} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
				$arrayADevolver['correo'] = 'Poné un formato de email válido';
			} elseif (!$usuario = $db->existeEmail($correo)) {
				$arrayADevolver['correo'] = 'Este email no está registrado';
			} else {
				// Pregunto si coindice la password escrita con la guardada en el JSON
				if (!password_verify($clave, $usuario->getPassword())) {
	         	$arrayADevolver['clave'] = "Credenciales incorrectas";
	         }
	      }

			return $arrayADevolver;
		}
	}
