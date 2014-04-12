<?php

	class setlistController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get($id) {

			//query for Setlist by Id
			$results = $this->model->join("venue", array("venue_name", "city", "state"))->join("artist", array("artist_name"))->find($id);
			
			if(!empty($results)) {
				
				$ss = new Setlist_Song();
			
				//query all songs for Setlist
				$results['songs'] = $ss->join("song", array("song_id","song_name"))
					->join("album",array("album_id","album_name","cover_art_url"))
					->where("setlist_id",$id)
					->order("setlist_order", true)
					->findAll();
			}

			//printArray($results);
			return json_encode($results);
		}
	}
?>