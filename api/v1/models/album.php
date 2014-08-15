<?php
	class Album extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"album_id" => "private", 
				"album_name" => "public,required",
				"artist_id" => "foreign_key",
				"year" => "public,required",
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
						if(in_array($k, $this->fields_required)) {
							$this->required_fields_count++;
						}
					}
					else {
						return $this->messages["invalid"];
					}
				}

				if($this->required_fields_count === count($this->fields_required)) {
					return $this->messages["success"];
				}
				else {
					return $this->messages["required"];
				}
			}
			return false;
		}

		public function insert() {
			$this->album_id = parent::insert();
			return $this->album_id;
			//next: model insert many
		}
	}
?>