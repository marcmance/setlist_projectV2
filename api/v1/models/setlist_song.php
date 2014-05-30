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
				"updated_date"
			);

			parent::__construct();							
		}

		//Get song counts for a particular artist
		public function getSongCounts($artist_id) {
			$query = "SELECT count(song.song_name) as song_count, song.song_name
						FROM setlist_song
						JOIN song
						ON song.song_id = setlist_song.song_id
						JOIN setlist
						ON setlist.setlist_id = setlist_song.setlist_id
						WHERE setlist.artist_id = ?
						GROUP BY song.song_name
						ORDER BY song_count desc";
			$params = array($artist_id);
			return $this->query($query, $params);
		}
	}
?>