<?php
	class Album extends Model {
	
		public function __construct() {
			$this->fields_array_settings = array(
				"album_id" => "private", 
				"album_name" => "public,required",
				"artist_id" => "foreign_key,required",
				"year" => "public,required",
				"cover_art_url" => "public,required",
				"created_date" => "private",
				"updated_date" => "private"
			);
			parent::__construct();	
		}

		public function setModelFields($fields) {
			if(gettype($fields) === "object") {
				foreach ($fields as $k => $v) {
					if(in_array($k, $this->fields_array)) {
						$this->{$k} = $v;
						if(in_array($k, $this->fields_required)) {
							$this->required_fields_count++;
						}
					}
					//set child field
					else if($k === 'songs') {
						$this->songs = array();
						foreach($v as $songs_json) {
							$song = new Song(false);
							$success = $song->setModelFields($songs_json);
							if($success === 'SUCCESS') {
								array_push($this->songs,$song);
							}
							else {
								$this->error_details = $song->error_details;
								return $this->messages["invalid_child"];
							}
						}
					}
					else {
						$this->error_details = "Invalid field: " . $k;
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

			if(!empty($this->songs)) {
				$this->album_id = parent::insert();
				//echo json_encode($this->songs);
				foreach($this->songs as $s) {

					//$song = new Song(true);
					$s->album_id = $this->album_id;
					$s->insert();
					//echo json_encode($song);
				}
				
				//return $this->album_id;
				return $this->messages["success"];
				//next: model insert many
			}
			else {
				return $this->messages["required_child"];
			}
		}
	}
?>