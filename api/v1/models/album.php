<?php
	class Album extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"album_id" => "private", 
				"album_name" => "public",
				"artist_id" => "foreign_key",
				"year" => "public",
				"cover_art_url" => "public",
				"created_date" => "private",
				"updated_date" => "private"
			);
			parent::__construct();	
		}
	}
?>