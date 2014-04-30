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
		public function getSetlistSongs() {
			$ss = new Setlist_Song();
			$this->setlist_songs = $ss->join("song", array("song_id","song_name"))
				->join("album",array("album_id","album_name","cover_art_url"))
				->where("setlist_id",$this->setlist_id)
				->order("setlist_order", true)
				->findAll();

			$this->getFirstTimeSetlistSongs();
			return $this->setlist_songs;
		}

		//gets all setlist artists for a user
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

		//gets all first time setlist songs
		public function getFirstTimeSetlistSongs() {
			
			if(!empty($this->setlist_songs)) {

				//get all the song ids for this setlist, put them into an array
				$song_ids = array();
				foreach($this->setlist_songs as $ss) {
					$song_ids[$ss['song_id']] = $ss['song_id'];
				}

				$song_id_comma = implode(",", $song_ids);

				$query = "SELECT DISTINCT(setlist_song.song_id)
						FROM setlist_song
						JOIN setlist
						ON setlist.setlist_id = setlist_song.setlist_id
						JOIN song
						ON song.song_id = setlist_song.song_id
						WHERE setlist.setlist_id != ? AND setlist.date < ? AND song.song_id in (".$song_id_comma.")";

				$params = array($this->setlist_id, $this->date);
				$result = $this->query($query, $params);

				//extract ID's from query results
				$result_song_ids = array();
				foreach($result as $r) {
					$result_song_ids[] = $r['song_id'];
				}

				//get differences 
				$song_id_diff = array_diff($song_ids, $result_song_ids);

				//add boolean to songs array if new song
				foreach ($this->setlist_songs as &$v) {
					if(array_key_exists($v['song_id'], $song_id_diff)) {
						$v['new_song'] = true;
					}
				}

				return $song_id_diff;
			}
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