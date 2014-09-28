<?php
require_once('database.php');

class artikel{
	public static $nama_tabel="artikel";
	protected static $db_fields = array('id','judul','content','kategori','penulis','tanggal','status');
	
	public $id;
	public $judul;
	public $content;
	public $kategori;
	public $penulis;
	public $tanggal;
	public $status;
	
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
	
	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		
		$database->query($sql);
		
		return $database->fetchColumn();
	}

	public function count_kategori(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " .self::$nama_tabel;
		$sql .= " WHERE kategori = :kategori";
		
		$database->query($sql);
		$database->bind(':kategori',$this->kategori);
		$database->execute();

		return $database->rowCount();
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

	public function get_artikel_by_id(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE id = :id AND ";
		$sql .= " Status = 1";
		$sql .= " LIMIT 1";

		$database->query($sql);
		$database->bind(':id',$this->id);
		$database->execute();
		$array = $database->fetch();

		return $array; 
	}

	public function get_artikel(){
		global $database;
		$sql = "SELECT * ";
		$sql .= "FROM ".self::$nama_tabel;
		$sql .= " WHERE content = :content";
		$sql .= " LIMIT 1";

		$database->query($sql);
		$database->bind(':content',$this->content);
		$database->execute();
		$array = $database->fetch();

		return $array; 
	}

	public function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}
						
	public function create(){
		global $database;
		$attributes = $this->attributes();

		$attribute_pairs = array();
	    foreach($attributes as $key => $value){
	        $attribute_pairs[] = ":{$key}";
	    }
		
		$sql = "INSERT INTO " .self::$nama_tabel." (" ;
		$sql .= join(", ", array_keys($attributes));
		$sql .=")VALUES(";
		$sql .= join(", ", $attribute_pairs);
		$sql .= ")";

		$database->query($sql);

		foreach($attributes as $key => $value){
	        $database->bind(":$key", $value);
	    }

		if($database->execute()){
			$this->id = $database->lastInsertId();
			return true;
		}else{
			return false;
		}
	}
	
	public function update(){
		global $database;
		$attributes = $this->attributes();

		$attribute_pairs = array();
		foreach($attributes as $key => $value){
			$attribute_pairs[] = "{$key}=:{$key}";
		}
			
		$sql ="UPDATE " .self::$nama_tabel." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':id', $this->id);

		foreach($attributes as $key => $value){
	        $database->bind(":$key", $value);
	    }
		
		return $database->execute();
	}
	
	public function update_kategori(){
		global $database;
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="kategori = :kategori";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':id',$this->id);
		$database->bind(':kategori',$this->kategori);
		$database->execute();
		
		return $database->execute();
	}


	public function update_status(){
		global $database;
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="status = :status";
		$sql .=" WHERE id = :id";

		$database->query($sql);
		$database->bind(':id',$this->id);
		$database->bind(':status',$this->status);
		$database->execute();
		
		return $database->execute();
	}

	public function delete(){
		global $database;
		
		$sql = "DELETE FROM " .self::$nama_tabel;
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";

		$database->query($sql);
		$database->bind(':id',$this->id);

		return $database->execute();
	}

}

?>