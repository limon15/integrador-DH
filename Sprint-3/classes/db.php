<?php

require_once("usuario.php");

abstract class DB {
  public abstract function existeEmail($correo);
  public abstract function traerTodos();
  //hintear es una buena práctica en php, sobre todo cuando trabajamos con clases;
  public abstract function guardarUsuario(Usuario $usuario, DB $db);

}

 ?>
