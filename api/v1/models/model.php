<?php
	require_once('/shared/connection.php');

	class Model {
		protected $mysqli;
		protected $table_name;
		protected $fields_array;
		protected $fields_array_settings;
		protected $fields_required;
		protected $fields_foreign;
		protected $required_fields_count;
		
		protected $join_array;
		protected $where_array;
		protected $order_statement;

		protected $messages; //messages to send
		public $error_details;

		public function __construct($open_connection = true) {

			if($open_connection) {
				$this->mysqli = new mysqli(HOST_DB, USERNAME_DB, PASSWORD_DB, NAME_DB);
			}
			
			$this->table_name = strtolower(get_class($this));
			$this->join_array = array();
			$this->fields_array = array_keys($this->fields_array_settings);

			$this->fields_required = array();
			$this->fields_foreign = array();

			//setup the required fields array
			foreach ($this->fields_array as $f) {
				$field_settings = explode(",",$this->fields_array_settings[$f]);
				if(in_array("required", $field_settings)) {
					array_push($this->fields_required,$f);
				}
				if(in_array("foreign_key", $field_settings)) {
					array_push($this->fields_foreign,$f);
				}
			}

			$this->required_fields_count = 0;

			//set error messages
			$this->messages = array(
				"invalid" => "INVALID_FIELDS",
				"required" => "REQUIRED_FIELDS",
				"required_child" => "REQUIRED_CHILD_FIELDS",
				"invalid_child" => "INVALID_CHILD_FIELDS",
 				"success" => "SUCCESS"
			);

			$this->error_details = '';
		}


		/**
		 * Find a single record.
		 *
		 * @param string $id
		 *
		 * @return query result
		 */
		public function find($id, $select_fields = null) {
			$new_join_array = $this->buildJoinStatement();

			$query = "SELECT " . $this->buildSelectFields($select_fields, $new_join_array['select_fields']) . 
					" FROM ". $this->table_name . 
					" " . $new_join_array['join_statement'] . 
					" WHERE " . $this->table_name . "_id = ? LIMIT 1";

			$params = array($id);
			return $this->query($query, $params);
		}

		public function findAll($select_fields = null) {
			$new_join_array = $this->buildJoinStatement();
			$new_where_array = $this->buildWhereStatement();

			$query = "SELECT " . $this->buildSelectFields($select_fields, $new_join_array['select_fields']) . 
					" FROM ". $this->table_name . 
					" " . $new_join_array['join_statement'] . 
					" " . $new_where_array['where_statement'] .
 					" " . $this->order_statement;
 			
			$params = $new_where_array['bind_params'];
			return $this->query($query, $params);
		}

		//for INSERTing to the DB
		public function insert() {
			
			$insert_array = $this->buildInsertFields();
			$query = "INSERT INTO " . $this->table_name . " (" . $insert_array['insert_statement'] . ") VALUES (" . 
									$insert_array['values_statement'] . ")";
			return $this->query($query, $insert_array['bind_params']);

		}

		//for inserting many rows() 
		public function insertMany($child_obj) {
			$insert_array = $this->buildInsertFields();
			$query = "INSERT INTO " . $this->table_name . " (" . $insert_array['insert_statement'] . ") VALUES (" . 
									$insert_array['values_statement'] . ")";


			foreach ($insert_array['bind_params'] as $key) {
				$$key = '';
			}

			if ($stmt = $this->mysqli->prepare($query)) {
				call_user_func_array(array($stmt,'bind_param'),$this->bind_params($insert_array['bind_params']));
				
				$this->mysqli->query("START TRANSACTION");

				foreach($child_obj as $c) {
					//$$key = 
					foreach ($insert_array['bind_params'] as $k) {
						$$k = $c->{$k};
					}

					$stmt->execute();
				}

				$stmt->close();
				$mysqli->query("COMMIT");
			}

		}

		public function query($query, $params = null) {	

			if ($stmt = $this->mysqli->prepare($query)) {
				if($params != null) {
					call_user_func_array(array($stmt,'bind_param'),$this->bind_params($params));
				}
				$stmt->execute();
				$stmt->store_result();
				$results = $this->bind_results($stmt);
				$stmt->close();
				return $results;
			}
			else {
				$errorObject = new stdClass();
				$errorObject->query = $query;
				$errorObject->error = $this->mysqli->error;
				echo json_encode($errorObject);
			}
		}


		/******************************
			mySQL operation functions
		******************************/

		public function where($field, $param, $operator = "=") {
			if(in_array($field, $this->fields_array)) {
				//error check operator
				if($operator != "=" && $operator != "!=" && $operator != "<" && $operator != ">") {
					$operator = "=";
				}
				$arr = array("param" => $param, "operator" => $operator);
				$this->where_array[$field] = $arr;
			}
			return $this;
		}

		public function join($table, $select_fields = null) {
			if($select_fields != null) {
				foreach($select_fields as $k => $v) {
					//remove primary key to avoid dups
					if($v == $table . "_id") {
						unset($select_fields[$k]);
					}
					else {
						$select_fields[$k] = $table . "." . $v;
					}
				}
			}
			$this->join_array[$table] = $select_fields;
			return $this;
		}

		public function order($field, $order = false) {
			if(in_array($field, $this->fields_array)) {
				$this->order_statement = "ORDER BY " . $field;
				if($order) {
					$this->order_statement .= " ASC";
				}
				else {
					$this->order_statement .= " DESC";
				}
			}
			return $this;
		}


		/******************
			Query binding functions
		*******************/


		//dynamic function bind params
		protected function bind_params($params) {
			$binded_params = array('');                       
			foreach($params as $p) {  
				if(is_int($p)) {
					$binded_params[0] .= 'i';              //integer
				} elseif (is_float($p)) {
					$binded_params[0] .= 'd';              //double
				} elseif (is_string($p)) {
					$binded_params[0] .= 's';              //string
				} else {
					$binded_params[0] .= 'b';              //blob and unknown
				}
				array_push($binded_params, $p);
			}
			
			$refs = array();
			foreach ($binded_params as $key => $value) {
				$refs[$key] = & $binded_params[$key];
			}
			return $refs;
		}
		
		//dynamic function bind all fields
		protected function bind_results($stmt) {
			$fields_var = array();
			$results = null;
			
			$meta = $stmt->result_metadata();

			//check if it's INSERT, if so return ID;
			if($meta) {
				while ($field = $meta->fetch_field()) {
					$field_name = $field->name;
					$$field_name = null;
					$fields_var[$field_name] = &$$field_name;
				}
				call_user_func_array(array($stmt,'bind_result'),$fields_var);
				$results = array();
				
				if($stmt->num_rows == 1) {
					$stmt->fetch();
					foreach($fields_var as $k => $v) {
						$results[$k] = $v;
						$this->{$k} = $v;
					}
				}
				else if($stmt->num_rows > 1) {
					$i = 0;
					while($stmt->fetch()) {
						$results[$i] = array();
						foreach($fields_var as $k => $v) {
							$results[$i][$k] = $v;
						}
						$i++;
					}
				}
				return $results;
			}
			else {
				return $stmt->insert_id;
			}

		}


		/************************
		Query building functions
		************************/


		protected function buildWhereStatement() {

			$new_where_array = array(
					"bind_params" => null,
					"where_statement" => ""
				);

			if(!empty($this->where_array)) {

				//initialize fields
				$new_where_array['bind_params'] = array();
				$new_where_array["where_statement"] = "WHERE ";

				foreach($this->where_array as $field => $param_array) {
					array_push($new_where_array["bind_params"], $param_array["param"]);

					if($field != end(array_keys($this->where_array))) {
						$new_where_array["where_statement"] .= $this->table_name . "." . $field ." ". $param_array["operator"] ."  ? AND ";
					}
					else {
						$new_where_array["where_statement"] .= $this->table_name . "." . $field ." ". $param_array["operator"] ." ?";
					}
				}
			}
			$this->where_array = array(); //reset where
			
			return $new_where_array;
		}


		protected function buildJoinStatement() {
			$new_join_array = array(
					"select_fields" => "", //fields for select statement
					"join_statement" => "" //join statement
				);

			if(!empty($this->join_array)) {
				$c = 1;
				foreach($this->join_array as $table => $select_fields) {
					if(!empty($select_fields)) {
						$new_join_array["select_fields"].= implode(",",$select_fields);

						//add comma if not last table in loop
						if($c != count($this->join_array)) {
							$new_join_array["select_fields"].= ",";
						}						
					}
					$new_join_array["join_statement"] .= "JOIN " . $table . " ON " . $table . "." . $table ."_id = " . $this->table_name . "." . $table . "_id ";
					$c++;
				}
			}
			$this->join_array = array(); //reset join
			return $new_join_array;
		}	

		protected function buildSelectFields($fields, $join_select_fields = null) {
			if($fields == null) {
				$fields = $this->fields_array;
			}

			if($join_select_fields != null) {
				return implode(",",array_map(array($this, 'prependTableName'),$fields)) . "," . $join_select_fields;
			}
			else {
				return implode(",",$fields);
			}
		}

		protected function buildInsertFields() {

			$arr = array(
				"bind_params" => array(),
				"insert_statement" => "",
				"values_statement" => ""
			);

			$fields_to_impode = array();
			$values_to_impode = array();

			foreach ($this->fields_array as $f) {
				$field_settings = explode(",",$this->fields_array_settings[$f]);
				if(!in_array("private",$field_settings) && (in_array("required",$field_settings) || in_array("foreign",$field_settings) )) {
					array_push($arr['bind_params'], $this->{$f});
					array_push($fields_to_impode, $f);
					array_push($values_to_impode, "?");
				}
				else {
					// COME BACK HERE....need to insert non required fields
				}
			}

			$arr['insert_statement'] = implode(",",$fields_to_impode);
			$arr['values_statement'] = implode(",",$values_to_impode);

			return $arr;
		}


		/*********************
		Helper Model functions
		*********************/

		protected function prependTableName($field) {
			return $this->table_name . "." . $field;
		}

		/*******
		Get/Setters (Make magic functions at some point)
		*******/

		public function getFieldsArray() {
			return $this->fields_array;
		}

		public function setModelFields($fields) {
			if(gettype($fields) === "object") {
				foreach ($fields as $k => $v) {
					if(in_array($k, $this->fields_array)) {
						$this->{$k} = $v;
						if(in_array($k, $this->fields_required) && !in_array($k, $this->fields_foreign)) {
							$this->required_fields_count++;
						}
					}
					else {
						$this->error_details = "Invalid field: " . $k;
						return $this->messages["invalid"];
					}
				}

				if($this->required_fields_count === count($this->fields_required) - count($this->fields_foreign) ) {
					return $this->messages["success"];
				}
				else {
					$this->required_fields_count = 0; //resset 
					$this->error_details = $this->table_name . " model: Missing required fields";
					return $this->messages["required"];
				}
			}
			return false;
		}

		/*
			$set = add parent object as a field to the model
		*/
		public function verifyForeignKey($key, $id, $set = false) {
			$pos = strpos($key, '_');
			$fk = substr($key, 0, $pos);

			$parent_model = new $fk();
			$test = $parent_model->find($id);

			if(!empty($test)) {
				if($set) {
					$this->{$fk} = $parent_model;
				}
				return true;
			}
			else {
				return false;
			}
		}
	}

?>