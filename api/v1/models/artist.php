<?php
	class Artist extends Model {
	
		public function __construct() {
			$this->fields_array = array(
				"artist_id", 
				"artist_name",
				"created_date",
				"updated_date"
			);
			parent::__construct();	
		}
	}
?>