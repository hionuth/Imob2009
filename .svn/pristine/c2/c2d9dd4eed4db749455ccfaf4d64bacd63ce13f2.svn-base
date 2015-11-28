<?php 
require_once(LIB_PATH.DS."database.php");

class Foto extends DatabaseObject {
	
	protected static $table_name="Foto"; 
	protected static $db_fields=array('id','idApartament','NumeFisier','Tip','Marime','Detalii','Ordin','Schita','Privat');
	public $id;
	public $idApartament;
	public $NumeFisier;
	public $Tip;
	public $Marime;
	public $Detalii;
	public $Ordin;
	public $Schita;
	public $Privat;
	
	private $temp_path;
	protected $upload_dir="images";
	protected $thumbs_dir="small";
	protected $max_height=600;
	public $errors=array();
	
	protected $upload_errors=array(
		0=>"Ok",
		1=>"Fisierul e mai mare decat marimea maxima permisa de server",
		2=>"Fisierul e mai mare decat marimea maxima permisa de formular",
		3=>"Incarcarea a fost efectuata partial",
		4=>"Fisier inexistent",
		5=>"Nu se poate scrie pe disc",
		6=>"Extensie de fisier nepermisa"
	);
		
	public function attach_file($file){
		if (!$file || empty($file) || !is_array($file)) {
			$this->errors[]="Nu s-a incarcat nici un fisier.";
			return false;
		} elseif ($file['error']!=0) {
			$this->errors[]=$this->upload_errors[$file['error']];
			return false;
		} else {
			$this->temp_path = $file['tmp_name'];
			$name=explode(".",basename($file['name']));
			$ext=array_pop($name);
			
			$qShowStatus = "SHOW TABLE STATUS LIKE 'Foto'";
			$qShowStatusResult 	= mysql_query($qShowStatus);
			$row = mysql_fetch_assoc($qShowStatusResult);
			$this->NumeFisier = $row['Auto_increment'].".".$ext;
			//$this->NumeFisier = basename($file['name']);
			$this->Tip = $file['type'];
			$this->Marime = $file['size'];
		}
		return true;
	}
	
	public function save() {
		if (isset($this->id)){
			$this->update();
		} else {
			if (!empty($this->errors)) {return false;}
			if (strlen($this->Detalii)>255){
				$this->errors[]="Detaliile depasesc 255 caractere.";
				return false;
			}
			$target_path= SITE_ROOT.DS.$this->upload_dir.DS.$this->NumeFisier;
//			if (file_exists($target_path)) {
//				$this->errors[]="Fisierul {$this->NumeFisier} exista deja.";
//				return false;
//			} 
//			convertPic($this->temp_path,800,600,);
//			if (move_uploaded_file($this->temp_path,$target_path)){
//				if ($this->create()){
//					unset($this->temp_path);
//					return true;
//				}
//			} else { 
//				$this->errors[]="Fisierul nu a putut fi mutat. Verificati drepturile de scriere.";
//				return false;
//			}
			$w_dst=800;
			$h_dst=600;
			$w_thumb=120;
			$h_thumb=120;
			ini_set('memory_limit', '100M');   //  handle large images
		   	//unlink($img_base.$n_img);         //  remove old images if present
		   	//unlink($img_base.$o_img);
			//$new_img = $img_base.$n_img;
			$new_img = $target_path;
			$new_thumb= SITE_ROOT.DS.$this->upload_dir.DS."small".DS."s".$this->NumeFisier; 
			$file_src= $target_path;
						     
			//$file_src = $img_base."zzimg.jpg";  //  temporary safe image storage
			//unlink($file_src);
			if (move_uploaded_file($this->temp_path, $target_path)){
				list($w_src, $h_src, $type) = getimagesize($file_src);  // create new dimensions, keeping aspect ratio
				$ratio = $w_src/$h_src;
				if ($w_dst/$h_dst > $ratio) {$w_dst = floor($h_dst*$ratio);} else {$h_dst = floor($w_dst/$ratio);}
				if ($w_thumb/$h_thumb > $ratio) {$w_thumb = floor($h_thumb*$ratio);} else {$h_thumb = floor($w_thumb/$ratio);}
				
			   	switch ($type){
			     	case 1:   //   gif -> jpg
			        	$img_src = imagecreatefromgif($file_src);
			        	break;
			      	case 2:   //   jpeg -> jpg
			        	$img_src = imagecreatefromjpeg($file_src); 
			        	break;
			      	case 3:  //   png -> jpg
			        	$img_src = imagecreatefrompng($file_src);
			        	break;
			     }
			   	$img_dst = imagecreatetruecolor($w_dst, $h_dst);  //  resample
			   	$img_thumb = imagecreatetruecolor($w_thumb, $h_thumb);  //  thumb
			   	imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
			   	imagecopyresampled($img_thumb, $img_src, 0, 0, 0, 0, $w_thumb, $h_thumb, $w_src, $h_src);
			   	
			   	// watermark
			   	
			   	$watermark_path= SITE_ROOT.DS."images".DS."watermark6.png";
			   	$watermark = imagecreatefrompng($watermark_path);
			   	imagealphablending($img_dst, true);
			   	$offset = 10;
			   	//imagecopy($img_dst, $watermark, imagesx($img_dst) - imagesx($watermark) - $offset, imagesy($img_dst) - imagesy($watermark) - $offset, 0, 0, imagesx($watermark), imagesy($watermark));
			   	
			   	$xp=imagesx($img_dst);
			   	$yp=imagesy($img_dst);
			   	$xw=imagesx($watermark);
			   	$yw=imagesy($watermark);
			   	
			   	//$x=floor($xp/$xw);
			   	//$y=floor($yp/$yw);
			   	
			   	$x=floor($xp/2-$xw/2);
			   	$y=floor($yp/2-$yw/2);
			   	
			   	imagecopy($img_dst, $watermark, $x , $y, 0, 0, $xw, $yw);
			   	
			   	/*
			   	for ($i=0;$i<=$x;$i++) {
			   		for ($j=0;$j<=$y;$j++) {
			   			imagecopy($img_dst, $watermark, $i*$xw , $j*$yw, 0, 0, $xw, $yw);
			   		}
			   	}
			   	*/
			   	//header("Content-Type: image/jpeg");
			   	
			   	// end of watermark
			   
			   	
			   	imagejpeg($img_dst, $new_img);    //  save new image
			   	imagejpeg($img_thumb, $new_thumb);    //  save new image
			
			   	//unlink($file_src);  //  clean up image storage
			   	imagedestroy($img_src);        
			   	imagedestroy($img_dst);
			   	imagedestroy($img_thumb);
				if ($this->create()){
					unset($this->temp_path);
					return true;
				}
			} else { 
					$this->errors[]="Fisierul nu a putut fi mutat. Verificati drepturile de scriere.";
					return false;
			}
			
		}
	}

	private function convertPic($img_base, $w_dst, $h_dst, $n_img, $o_img){
		
		
	 }
	
	
	
	public function destroy() {
		if ($this->delete()) {
			$ok = true;
			$target_path=SITE_ROOT.DS.$this->image_path();
			$thumb_path=SITE_ROOT.DS.$this->upload_dir.DS."small".DS."s".$this->NumeFisier;
			$ok=($ok && unlink($target_path));
			$ok=($ok && unlink($thumb_path));
			return ($ok ? true : false);
			//return unlink($target_path) ? true : false;
		} else {
			return false;
		}
	}
	
	public function image_path(){
		return $this->upload_dir.DS.$this->NumeFisier;
	}
	
	public function thumbnail_path(){
		return $this->upload_dir.DS.$this->thumbs_dir.DS."s".$this->NumeFisier;
	}
	// Common methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
	}
	
	public static function find_by_id($id=0) {
		global $database;
		$result_array=self::find_by_sql("SELECT * FROM ".self::$table_name." where id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="") {
		global $database;
		$result_set=$database->query($sql);
		$object_array = array();
		while ($row=$database->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public static function count_by_sql($sql=""){
		global $database;
		$result_set= $database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
	}

	private static function instantiate($record) {
		$object= new self;
		foreach($record as $attribute=>$value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		$object_vars=$this->attributes();
		return array_key_exists($attribute,$object_vars);
	}
	
	protected function attributes() {
		$attributes=array();
		foreach(self::$db_fields as $field) {
			if (property_exists($this, $field)) {
				$attributes[$field]=$this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
		global $database;
		$clear_attributes = array();
		foreach($this->attributes() as $key => $value) {
			$clear_attributes[$key]=$database->escape_value($value);	
		}
		return $clear_attributes;
	}
	
//	public function save() {
//		return isset($this->id) ? $this->update() : $this->create();
//	}
	
	public function create() {
		global $database;
		
		$attributes=$this->sanitized_attributes();
		
		$sql  = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ",array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '",array_values($attributes));
		$sql .= "')";
		
		if ($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		}
		else {
			return false;
		}
	}
	
	public function update() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql  = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ",$attribute_pairs);
		$sql .= " WHERE id=".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function delete() {
		global $database;
		$sql  = "DELETE FROM ".self::$table_name." ";
		$sql .= "WHERE id=".$database->escape_value($this->id)." LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
}
?>