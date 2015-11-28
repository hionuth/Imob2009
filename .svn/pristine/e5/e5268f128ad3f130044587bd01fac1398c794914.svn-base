<?php 
require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject {
	
	protected static $table_name="Utilizator"; 
	protected static $db_fields=array('id', 'User','Parola', 'Nume', 'Prenume', 'NivelAcces', 'Adresa1','Adresa2', 'Oras', 'Judet', 
									  'Tara','CNP','SerieCI','NumarCI','Telefon','Email','Poza');
	public $id;
	public $User;
	public $Parola;
	public $Nume;
	public $Prenume;
	public $NivelAcces;
	public $Adresa1;
	public $Adresa2;
	public $Oras;
	public $Judet;
	public $Tara;
	public $CNP;
	public $SerieCI;
	public $NumarCI;
	public $Telefon;
	public $Email;
	public $Poza;
	
	private $temp_path;
	protected $upload_dir="images";
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
	
	public static function authenticate($username="",$password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		
		$sql  = "SELECT * FROM Utilizator WHERE User='{$username}' ";
		$sql .= "AND Parola='".md5($password)."' LIMIT 1";
		$result_array=self::find_by_sql($sql);
		//return !empty($result_array) ? array_shift($result_array) : false;
		if (!empty($result_array)) {
			$user=array_shift($result_array);
			$userlog=new Userlog();
                        date_default_timezone_set('Europe/Berlin');
			$userlog->DataLogare=date("Y-m-d");
			$userlog->idUtilizator=$user->id;
			$userlog->save();
			return $user;
		}
		else {
			return false;
		}
	}  //autenticate
	
	public function full_name() {
		if (isset($this->Prenume) || isset($this->Nume)) {
			return $this->Prenume." ".$this->Nume;
		}
		else {
			return "";
		}
	} 	  // full_name
	
	// Common methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
	}
	
	public static function find_by_id($id=0) {
		global $database;
		$result_array=self::find_by_sql("SELECT * FROM ".self::$table_name." where id='{$id}' LIMIT 1");
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
	
	public function save() {
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		
		$attributes=$this->sanitized_attributes();
		
		$this->salveaza_poza();
		
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
		
		
		$this->salveaza_poza();
		
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
	
	// poza utilizator
	
	public function ataseaza_poza($file){
		if (!$file || empty($file) || !is_array($file)) {
			$this->errors[]="Nu s-a incarcat nici un fisier.";
			return false;
		} elseif ($file['error']!=0) {
			$this->errors[]=$this->upload_errors[$file['error']];
			return false;
		} else {
			$this->temp_path = $file['tmp_name'];
			$this->Poza = basename($file['name']);
		}
		return true;
	}
	
	public function image_path(){
		return $this->upload_dir.DS.$this->Poza;
	}
	
	protected function salveaza_poza(){
		$target_path= SITE_ROOT.DS.$this->upload_dir.DS.$this->Poza;
		$w_dst=150;
		$h_dst=200;
		ini_set('memory_limit', '100M'); 
		$new_img = $target_path;
		$file_src= $target_path;
						     
		if (move_uploaded_file($this->temp_path, $target_path)){
			list($w_src, $h_src, $type) = getimagesize($file_src);  // create new dimensions, keeping aspect ratio
			$ratio = $w_src/$h_src;
			if ($w_dst/$h_dst > $ratio) {$w_dst = floor($h_dst*$ratio);} else {$h_dst = floor($w_dst/$ratio);}
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
		   	imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
			   	
		   	imagejpeg($img_dst, $new_img);    //  save new image
			
		   	//unlink($file_src);  //  clean up image storage
		   	imagedestroy($img_src);        
		   	imagedestroy($img_dst);

		}
	}
	
	// statistici
	
	
	public function numar_oferte_active($tip=""){
		global $database;
		
		$sql = "SELECT COUNT(Oferta.id) FROM Oferta INNER JOIN Apartament ON Oferta.idApartament=Apartament.id ";
		$sql.="WHERE Stare='de actualitate' AND Oferta.idAgentVanzare='$this->id'";
		if ( $tip !== "") {
			$sql.=" AND Apartament.TipProprietate='{$tip}'";
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public function numar_oferte_actualizate_perioada($tip="",$zile=0){
		global $database;
	
		$sql = "SELECT COUNT(Oferta.id) FROM Oferta INNER JOIN Apartament ON Oferta.idApartament=Apartament.id ";
		$sql.="WHERE Stare='de actualitate' AND Oferta.idAgentVanzare='$this->id' AND Oferta.DataActualizare >= date(now())-$zile";
		if ( $tip !== "") {
			$sql.=" AND Apartament.TipProprietate='{$tip}'";
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public function numar_oferte_adaugate($tip="",$zile=0){
		global $database;
	
		$sql = "SELECT COUNT(Oferta.id) FROM Oferta INNER JOIN Apartament ON Oferta.idApartament=Apartament.id ";
		$sql.="WHERE Stare='de actualitate' AND Oferta.idAgentIntroducere='$this->id'";

		 //
		if ( $zile > 0) {
			$sql.=" AND Apartament.DataIntrare >= date(now())-$zile";
		}
		
		if ( $tip !== "") {
			$sql.=" AND Apartament.TipProprietate='{$tip}'";
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public function numar_oferte_sincronizate($tip="",$site=""){
		global $database;
	
		$sql = "SELECT COUNT(Oferta.id) FROM Oferta INNER JOIN Apartament ON Oferta.idApartament=Apartament.id ";
		$sql.="WHERE Stare='de actualitate' AND Oferta.idAgentIntroducere='$this->id'";
	
		//
		if ( $site !="" ) {
			$sql.=" AND Oferta.{$site} > 0 AND Oferta.{$site} <> 3";
		} 
	
		if ( $tip !== "") {
		$sql.=" AND Apartament.TipProprietate='{$tip}'";
		}
			$result_set = $database->query($sql);
			$row = $database->fetch_array($result_set);
			return array_shift($row);
	}
	
}
?>