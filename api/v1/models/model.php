<?php
	require_once('/shared/connection.php');

	class Model {
		protected $mysqli;
		protected $table_name;
		protected $fields_array;
		
		/*
			Array of tables to be joined if $this->joined is called.
		*/
		protected $join_array; 

		protected $privateFields;

		protected $order_statement;

		public function __construct() {
			$this->mysqli = new mysqli(HOST_DB, USERNAME_DB, PASSWORD_DB, NAME_DB);
			$this->table_name = strtolower(get_class($this));
			$this->join_array = array();
		}


		/**
		 * Find a single record.
		 *
		 * @param string $id
		 *
		 * @return query result
		 */
		public function find($id, $select_fields = null) {
			$query = "SELECT " . $this->buildSelectFields($select_fields) . 
					" FROM ". $this->table_name . 
					" WHERE " . $this->table_name . "_id = ? LIMIT 1";
					
			$params = array($id);
			return $this->query($query, $params);
		}

		public function findAll($select_fields = null) {
			$query = "SELECT " . $this->buildSelectFields($select_fields) . 
					" FROM ". $this->table_name . " " . $this->order_statement;
			$params = null;
			return $this->query($query, $params);
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


		/******************
			mySQL operation functions
		*******************/

		public function order($field, $order) {
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
			while ($field = $meta->fetch_field()) {
				$field_name = $field->name;
				$$field_name = null;
				$fields_var[$field_name] = &$$field_name;
			}
			call_user_func_array(array($stmt,'bind_result'),$fields_var);
			$results = array();
			
			if($stmt->num_rows == 1) {
				$stmt->fetch();
				$results['singleRecord'] = true;
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

		protected function buildSelectFields($fields) {
			if($fields == null) {
				$fields = $this->fields_array;
			}
			return implode(",",$fields);
		}
	}

?>