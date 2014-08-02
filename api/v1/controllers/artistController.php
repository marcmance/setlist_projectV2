<?php

	class artistController extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get($id) {
			$artist = $this->model->find($id);
			return json_encode($artist);
		}

		public function index() {
			return json_encode($this->model->order("artist_name",true)->findAll());
		}

		public function post() {

			$json = json_decode(file_get_contents('php://input'));
			
			$this->model = new $this->model_name();
			$sucesss = $this->model->setModelFields($json);

			if($sucesss) {
				$this->checkModel = new $this->model_name();
				if($this->checkModel->where("artist_name", $this->model->artist_name)->findAll()) {
					header('HTTP/1.1 409 User Already Exists');
					$results['error_message'] = $this->model->artist_name . " aready exists in the system";
				}
				else {
					$results['id'] = $this->model->insert();
				}
			}
			else {
				$results['error_message'] = "Wrong fields";
			}
			
			echo json_encode($results);
		}

		/*
			/artist/setlists
			For getting all setlist information for a particular artist
		*/
		public function setlists($id) {
			$artist = $this->model->find($id);
			$setlist = new Setlist();
			$artist['setlists'] = $setlist->join("venue", array("venue_name", "city", "state"))
				->join("artist", array("artist_name","artist_id"))
				->where("artist_id",$id)
				->order("date")
				->findAll();

			$setlist_song = new setlist_song();
			$artist['songs'] = $setlist_song->getSongCounts($id);
			return json_encode($artist);	
		}
	}
?>