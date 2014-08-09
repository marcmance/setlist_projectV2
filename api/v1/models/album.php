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

		public function setModelFields($fields) {
			if(gettype($fields) === "object") {
				foreach ($fields as $k => $v) {
					if(in_array($k, $this->fields_array) || $k === 'songs') {
						$this->{$k} = $v;
					}
					else {
						return false;
					}
				}
				return true;
			}
			return false;
		}
	}
?>