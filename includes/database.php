                                <?php
require_once(folder.ds."constants.php");

class MySQLDatabase {
	
	public  $dbh;
	private $host = DB_SERVER;
	private $dbname = DB_NAME;
	private $stmt;

	function __construct(){
		$this->open_connection();
	}

	
	public function open_connection(){
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array(
		    PDO::ATTR_PERSISTENT => true, 
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		try {
		    $this->dbh = new PDO($dsn,DB_USER,DB_PASS, $options);
		}catch(PDOException $e){
	        error_notice($e);
	    }  
	}
	
	public function close_connection(){
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($query){
	    $this->stmt = $this->dbh->prepare($query);
	}

	public function bind($param, $value, $type = null){
	    if (is_null($type)) {
	        switch (true) {
	            case is_int($value):
	                $type = PDO::PARAM_INT;
	                break;
	            case is_bool($value):
	                $type = PDO::PARAM_BOOL;
	                break;
	            case is_null($value):
	                $type = PDO::PARAM_NULL;
	                break;
	            default:
	                $type = PDO::PARAM_STR;
	        }
	    }
	    $this->stmt->bindValue($param, $value, $type);
	}

	public function execute(){
	    return $this->stmt->execute();
	}

	public function fetchAll(){
	    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetch(){
	    return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchColumn(){
	    return $this->stmt->fetchColumn(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
	    return $this->stmt->rowCount();
	}

	public function lastInsertId(){
	    return $this->dbh->lastInsertId();
	}

	public function beginTransaction(){
	    return $this->dbh->beginTransaction();
	}

	public function endTransaction(){
	    return $this->dbh->commit();
	}

	public function cancelTransaction(){
	    return $this->dbh->rollBack();
	}

	public function debugDumpParams(){
	    return $this->stmt->debugDumpParams();
	}

}

$database = new MySQLDatabase();

?>
                            