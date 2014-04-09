<?php
	class Controller {
		protected $model_name;
		protected $model;

		public function __construct() {
			$class = get_class($this);
			$pos = strpos($class, 'Controller');
			$this->model_name = ucfirst(substr($class, 0, $pos));
			$this->model = new $this->model_name();
		}

		//Ex. /user/193
		public function get($id) {
			return json_encode($this->model->find($id));
		}

		//Ex. /user/
		public function index() {
			return json_encode($this->model->order("artist_name",true)->findAll());
		}

		public function post() {
			
			/*
			$object = new stdClass();
			$object->property = 'Here we go, from controllers now';
			$object->name = 'Marc';
			$object->method = "Posting and toasting";*/
			//echo json_encode($object);
		}

		public function put() {
			//query DB
		}

		public function delete() {
			//query DB
		}
	}
?>