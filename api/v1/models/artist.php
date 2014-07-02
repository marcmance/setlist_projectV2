<?php
	class Artist extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"artist_id" => "private", 
				"artist_name" => "public",
				"created_date" => "private",
				"updated_date" => "private"
			);
			parent::__construct();	
		}
	}
?>