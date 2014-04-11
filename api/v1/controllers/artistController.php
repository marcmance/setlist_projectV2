<?php

	class artistController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function index() {
			return json_encode($this->model->order("artist_name",true)->findAll());
		}
	}
?>