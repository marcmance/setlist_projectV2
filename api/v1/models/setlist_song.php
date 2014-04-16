<?php
	class Setlist_Song extends Model {
		public function __construct() {
			
			$this->fields_array = array(
				"setlist_song_id", 
				"song_id",
				"album_id",
				"closer",
				"opener",
				"encore",
				"notes",
				"setlist_id",
				"setlist_order",
				"created_date",
				"updated_date");

			parent::__construct();							
		}
		
	}
?>