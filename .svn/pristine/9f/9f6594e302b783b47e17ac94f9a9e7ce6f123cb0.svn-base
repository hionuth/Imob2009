<?php 
require_once(LIB_PATH.DS."database.php");

class Oferta extends DatabaseObject {
	
	protected static $table_name="Oferta"; 
	protected static $db_fields=array('id','idApartament','idAgentIntroducere','IdAgentVanzare','idAgentInchiriere',
										'Pret','PretInitial','PretFinal','Moneda','Negociabil','Data','DataExpirare','DataActualizare',
										'DataIntrareInPiata',
										'OfertaSpeciala','OfertaWeb','Exclusivitate','Vanzare','Stare','Comision','ComisionClient',
										'ComisionCumparatorZero','StarePrecontract',
										'Inchiriere','PretChirie','Titlu','Exportat','Linkuri','ExportPitagora','ExportImobiliare',
										'LinkImobiliare','ExportCI','LinkCI','ExportRoImobile', 'ExportRomimo','ExportNorc',
										'ExportMC','idMC','ExportImopedia','ExportPB');
	public $id;
	public $idApartament;
	public $idAgentIntroducere;
	public $IdAgentVanzare;
	public $idAgentInchiriere;
	public $Pret;
	public $PretInitial;
	public $PretFinal;
	public $Moneda;
	public $Negociabil;
	public $Data;
	public $DataExpirare;
	public $DataActualizare;
	public $DataIntrareInPiata;
	public $OfertaSpeciala;
	public $OfertaWeb;
	public $Exclusivitate;
	public $Vanzare;
	public $Stare;
	public $Comision;
	public $ComisionClient;
	public $ComisionCumparatorZero;
	public $StarePrecontract;
	public $Inchiriere;
	public $PretChirie;
	public $Titlu;
	public $Exportat;
	public $Linkuri;
	public $ExportPitagora;
	public $ExportImobiliare;
	public $LinkImobiliare;
	public $ExportCI;
	public $LinkCI;
	public $ExportRoImobile;
	public $ExportRomimo;
	public $ExportNorc;
	public $ExportMC;
	public $idMC;
	public $ExportImopedia;
	public $ExportPB;
	
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