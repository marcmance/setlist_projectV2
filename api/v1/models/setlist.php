<?php
	class Setlist extends Model {
	
		public function __construct() {
			$this->fields_array = array(
				"artist_id", 
				"date",
				"headline",
				"setlist_id",
				"venue_id",
				"created_date",
				"updated_date",
				"user_id");
			parent::__construct();	
		}

		public function getAllSetlistArtists($user_id, $name = false) {
			$user_id = intval($user_id);
			$orderBy = "artist_count DESC";
			if($name) {
				$orderBy = "artist.artist_name";
			}

			$query = "SELECT COUNT(artist.artist_id) as artist_count, artist.artist_name, artist.artist_id
					FROM setlist
					JOIN artist
					ON artist.artist_id = setlist.artist_id
					GROUP BY artist.artist_name
					ORDER BY " . $orderBy;


			return $this->query($query, null);
		}
	}
?>