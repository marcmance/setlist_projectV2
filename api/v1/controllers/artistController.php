<?php

	class artistController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get($id) {
			$artist = $this->model->find($id);
			$setlist = new Setlist();
			$artist['setlists'] = $setlist->join("venue", array("venue_name", "city", "state"))
				->join("artist", array("artist_name","artist_id"))
				->where("artist_id",$id)
				->order("date")
				->findAll();

			$setlist_song = new setlist_song();
			$artist['songs'] = $setlist_song->getSongCounts($id);
			return json_encode($artist);
		}

		public function index() {
			return json_encode($this->model->order("artist_name",true)->findAll());
		}
	}
?>