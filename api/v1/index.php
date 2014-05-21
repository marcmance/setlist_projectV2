<?php
	require_once("shared/connection.php");
	require_once("shared/helper.php");

	$route = $_GET['p'];
	$method = $_SERVER['REQUEST_METHOD'];

	$route_array = explode("/",$route);
	$controller_name = $route_array[0] . "Controller";
	$con = new $controller_name();

	if($method == 'GET' && !isset($route_array[1])) {
		echo $con->index();
	}
	else if($method == 'GET' && $route_array[1] != null) {
		if($route_array[1] == 'artists') {
			//make this dynamic at some point
			echo call_user_func(array($con,'artists'));
		}
		else {
			echo $con->get($route_array[1]);
		}
		
		
	}

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