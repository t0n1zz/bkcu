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
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		$hashed_password = sha1($password);
		
		$sql = "SELECT * FROM " .self::$nama_tabel;
		$sql .= " WHERE username = '{$username}'";
		$sql .= " AND password = '{$hashed_password}' ";
		$sql .= " LIMIT 1";
		
		$result_array = self::find_by_sql($sql);

		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function find_all(){
		return self::find_by_sql("SELECT * FROM " .self::$nama_tabel );
	}

	public function find_by_id($id=0){
		$result_array = self::find_by_sql("SELECT * FROM ".self::$nama_tabel." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql=""){
		global $database;
		$result = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public function validasi_duplikat(){
		global $database;
		$sql ="SELECT * FROM " .self::$nama_tabel;
		$sql .=" WHERE username='" .$this->username. "'";
		$result = $database->query($sql);
		return ($database->num_rows($result)>=1) ? false : true;
	}
	
	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		return array_shift($row);
	}
	
	public function get_subject_by_id(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE id=" . $this->id ;
		$sql .= " LIMIT 1";
		$database->query($sql);
		$array = $database->fetch_array($database->query($sql));
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
		$hashed_password = sha1($database->escape_value($this->password));
		
		$sql  ="INSERT INTO " .self::$nama_tabel. "(";
		$sql .="username,password,";
		$sql .="cu";
		$sql .=")VALUES('";
		$sql .=$database->escape_value($this->username). "', '";
		$sql .=$hashed_password. "', '";
		$sql .=$this->cu. "')";
		
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}
/*
	public function create(){
		global $database;
		$hashed_password = sha1($database->escape_value($this->password));
		
		$sql  ="INSERT INTO " .self::$nama_tabel. "(";
		$sql .="username,password,";
		$sql .="cu,";
		$sql .="akses_artikel,tambah_artikel,ubah_artikel,ubah_status_artikel,hapus_artikel,";
		$sql .="akses_kategori,tambah_kategori,ubah_kategori,hapus_kategori,";
		$sql .="akses_admin";
		$sql .=")VALUES('";
		$sql .=$database->escape_value($this->username). "', '";
		$sql .=$hashed_password. "', '";
		$sql .=$this->cu. "', '";
		$sql .=$this->akses_artikel. "', '" .$this->tambah_artikel. "', '" .$this->ubah_artikel. "', '"; 
		$sql .=$this->ubah_status_artikel. "', '" .$this->hapus_artikel. "', '";
		$sql .=$this->akses_kategori. "', '" .$this->tambah_kategori. "', '" .$this->ubah_kategori. "', '";
		$sql .=$this->hapus_kategori. "', '";
		$sql .=$this->akses_admin. "')";
		
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}
*/

	public function update(){
		global $database;
		$hashed_password = sha1($database->escape_value($this->password));
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="password='" . $hashed_password . "', ";
		$sql .="cu='". $this->cu . "'";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_status(){
		global $database;
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="status='". $this->status . "'";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}

	public function update_online(){
		global $database;
		date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="online='" .$waktu. "'";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}

	public function update_offline(){
		global $database;
		date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="offline='" .$waktu. "'";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}
/*
	public function update_hak_akses(){
		global $database;
		
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="akses_artikel='" . $this->akses_artikel ."', ";
		$sql .="tambah_artikel='" . $this->tambah_artikel . "', ";
		$sql .="ubah_artikel='" . $this->ubah_artikel . "', ";
		$sql .="ubah_status_artikel='" . $this->ubah_status_artikel . "', ";
		$sql .="hapus_artikel='" . $this->hapus_artikel . "', ";
		$sql .="akses_kategori='" . $this->akses_kategori . "', ";
		$sql .="tambah_kategori='" . $this->tambah_kategori . "', ";
		$sql .="ubah_kategori='" . $this->ubah_kategori . "', ";
		$sql .="hapus_kategori='" . $this->hapus_kategori . "', ";
		$sql .="akses_admin='" . $this->akses_admin . "' ";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}
*/	
	public function delete(){
		global $database;
		
		$sql = "DELETE FROM " .self::$nama_tabel;;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}
}

?>