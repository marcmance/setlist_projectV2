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
			return json_encode($this->model->findAll());
		}

		public function post() {

			$json = json_decode(file_get_contents('php://input'));
			
			$this->model = new $this->model_name();
			$sucesss = $this->model->setModelFields($json);

			if($sucesss) {
				$results['id'] = $this->model->insert();
			}
			else {
				$results['error'] = "Wrong fields";
			}
			
			echo json_encode($results);
		}

		public function put() {
			//query DB
		}

		public function delete() {
			//query DB
		}
	}
?>