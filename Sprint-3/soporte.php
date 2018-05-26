<?php
	require_once 'classes/auth.php';
	require_once 'classes/validate.php';
	require_once 'classes/dbJSON.php';

	$auth = new Auth();
	$validator = new Validator();

	if (isset($_POST['crearDB'])) {
		$typeDB = 'mysql';
	} else {
		$typeDB = 'json';
	}


	switch ($typeDB) {
		case 'json':
			$db = new dbJSON();
			break;
		case 'mysql':
			$db = new dbMYSQL();
			break;
		default:
			$db = NULL;
			break;
	}
