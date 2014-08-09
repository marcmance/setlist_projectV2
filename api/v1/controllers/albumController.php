<?php

	class albumController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function index() {
			return json_encode($this->model->order("artist_name",true)->findAll());
		}

		public function post() {

			$json = json_decode(file_get_contents('php://input'));
			
			$this->model = new $this->model_name();
			$sucesss = $this->model->setModelFields($json);

			if($sucesss) {
				echo json_encode($this->model);
			}
			else {
				$results['error_message'] = "Wrong fields";
			}
			
			//echo json_encode($results);
		}
	}
?>