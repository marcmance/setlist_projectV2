<?php

	class setlistController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get($id) {

			//query for Setlist by Id
			$results = $this->model->join("venue", array("venue_name", "city", "state"))
				->join("artist", array("artist_name"))
				->find($id);
			
			if(!empty($results)) {
				//query all songs for Setlist
				$results['songs'] =  $this->model->getSetlistSongs($id);
				$results['album_count'] = $this->model->getSongsOnAlbumCount();
			}

			//printArray($results);
			return json_encode($results);
		}
	}
?>