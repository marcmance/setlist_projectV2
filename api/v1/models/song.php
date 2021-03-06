<?php
	class Song extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"song_id" => "private", 
				"song_name" => "public,required",
				"tracking" => "public,required",
				"bonus" => "public",
				"album_id" => "foreign_key,required",
				"artist_id" => "foreign_key,required",
				"created_date" => "private",
				"updated_date" => "private"
			);
			parent::__construct();	
		}
	}
?>