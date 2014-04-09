<?php
	class User extends Model {
	
		public function __construct() {
			$this->fields_array = array(
				"user_id",
				"user_first_name",
				"user_last_name",
				"user_type",
				"user_email",
				"username"
			);
			$this->privateFields = array(
				"salt",
				"password",
				"remember_token"
			);
			parent::__construct();	
		}
	}
?>