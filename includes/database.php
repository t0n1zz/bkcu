                                <?php
require_once(folder.ds."constants.php");

class MySQLDatabase {
	
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exist;

	public $query_terakhir;

	function __construct(){
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exist = function_exists("mysql_real_escape_string");
	}
	
	private function confirm_query($result){
		if(!$result){
			$output = "Database query failed: " . mysql_error() . "<br />";
			$output .="Query terakhir adalah:" . $this->query_terakhir;
			die($output);
		}
	}
	
	public function escape_value($value){
		if($this->real_escape_string_exist){
			if($this->magic_quotes_active){ $value = stripslashes( $value ); }
			$value = mysql_real_escape_string($value);
		} else {
			if(!$this->magic_quotes_active){ $value = addslashes( $value ); }
		}
		return $value;
	}
	
	public function open_connection(){
		$this->connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if(!$this->connection){
			die("Datbase connection failed: " . mysql_error());
		}else{
			$db_select = mysql_select_db(DB_NAME,$this->connection);
			if(!$db_select){
				die("Database selection failed: " . mysql_error());
			}
		}
	}
	
	public function close_connection(){
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql){
		$this->query_terakhir = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}

	public function fetch_array($result){
		return mysql_fetch_array($result);
	}

	public function num_rows($result){
		return mysql_num_rows($result);
	}

	public function insert_id(){
		return mysql_insert_id($this->connection);
	}

	public function affected_rows(){
		return mysql_affected_rows($this->connection);
	}
}

$database = new MySQLDatabase();

?>
                            