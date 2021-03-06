<?php
	class DBHandler
	{
		private $server = "";
		private $db_name;
		private $db_user;
		private $db_pass;

		public function __construct() { 

			$file_name = $_SERVER["DOCUMENT_ROOT"]."/BrowseEvents/php/db/configDB.ini";
			$file = fopen($file_name, "r");

			while (! feof($file)) {
				$file_row = fgets($file);
				$valueVar = "";

				$pos = strpos($file_row, " ");
				if(!($pos === false)){
					$valueVar = substr($file_row, 0, $pos);
				}

				$pos = strpos($file_row, "=");
				if(!($pos === false)){
					$value = substr($file_row, $pos + 2, -2);

					if(strcmp($valueVar, "db_name") == 0){
						$this->db_name = $value;
					}
					elseif (strcmp($valueVar, "db_user") == 0) {
						$this->db_user = $value;
					}
					elseif (strcmp($valueVar, "db_pass") == 0) {
						$this->db_pass = $value;
					}
					elseif (strcmp($valueVar, "server") == 0) {
						$this->server = $value;
					}
				}
			}
			fclose($file);
		}

		private function connectDB(){

			$conn = mysqli_connect($this->server, $this->db_user, $this->db_pass, $this->db_name);

			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}
			else{
				return $conn;
			}
		}

		private function closeConnectionDB($conn){
			mysqli_close($conn);
		}

		private function queryDB($querySQL){
			$conn = $this->connectDB();
			$result = mysqli_query($conn, $querySQL);
			$this->closeConnectionDB($conn);
			return $result;
		}

		function select($querySQL){
			$result = $this->queryDB($querySQL);
			if($result){
				$setResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
				mysqli_free_result($result);
				
				return $setResult;
			}
			return NULL;
		}

		function genericQuery($querySQL){
			$result = $this->queryDB($querySQL);
			return $result;
		}

		function insert($querySQL){
			$conn = $this->connectDB();
			$result = mysqli_query($conn, $querySQL);
			$last_id = 0;
			if($result){
				$last_id = $conn->insert_id;
			}
			$this->closeConnectionDB($conn);
			return $last_id;
		}
	}
	
?>