<?php
require_once('db.php');

class dbJSON extends DB {
  private $archive;

  public function __construct() {
    $this->archive = 'usuarios.json';
  }

  public function existeEmail($correo){
  		// Traigo todos los usuarios
  		$todos = $this->traerTodos();

  		// Recorro ese array
  		foreach ($todos as $unUsuario) {
  			// Si el mail del usuario en el array es igual al que me llegó por POST, devuelvo al usuario
  			if ($unUsuario->getCorreo() == $correo) {
  				return $unUsuario;
  			}
  		}
  		return false;
  	}
  public function traerTodos(){

  		// Traigo la data de todos los usuarios de 'usuarios.json'
  		$todosJson = file_get_contents($this->archive);

  		// Esto me arma un array con todos los usuarios
  		$usuariosArray = explode(PHP_EOL, $todosJson);

  		// Saco el último elemento que es una línea vacia
  		array_pop($usuariosArray);

  		// Creo un array vacio, para guardar los usuarios
  		$usuarios = [];

  		// Recorremos el array y generamos por cada usuario un array del usuario
  		foreach ($usuariosArray as $usuario) {
  			$usuarioJSON = json_decode($usuario, true);
        $usuario = new Usuario($usuarioJSON['name'],$usuarioJSON['apellidos'], $usuarioJSON['correo'], $usuarioJSON['usuario'], $usuarioJSON['telefono'], $usuarioJSON['clave'], $usuarioJSON['foto']);
        $usuario->setID($usuarioJSON['id']);
        $usuarios[] =$usuario;
  		}

  		return $usuarios;
  	}
  //hintear es una buena práctica en php, sobre todo cuando trabajamos con clases;
  public function guardarUsuario(Usuario $usuario, DB $db){

    $user = $usuario->crearUsuario($db);

    $usuarioJSON = json_encode($user);

    // Inserta el objeto JSON en nuestro archivo de usuarios
    file_put_contents($this->archive, $usuarioJSON . PHP_EOL, FILE_APPEND);

    // Devuelvo al usuario para poder auto loguearlo después del registro
    return $usuario;
  }

  function traerUltimoID(){
    // me traigo todos los usuarios
    $usuarios = $this->traerTodos();

    if (count($usuarios) == 0) {
      return 1;
    }

    // En caso de que haya usuarios agarro el ultimo usuario
    $elUltimo = array_pop($usuarios);

    // Pregunto por le ID de ese ultimo usuario
    $id = $elUltimo->getId();

    // A ese ID le sumo 1, para asignarle el nuevo ID al usuario que se esta registrando
    return $id + 1;
  }


}
 ?>
