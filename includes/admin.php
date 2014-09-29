<?php
require_once('database.php');

class admin {
	public static $nama_tabel="admin";
	public $id;
	public $username;
	public $password;
	public $status;
	
	public $cu;

/*
	public $akses_artikel;
	public $tambah_artikel;
	public $ubah_artikel;
	public $ubah_status_artikel;
	public $hapus_artikel;
	public $akses_kategori;
	public $tambah_kategori;
	public $ubah_kategori;
	public $hapus_kategori;

	public $akses_admin;
*/
	
	public static function authenticate($username="",$password=""){
		global $database;
		$hashed_password = sha1($password);
		
		$sql = "SELECT * FROM " .self::$nama_tabel;
		$sql .= " WHERE username = :username";
		$sql .= " AND password = :password";
		$sql .= " LIMIT 1";

		$result_array = self::find_by_sql($sql,$username,$hashed_password);

		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function find_all(){
		return self::find_by_sql("SELECT * FROM " .self::$nama_tabel );
	}

	public function find_by_id($id=0){
		$result_array = self::find_by_sql("SELECT * FROM ".self::$nama_tabel." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="", $username,$password){
		global $database;

		$database->query($sql);
		$database->bind(':username',$username);
		$database->bind(':password',$password);
		$database->execute();

		$object_array = array();
		while($row = $database->fetch()){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public function validasi_duplikat(){
		global $database;
		$sql ="SELECT COUNT(*) FROM " .self::$nama_tabel;
		$sql .=" WHERE username = :username";
		
		$database->query($sql);
		$database->bind(':username',$this->username);
		$database->execute();

		return ($database->fetchColumn() >= 1) ? false : true;
	}
	
	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		
		$database->query($sql);
		$database->execute();
		
		return $database->fetchColumn();
	}
	
	public function get_subject_by_id(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";

		$database->query($sql);
		$database->bind(':id',$this->id);
		$database->execute();
		
		$array = $database->fetch();
		return $array; 
	}
	
	private static function instantiate($record){
		$object = new self;
		
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute){
		$object_var = get_object_vars($this);
		return array_key_exists($attribute,$object_var);
	}
	
	public function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create(){
		global $database;
		$hashed_password = sha1($this->password);
		
		$sql  ="INSERT INTO " .self::$nama_tabel. "(";
		$sql .="username,password,status,";
		$sql .="cu";
		$sql .=")VALUES(";
		$sql .=":username,:password,:status,:cu)";

		$database->query($sql);
		$database->bind(':username',$this->username);
		$database->bind(':password',$hashed_password);
		$database->bind(':status',$this->status);
		$database->bind(':cu',$this->cu);
		
		if($database->execute()){
			$this->id = $database->lastInsertId();
			return true;
		}else{
			return false;
		}
	}

	public function update(){
		global $database;
		$hashed_password = sha1($this->password);
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="password = :password ,";
		$sql .="cu = :cu";
		$sql .=" WHERE id= :id";

		$database->query($sql);
		$database->bind(':password',$hashed_password);
		$database->bind(':cu',$this->cu);
		$database->bind(':id',$this->id);

		return $database->execute();
	}
	
	public function update_status(){
		global $database;
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="status = :status";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':status', $this->status);
		$database->bind(':id', $this->id);
		
		return $database->execute();
	}

	public function update_cu(){
		global $database;
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="cu = :cu";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':cu', $this->cu);
		$database->bind(':id', $this->id);
		
		return $database->execute();
	}

	public function update_online(){
		global $database;
		date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="online = :online";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':online',$waktu);
		$database->bind(':id',$this->id);

		return $database->execute();
	}

	public function update_offline(){
		global $database;
		date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="offline = :offline";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':offline',$waktu);
		$database->bind(':id',$this->id);

		return $database->execute();
	}

	public function delete(){
		global $database;
		
		$sql = "DELETE FROM " .self::$nama_tabel;;
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";
		
		$database->query($sql);
		$database->bind(':id',$this->id);

		return $database->execute();
	}
}

?>