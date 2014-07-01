<?php
	class Router {
		private static $_instance; //The single instance

		//define the routes HERE
		private $defined_routes = array(	
			"setlist" => array(
				"artists" => "",
			),
			"artist" => array(

			));

		private $current_route;
		private $requested_route;
		private $con;
		private $method;
		private $action;
	 
		public static function getInstance($route, $method) {
			if(!self::$_instance) { // If no instance then make one
				self::$_instance = new self($route, $method);
			}
			return self::$_instance;
		}
	 
		// Constructor
		private function __construct($route, $method) {
			$this->current_route = $route;
			$this->requested_route = explode("/",$route);	
			$this->method = $method;

			//set default actions
			switch ($this->method) {
			    case "GET":
			        $this->action = "index";
			        break;
			    case "PUT":
			        $this->action = "put";
			        break;
			    case "POST":
			        $this->action = "post";
			        break;
			    case "DELETE":
			        $this->action = "delete";
			        break;
			}

			$controller_name = $this->requested_route[0] . "Controller";
			$this->con = new $controller_name();
		}

		public function checkRoute() {
			$params = null;
			if($this->method === "GET" && isset($this->requested_route[1])) {
				
				//check if second param is an ID or controller action
				if(in_array($this->requested_route[1], get_class_methods($this->con))) {
					$this->action = $this->requested_route[1];
				}
				else {
					$this->action = "get";
					$params = $this->requested_route[1];
				}
			}

			echo call_user_func_array(array($this->con,$this->action),array($params));
		}

		public function getCurrentRoute() {
			return $this->current_route;
		}
	 
		//prevent duplication
		private function __clone() { }
	}
?>