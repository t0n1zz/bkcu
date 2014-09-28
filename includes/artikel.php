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

	private $nama_gambar;
	private $nama_lama;
	private $temp_path;
	protected $upload_dir="images_artikel";
	
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
		$sql .= " WHERE kategori='" . $database->escape_value($this->kategori) . "'";
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
	
	protected function renamefile(){
		$name_nospace = str_replace(' ', '', $this->name); 
		$this->nama_lama = website .ds. $this->upload_dir .ds. $this->gambar;
		$this->nama_gambar = website .ds. $this->upload_dir .ds. $name_nospace."-" .date('Y-m-d-H-s'). ".jpg";
		$this->gambar = $name_nospace."-" .date('Y-m-d-H-s'). ".jpg";
		rename($this->nama_lama,$this->nama_gambar);
	}

	
	public function upload_gambar($file){
		$this->temp_path = $file['tmp_name'];
		$this->gambar = basename($file['name']);
	}
	

	public function save(){
		if(isset($this->id)){
			if(!empty($this->gambar) || !empty($this->temp_path)){
				$sel = $this->get_subject_by_id();
				$selgambar = $sel['gambar'];
				$gambarlama = website .ds. $this->upload_dir .ds. $selgambar;
				if(!unlink($gambarlama) || unlink($gambarlama)){
					$target = website .ds. $this->upload_dir .ds. $this->gambar;

					if(move_uploaded_file($this->temp_path , $target)){
						$this->renamefile();
						if($this->update()){
							unset($this->temp_path);
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
			}else{
				$sel_product = $this->get_subject_by_id();
				$this->gambar = $sel_product['gambar'];
				$this->update();
				return true;
			}
		}else{
			if(!empty($this->gambar) || !empty($this->temp_path)){
				$target = website .ds. $this->upload_dir .ds. $this->gambar;
				if(move_uploaded_file($this->temp_path , $target)){
					$this->renamefile();
					if($this->create()){
						unset($this->temp_path);
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				$this->create();
				return true;
			}
		}
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
	
	public function update_kategori(){
		global $database;
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="kategori='" .$database->escape_value($this->kategori). "'";
		$sql .=" WHERE id=" . $database->escape_value($this->id);
		$database->query($sql);
		
		return($database->affected_rows() == 1) ? true : false;
	}


	public function update_status(){
		global $database;
		$sql ="UPDATE " .self::$nama_tabel. " SET ";
		$sql .="status='" .$database->escape_value($this->status). "'";
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