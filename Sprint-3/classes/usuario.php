<?php

	class Usuario {
		private $id;
		private $name;
		private $apellidos;
		private $correo;
		private $usuario;
		private $telefono;
		private $clave;
		private $avatar;

		// $name = '';
		// $apellidos = '';
		// $correo = '';
		// $usuario = '';
		// $telefono = '';
		// $clave = '';
		// $rclave = '';

		public function __construct ($name, $apellidos, $correo, $usuario, $telefono, $clave, $avatar) {
			$this->name = $name;
			$this->apellidos = $apellidos;
			$this->correo = $correo;
			$this->usuario = $usuario;
			$this->telefono = $telefono;
			$this->clave = $clave;
			$this->avatar = $avatar;
		}

		public function crearUsuario(DB $db) {
			return [
				'id' => $db->traerUltimoID(),
				'name' => $this->name,
				'apellidos' => $this->apellidos,
				'correo' => $this->correo,
				'usuario' => $this->usuario,
				'telefono' => $this->telefono,
				'clave' => $this->setPassword($this->clave),
				'avatar' => $this->avatar
			];

		   // return $usuario;
		}

		public function setname($name) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getEmail() {
			return $this->correo;
		}

		public function setEmail($correo) {
			$this->correo = $correo;
		}

		public function getPassword() {
			return $this->clave;
		}

		public function setPassword($clave) {
			return password_hash($clave, PASSWORD_DEFAULT);
		}

		public function getPicture() {
			return $this->avatar;
		}
	}
