<?php

class Validator {
  public function validar(DB $db, $archivo) {
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
    } elseif ($db->existeEmail($correo)) { // Si el correo ya está registrado vacio
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
}
 ?>
