<?php 
require_once(LIB_PATH.DS."database.php");

class Document extends DatabaseObject {
	
	protected static $table_name="Documente"; 
	protected static $db_fields=array('id','idApartament','NumeFisier','Tip','Marime','Detalii');
	public $id;
	public $idApartament;
	public $NumeFisier;
	public $Tip;
	public $Marime;
	public $Detalii;
	
	private $temp_path;
	protected $upload_dir="docs";
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
			
			$qShowStatus = "SHOW TABLE STATUS LIKE 'Documente'";
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

			if (move_uploaded_file($this->temp_path, $target_path)){
				if ($this->create()){
					//unset($this->temp_path);
					return true;
				}
			} else { 
					$this->errors[]="Fisierul nu a putut fi mutat. Verificati drepturile de scriere.";
					return false;
			}
			
		}
	}

	public function destroy() {
		if ($this->delete()) {
			$ok = true;
			$target_path=SITE_ROOT.DS.$this->doc_path();
			$ok=($ok && unlink($target_path));
			$ok=($ok && unlink($thumb_path));
			return ($ok ? true : false);
			//return unlink($target_path) ? true : false;
		} else {
			return false;
		}
	}
	
	public function doc_path(){
		return $this->upload_dir.DS.$this->NumeFisier;
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