<?php

	require_once 'classes/dbJSON.php';
	$dbJSON = new dbJSON();

	if(isset($_POST['crearDB'])){
		$dsn = 'mysql:host=localhost';
		$db_username = 'root';
		$db_password = '';

		try {
			$conn = new PDO($dsn, $db_username, $db_password);
			if ($conn) {
				$sql = "CREATE SCHEMA `FarmaciaDB`";
				$query = $conn->prepare($sql);
				$query->execute();
				$message = "<p>¡Se creo la DB!</p>";
			}
			else {
				$message = "<p>No se pudo crear la DB</p>";
			}
			}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	if (isset($_POST['crearTable'])) {
		$dsn = 'mysql:host=localhost;dbname=FarmaciaDB;';
		$db_username = 'root';
		$db_password = '';

		try {
			$conn = new PDO($dsn, $db_username, $db_password);
			if ($conn) {
				$sql =
				'CREATE TABLE `FarmaciaDB`.`users` (
				  `id` INT NOT NULL AUTO_INCREMENT,
				  `name` VARCHAR(40) NOT NULL,
				  `last_name` VARCHAR(40) NOT NULL,
					`email` VARCHAR(40) NOT NULL,
					`user` VARCHAR(40) NOT NULL,
					`phone` INT(40) NOT NULL,
					`pass` VARCHAR(100) NOT NULL,
					`avatar` VARCHAR(100) NOT NULL,
				  PRIMARY KEY (`id`)); ';

				$query = $conn->prepare($sql);
				$query->execute();
				$message = "<p>¡Tabla creada exitosamente!</p>";
			}
			else {
				$message = "<p>No se pudo crear la Tabla</p>";
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}


	if (isset($_POST['migrarDatos'])) {
		$dsn = 'mysql:host=localhost;dbname=FarmaciaDB';
		$db_username = 'root';
		$db_password = '';

		try {
			$conn = new PDO($dsn, $db_username, $db_password);
			if ($conn) {

				$usuarios = $dbJSON->traerTodos();

				// echo "<pre>";
				// var_dump($usuarios); exit;

				foreach ($usuarios as $unUsuario) {
					$sql = "INSERT INTO users(name, last_name, email, user, phone, pass, avatar)
					VALUES (:name, :last_name, :email, :user, :phone, :pass, :avatar)";
					$stmt= $conn->prepare($sql);
					$stmt->bindValue(":name", $unUsuario->getName());
					$stmt->bindValue(":last_name", $unUsuario->getLastName());
					$stmt->bindValue(":email", $unUsuario->getEmail());
					$stmt->bindValue(":user", $unUsuario->getUser());
					$stmt->bindValue(":phone", $unUsuario->getPhone());
					$stmt->bindValue(":pass", $unUsuario->getPassword());
					$stmt->bindValue(":avatar", $unUsuario->getPicture());
					$stmt->execute();
				}
				$message = "<p>¡Datos migrados exitosamente!</p>";
			}
			else {
				$message = "<p>No se lograron migrar los datos</p>";
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}


	function hayConexion(){
	$dsn = 'mysql:host=localhost;dbname=FarmaciaDB;';
	$db_username = 'root';
	$db_password = '';

	try {
		$conn = new PDO($dsn, $db_username, $db_password);
		return True;
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	}

	function consultaDB(){
		$dsn = 'mysql:host=localhost;dbname=FarmaciaDB';
		$db_username = 'root';
		$db_password = '';
		$conn = new PDO($dsn, $db_username, $db_password);

		$query = $conn->query("SELECT * FROM users");

		return $query;
	}
