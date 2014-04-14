<?php
	class Setlist extends Model {

		public $setlist_songs;
	
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

			$setlist_songs = array();
			parent::__construct();	
		}

		//gets all setlist song for this setlist
		//TODO save record into model 
		public function getSetlistSongs($id) {
			$ss = new Setlist_Song();
			$this->setlist_songs = $ss->join("song", array("song_id","song_name"))
				->join("album",array("album_id","album_name","cover_art_url"))
				->where("setlist_id",$id)
				->order("setlist_order", true)
				->findAll();
			return $this->setlist_songs;
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

		//Takes setlist and counts the number of songs per album
		public function getSongsOnAlbumCount() {
			if(!empty($this->setlist_songs)) {
				$songs_on_albums_array = array();
				foreach($this->setlist_songs as $ss) {
					if(!array_key_exists($ss['album_id'], $songs_on_albums_array)) {
						$songs_on_albums_array[$ss['album_id']]["url"] = $ss['cover_art_url'];
						$songs_on_albums_array[$ss['album_id']]["name"] = $ss['album_name'];
						$songs_on_albums_array[$ss['album_id']]["count"] = 1;
					}
					else {
						$songs_on_albums_array[$ss['album_id']]["count"]++;
					}
				}
				return $songs_on_albums_array;
			}
		}
	}
?>