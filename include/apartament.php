<?php 
require_once(LIB_PATH.DS."database.php");

class Apartament extends DatabaseObject {
	
	protected static $table_name="Apartament"; 
	protected static $db_fields=array('id', 'TipProprietate', 'NumarCamere', 'Confort', 'TipApartament', 'Duplex', 'Etaj', 'EtajeBloc', 
								'TipConstructie', 'Subsol','Demisol','Parter','Etaje','Mansarda','Pod',
								'idZona', 'PunctReper','idStrada', 'Numar', 'Bloc', 'Scara', 'Apartament', 'Interfon', 'Sector', 'CodPostal',
								'AnConstructie','AnRenovare', 'NrGrupuriSanitare', 'idUtilizator', 'Detalii', 'DetaliiInterne', 'Website', 'idClient', 
								'idSursa', 'DataIntrare', 'DataActualizare', 'SuprafataUtila', 'SuprafataConstruita', 'SuprafataTerasa', 
								'SuprafataEtaj1', 'SuprafataEtaj2', 'SuprafataEtaj3', 'SuprafataCurte',
								'AmprentaSol', 'Deschidere', 'NumarDeschideri', 'TipCurte', 'TipIntrare',
								'NumarBalcoane', 'NumarBucatarii', 'NumarTerase', 'NumarParcari', 'NumarGaraje', 
								'ProiectNefinalizat','idSubzona','Lat','Lng',
								'LatimeDrumAcces', 'POT', 'CUT', 'Inclinatie', 'ConstructiePeTeren', 'Destinatie','TipTeren', 
								'Clasificare','Localizare','TipSpatiu','Inaltime','Vitrina','ClasaBirouri','youtube'
								);

	public $id;
	public $TipProprietate;
	public $NumarCamere;
	public $Confort;
	public $TipApartament;
	public $Duplex;
	public $Etaj;
	public $EtajeBloc;
	public $TipConstructie;
	public $Subsol;
	public $Demisol;
	public $Parter;
	public $Etaje;
	public $Mansarda;
	public $Pod;
	public $idZona;
	public $idStrada;
	public $Numar;
	public $Bloc;
	public $Scara;
	public $Apartament;
	public $Interfon;
	public $Sector;
	public $CodPostal;
	public $PunctReper;
	public $AnConstructie;
	public $AnRenovare;
	public $NrGrupuriSanitare;
	public $Detalii;
	public $DetaliiInterne;
	public $Website;
	public $idClient;
	public $idSursa;
	public $DataIntrare;
	public $DataActualizare;
	public $SuprafataUtila;
	public $SuprafataConstruita;
	public $SuprafataTerasa;
	public $SuprafataEtaj1;
	public $SuprafataEtaj2;
	public $SuprafataEtaj3;
	public $SuprafataCurte;
	public $AmprentaSol;
	public $Deschidere;
	public $NumarDeschideri;
	public $TipCurte;
	public $TipIntrare;
	public $NumarBalcoane;
	public $NumarBucatarii;
	public $NumarTerase;
	public $NumarParcari;
	public $NumarGaraje;
	public $ProiectNefinalizat;
	public $idSubzona;
	public $Lat;
	public $Lng;
	public $LatimeDrumAcces;
	public $POT;
	public $CUT;
	public $Inclinatie;
	public $ConstructiePeTeren;
	public $Destinatie;
	public $TipTeren;
	public $Clasificare;
	public $Localizare;
	public $TipSpatiu;
	public $Inaltime;
	public $Vitrina;
	public $ClasaBirouri;
	public $youtube;
	
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
	
	public function are_dotarea($dotare){
		$sql="
			SELECT D.Descriere,D.idImobiliare
			FROM Apartament AS A, DotareApartament AS DA, Dotare AS D
			WHERE D.Descriere = '{$dotare}'
			AND DA.idDotare = D.id
			AND DA.idApartament = A.id
			AND A.id ={$this->id}";
		$dotareList=Dotare::find_by_sql($sql);
		if (!empty($dotareList)) return true;
		return false;
	}
}
?>