<?php
	require_once 'usuario.php';

	abstract class DB {
		public abstract function existeEmail($correo);
		public abstract function traerTodos();
		public abstract function guardarUsuario(Usuario $usuario, DB $db);
	}
