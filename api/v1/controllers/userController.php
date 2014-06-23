<?php

	class userController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get($id) {
			$user = $this->model->find($id);
			$setlist = new Setlist();

			//to do, get another test method. 
			$userSetlists = $setlist->join("venue", array("venue_name", "city", "state"))->getAllSetlistArtists($user['user_id']);

			$user['artists'] = $userSetlists;
			//printArray($user);
			//printArray($userSetlists);
			return json_encode($user);
		}
	}
?>