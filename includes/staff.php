<?php
require_once('database.php');

class staff{
	public static $nama_tabel="staff";
	protected static $db_fields = array('id','name','jabatan','gambar');
	
	public $id;
	public $name;
	public $gambar;
	public $jabatan;

	private $nama_gambar;
	private $nama_lama;
	private $temp_path;
	private $img_extensions;
	protected $upload_dir="images_staff";
	
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

	protected function renamefile(){
		$name_nospace = str_replace(' ', '', $this->name); 
		$this->nama_lama = website .ds. $this->upload_dir .ds. $this->gambar;
		$this->nama_gambar = website .ds. $this->upload_dir .ds. $name_nospace."-" .date('Y-m-d-H-s'). ".jpg";
		$this->gambar = $name_nospace."-" .date('Y-m-d-H-s'). ".jpg";
		rename($this->nama_lama,$this->nama_gambar);
	}

	
	public function upload_gambar($file){
		$name_nospace = str_replace(' ', '', $this->name);
		$this->loadimage($file);
		if($this->getHeight() > 720)
            $this->resize(1280,720);
        $this->gambar = $name_nospace."-" .date('Y-m-d-H-s'). ".jpg";
	}
	

	public function save(){
		if(isset($this->id)){
			if(!empty($this->gambar)){

				$sel = $this->get_subject_by_id();
				$selgambar = $sel['gambar'];
				if(!empty($selgambar)){
					$gambarlama = website .ds. $this->upload_dir .ds. $selgambar;
					unlink($gambarlama);
				}

				$this->saveimage(website .ds. $this->upload_dir .ds. $this->gambar);
				if($this->update()){
					return true;
				}else{
					return false;
				}
			}else{
				$sel_product = $this->get_subject_by_id();
				$this->gambar = $sel_product['gambar'];
				$this->update();
				return true;
			}
		}else{
			if(!empty($this->gambar)){
				$this->saveimage(website .ds. $this->upload_dir .ds. $this->gambar);
				if($this->create()){
					return true;
				}else{
					return false;
				}
			}else{
				$this->create();
				return true;
			}
		}
	}
	
	var $image; 
	var $image_type;

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

	public function delete(){
		global $database;

		$sel = $this->get_subject_by_id();
		$selgambar = $sel['gambar'];
		if(!empty($selgambar)){
			$gambarlama = website .ds. $this->upload_dir .ds. $selgambar;
			unlink($gambarlama);
		}
		
		$sql = "DELETE FROM " .self::$nama_tabel;
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";

		$database->query($sql);
		$database->bind(':id',$this->id);
		
		return $database->execute();
	}

	function loadimage($filename) {   
		$image_info = getimagesize($filename); 
		$this->image_type = $image_info[2]; 
		if( $this->image_type == IMAGETYPE_JPEG ) {   
			$this->image = imagecreatefromjpeg($filename);
			$this->img_extensions = ".jpg"; 
		} elseif( $this->image_type == IMAGETYPE_GIF ) {   
			$this->image = imagecreatefromgif($filename);
			$this->img_extensions = ".gif";  
		} elseif( $this->image_type == IMAGETYPE_PNG ) {   
			$this->image = imagecreatefrompng($filename); 
			$this->img_extensions = ".png"; 
		} 
	} 

	function saveimage($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) 
	{   
		if( $image_type == IMAGETYPE_JPEG ) { 
			imagejpeg($this->image,$filename,$compression); 
		} elseif( $image_type == IMAGETYPE_GIF ) {   
			imagegif($this->image,$filename); 
		} elseif( $image_type == IMAGETYPE_PNG ) {   
			imagepng($this->image,$filename); 
		} 

		if( $permissions != null) {   
			chmod($filename,$permissions); 
		} 
	} 

	function output($image_type=IMAGETYPE_JPEG) {   
		if( $image_type == IMAGETYPE_JPEG ) { 
			imagejpeg($this->image); 
		} elseif( $image_type == IMAGETYPE_GIF ) {   
			imagegif($this->image); 
		} elseif( $image_type == IMAGETYPE_PNG ) {   
			imagepng($this->image); 
		} 
	} 

	function getWidth() {   
		return imagesx($this->image); 
	} 

	function getHeight() {   
		return imagesy($this->image); 
	} 

	function resizeToHeight($height) {   
		$ratio = $height / $this->getHeight(); 
		$width = $this->getWidth() * $ratio; 
		$this->resize($width,$height); 
	}   

	function resizeToWidth($width) { 
		$ratio = $width / $this->getWidth(); 
		$height = $this->getheight() * $ratio; 
		$this->resize($width,$height); 
	}   

	function scale($scale) { 
		$width = $this->getWidth() * $scale/100; 
		$height = $this->getheight() * $scale/100; 
		$this->resize($width,$height); 
	}   

	function resize($width,$height) { 
		$new_image = imagecreatetruecolor($width, $height); 
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, 
						   $height, $this->getWidth(), $this->getHeight()); 
		$this->image = $new_image;
	}   

}

?>