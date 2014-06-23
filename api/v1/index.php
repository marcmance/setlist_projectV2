<?php
	require_once("shared/connection.php");
	require_once("shared/helper.php");
	require_once("shared/router.php");

	$route = $_GET['p'];
	$method = $_SERVER['REQUEST_METHOD'];

	$router = Router::getInstance($route, $method);
	$router->checkRoute();

	function __autoload($className) {
		//autoload controller
		if(file_exists("controllers/". $className . ".php")) {
			require_once "controllers/". $className . ".php";
		}
		//autoload model
		if(file_exists("models/". $className . ".php")) {
			require_once "models/". $className . ".php";
		}
	}
?>