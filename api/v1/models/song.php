<?php
	class Song extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"song_id" => "private", 
				"song_name" => "public",
				"tracking" => "public",
				"bonus" => "public",
				"album_id" => "foreign_key",
				"artist_id" => "foreign_key",
				"created_date" => "private",
				"updated_date" => "private"
			);
			parent::__construct();	
		}
	}
?>