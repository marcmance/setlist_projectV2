<?php
	class Setlist_Song extends Model {
		public function __construct() {
			
			$this->fields_array_settings = array(
				"setlist_song_id" => "private",
				"song_id" => "public",
				"album_id" => "public",
				"closer" => "public",
				"opener" => "public",
				"encore" => "public",
				"notes" => "public",
				"setlist_id" => "public",
				"setlist_order" => "public",
				"created_date" => "public",
				"updated_date" => "public"
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