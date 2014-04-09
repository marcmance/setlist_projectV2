<?php

	class setlistController extends Controller {

	
		public function __construct() {
			parent::__construct();
		}

		public function get($id) {
			return json_encode($this->model->join("venue", array("venue_name", "city", "state"))->find($id));
		}
	}
?>