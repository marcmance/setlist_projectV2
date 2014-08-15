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

			if($sucesss === "SUCCESS") {
				if($this->model->verifyForeignKey("artist_id", $this->model->artist_id)) {
					//$results = $this->model;
					$results = $this->model->insert();
				}
				else {
					$results['error_message'] = "Invalid artist id.";
				}
			}
			else if($sucesss === "INVALID_FIELDS") {
				$results['error'] = "Invalid fields";
			}
			else if($sucesss === "REQUIRED_FIELDS") {
				$results['error'] = "Missing required fields";
			}
			
			echo json_encode($results);
		}
	}
?>