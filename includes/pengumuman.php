<?php
require_once('database.php');

class pengumuman{
	public static $nama_tabel="pengumuman";
	protected static $db_fields = array('id','name','penulis','tanggal');
	
	public $id;
	public $name;
	public $penulis;
	public $tanggal;
	
	private function has_attribute($attribute){
		$object_var = $this->attributes();
		return array_key_exists($attribute,$object_var);
	}
	
	protected function attributes(){
		$attributes = array();
		foreach(self::$db_fields as $field){
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}

	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		return array_shift($row);
	}

	public function count_kategori(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		$sql .= " WHERE kategori='" . $database->escape_value($this->kategori) . "' AND ";
		$sql .=" status=1";
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

	public function get_artikel_by_id(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE id=" . $this->id. " AND ";
		$sql .= " Status=1";
		$sql .= " LIMIT 1";
		$database->query($sql);
		$array = $database->fetch_array($database->query($sql));
		return $array; 
	}

	public function get_artikel(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE content='" . $database->escape_value($this->content) . "'";
		$sql .= " LIMIT 1";
		$database->query($sql);
		$array = $database->fetch_array($database->query($sql));
		return $array; 
	}
	
	public function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}
						
	public function create(){
		global $database;
		$attributes = $this->sanitized_attributes();
		
		$sql = "INSERT INTO " .self::$nama_tabel." (" ;
		$sql .= join(", ", array_keys($attributes));
		$sql .=")VALUES('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)){
			$this->id_kategori = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}
	
	public function update(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value){
			$attribute_pairs[] = "{$key}='{$value}'";
		}
			
		$sql ="UPDATE " .self::$nama_tabel." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}

	public function delete(){
		global $database;
		
		$sql = "DELETE FROM " .self::$nama_tabel;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);

		return($database->affected_rows() == 1) ? true : false;
	}

}

?>