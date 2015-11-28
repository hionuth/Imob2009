<?php
class Imopedia
{
	public $DATA_APARITIE;
	public $ORAS;
	public $A_IMPARTIRE;
	public $B_CLASA;
	public $DATA_MODIFICARE;
	public $GEO_LAT;
	public $GEO_LONG;
	public $DESCHIDERE;
	public $SUPR_CONSTR;
	public $SUPR_TEREN;
	public $SUPR_UTILA;
	public $T_I_PRET;
	public $T_POT;
	public $T_RI;
	public $T_V_PRET;
	public $AGENTIA;
	public $C_MANSARDA;
	public $C_PIVNITA;
	public $ID_LOCAL;
	public $MOBILAT;
	public $NR_GR_SANITARE;
	public $NRDORMITOARE;
	public $STARE_IMOBIL;
	public $T_D_APA;
	public $T_D_CANALIZARE;
	public $T_D_CURENT;
	public $T_D_GAZE;
	public $T_EXTRAVILAN;
	public $T_INTRAVILAN;
	public $FINISAJE;
	public $DOTARI;
	public $DESTINATII_TEXT;
	public $DETALII;
	public $OBSERVATII;
	public $REPER;
	public $VECINATATI;
	public $NR_BALCOANE;
	public $ETAJ;
	public $NRCAM;
	public $NRETAJE;
	public $NR_BAI;
	public $T_I_TRANZ;
	public $T_V_TRANZ;
	public $TIP_IMOBIL_REAL;
	public $AGENT_ID;
	public $JUDET;
	public $T_I_MONEDA;
	public $T_V_MONEDA;
	public $AN_CONSTRUCTIE;
	public $AMPLASAMENT;
	public $ZONA;
	private $idApartament;
	
	function __construct(Apartament $apartment,  Oferta $oferta,  Subzona $subzona,  Cartier $cartier, Zona $oras)
	{
        $this->DATA_APARITIE	= $apartment->DataIntrare;
		$this->ORAS				= $oras->Denumire;
		switch ( $apartment->TipApartament ){
			case "Decomandat"		: $this->A_IMPARTIRE = 1; break;
			case "Semidecomandat"	: $this->A_IMPARTIRE = 2; break;
			case "Comandat"			: $this->A_IMPARTIRE = 3; break;
			case "Circular"			: $this->A_IMPARTIRE = 3; break;
			default					: $this->A_IMPARTIRE = 1; break;
		}
		$this->B_CLASA			= $apartment->ClasaBirouri;
		$this->DATA_MODIFICARE	= $oferta->DataActualizare;
		$this->GEO_LAT			= $apartment->Lat;
		$this->GEO_LONG			= $apartment->Lng;
		$this->DESCHIDERE		= $apartment->Deschidere;
		$this->SUPR_CONSTR		= $apartment->SuprafataConstruita;
		switch ( $apartment->TipProprietate ){
			case 2	:	$this->SUPR_TEREN = $apartment->SuprafataCurte; break;
			case 3	:	$this->SUPR_TEREN = $apartment->SuprafataUtila; break;
		}
		$this->SUPR_UTILA		= $apartment->SuprafataUtila;
		$this->T_I_PRET			= $oferta->PretChirie;
		$this->T_POT			= $apartment->POT;
		$this->T_RI				= "";								//??????
		$this->T_V_PRET			= $oferta->Pret;
		$this->AGENTIA			= "1173";
		$this->C_MANSARDA		= $apartment->Mansarda;
		$this->C_PIVNITA		= $apartment->Subsol;
		$this->ID_LOCAL			= $oferta->id;			
		$this->MOBILAT			= "";
		if (are_dotarea("semimobilat", $apartment->id)) {
			$this->MOBILAT		= 2;
		}
		else {
			if (are_dotarea("nemobilat", $apartment->id)){
				$this->MOBILAT	= 3;
			}
			else {
				if (are_dotarea("mobilat clasic", $apartment->id) || (are_dotarea("mobilat modern", $apartment->id)) || (are_dotarea("bucatarie mobilata", $apartment->id))) {
					$this->MOBILAT	= 1;
				}
			}
		}
		$this->NR_GR_SANITARE	= "";
		$this->NRDORMITOARE		= $apartment->NumarCamere-1;			
		$this->STARE_IMOBIL		= 2;
		if (are_dotarea("nou / finalizat", $apartment->id)) {
			$this->STARE_IMOBIL	= 1;
		}
		if (are_dotarea("necesita renovare", $apartment->id)) {
			$this->STARE_IMOBIL	= 3;
		}
		$this->T_D_APA			= 1;
		$this->T_D_CANALIZARE	= 1;
		$this->T_D_CURENT		= 1;
		$this->T_D_GAZE			= 1;
		$this->T_EXTRAVILAN		= ($apartment->Clasificare=="extravilan"? 1 : 0);
		$this->T_INTRAVILAN		= ($apartment->Clasificare=="intravilan"? 1 : 0);
		
		$finisaje = array(
				"parchet"		=> "parchet",
				"mocheta"		=> "mocheta",
				"gresie"		=> "gresie",
				"huma"			=> "huma",
				"tapet"			=> "tapet",
				"faianta"		=> "faianta",
				"termopan"		=> "geamuri termopan"
		);
		
		$this->FINISAJE			= "";
		foreach ( $finisaje as $key => $finisaj) {
			if (are_dotarea($key, $apartment->id)) {
				$this->FINISAJE	.= $finisaj.",";
			}
		}
		if ( $this->FINISAJE !="" ) {
			$this->FINISAJE = substr($this->FINISAJE, 0, -1);
		}
		
		$dotari = array (
				"aer conditionat"	=> "aer conditionat",
				"alarma"			=> "sistem de alarma",
				"interfon"			=> "interfon",	
				"usa metalica"		=> "usa metalica",
				"lift"				=> "lift",
				"masina de spalat rufe" => "masina de spalat"/*,
				"apa curenta"		=> "apa",
				"canalizare"		=> "canalizare",
				"gaze"				=> "gaze",
				"curent trifazic"	=> "curent electric 380V"	*/		 					
		);
		
		$this->DOTARI			= "";
		foreach ( $dotari as $key => $dotare) {
			if (are_dotarea($key, $apartment->id)) {
				$this->DOTARI	.= $dotare.",";
			}
		}
		if ( $this->DOTARI !="" ) {
			$this->DOTARI = substr($this->DOTARI, 0, -1);
		}
		
		//if ( $session->user_id==1) { 
			//print_r($this);
		 //}
		
		$this->DESTINATII_TEXT	= $apartment->Destinatie;
		$this->DETALII			= "";									//?????
		$this->OBSERVATII		= $apartment->Detalii;	
		$this->REPER			= $apartment->PunctReper;

		$this->VECINATATI		= "";
		$vecinatatiArr = array(
				"gradinita"			=> "gradinita",	
				"lac"				=> "lac",
				"liceu"				=> "scoala",
				"magazine"			=> "magazine",
				"metrou"			=> "transport in comun",
				"parc"				=> "parc",
				"scoala"			=> "scoala"	
		);
		foreach ($vecinatatiArr as $key => $dotare){
			if (are_dotarea($key, $apartment->id)) {
				$this->VECINATATI	.= $dotare.",";
			}
		}
		if ( $this->VECINATATI !="" ) {
				$this->VECINATATI = substr($this->VECINATATI, 0, -1);
		}

		
		$this->NR_BALCOANE		= $apartment->NumarBalcoane;
		$this->ETAJ				= $apartment->Etaj;
		$this->NRCAM			= $apartment->NumarCamere;
		$this->NRETAJE			= ($apartment->TipProprietate == 2 ? $apartment->Etaje : $apartment->EtajeBloc);
		$this->NR_BAI			= $apartment->NrGrupuriSanitare;
		$this->T_I_TRANZ		= $oferta->Inchiriere;
		$this->T_V_TRANZ		= $oferta->Vanzare;
		
		//echo $apartment->TipProprietate." ".$apartment->TipSpatiu.PHP_EOL;
		
		switch ($apartment->TipProprietate){
			case 0:$this->TIP_IMOBIL_REAL=1;break;
			case 1:$this->TIP_IMOBIL_REAL=1;break;
			case 2:$this->TIP_IMOBIL_REAL=3;break;
			case 3:$this->TIP_IMOBIL_REAL=7;break;
			case 4:if ($apartment->TipSpatiu=="birouri"){
						$this->TIP_IMOBIL_REAL=2;
					}
					if ($apartment->TipSpatiu=="comercial"){
						$this->TIP_IMOBIL_REAL=5;
					}
					if ($apartment->TipSpatiu=="industrial"){
						$this->TIP_IMOBIL_REAL=6;
					}
					if ($apartment->TipSpatiu=="hotel"){
						$this->TIP_IMOBIL_REAL=5;
					}
					break;
			default:$this->TIP_IMOBIL_REAL=1;
		}
		
		$this->AGENT_ID			= $oferta->IdAgentVanzare;
		$this->JUDET			= 1;
		$this->T_I_MONEDA		= $oferta->Moneda;
		$this->T_V_MONEDA		= $oferta->Moneda;
		$this->AN_CONSTRUCTIE	= $apartment->AnConstructie;
		$this->AMPLASAMENT		= "";
		$this->ZONA				= $subzona->idImopedia;
		
		$this->idApartament		=$apartment->id;
	}
	
	public function syncronize(){

		$imopediaSoap = new ImopediaSoap('http://syncapi.imopedia.ro/api2/sync.wsdl?'.time(), "ag1173api", "qrjefpkn8wa45ghsJw31l");
		$imopediaSoap->connect();
		
		//print_r($imopediaSoap);
		
		//print_r($this);
		
		$soap_result = $imopediaSoap->execute('saveProperty', $this);
		
		$oferta_adaugata = $soap_result['_success'][0]['result']['property_id'];
		
		// print_r($soap_result);
		//daca oferta s-a adaugat cu succes trimitem si pozele
		if($oferta_adaugata)
		{
			$photoSync=$this->getPhotoInfo();

			$sql="SELECT * FROM Foto WHERE idApartament='{$this->idApartament}'";
			$photos=Foto::find_by_sql($sql);
			
			
			foreach ($photos as $photo)
			{
				$locatie = "http://crm.simsparkman.ro/images/".$photo->NumeFisier;
				
				$options['FILE_ID'] 	= md5($photo->id.$photo->Detalii.$locatie);
				
				if (isset($photoSync[$options['FILE_ID']])) {
					unset($photoSync[$options['FILE_ID']]);
					continue;
				}
				
				$options['FILE_TITLE'] 	= $photo->Detalii;
				$options['ID_LOCAL'] 	= $this->idApartament;
				$options['AGENTIA'] 	= 1173;
				
				$optionso = $this->arrayToObject($options);
				
				//verificam daca poza exista pe imopedia.ro
				$rrr = $imopediaSoap->execute('existsFile', $optionso);

				//daca exista
				if($rrr['_success']['0']['photo']['exists'] == 1) continue;
		
				//daca nu exista
				$options['FILE_BODY'] 	= base64_encode(file_get_contents($locatie));
		
				$optionso = $this->arrayToObject($options);
				
				$soap_result = $imopediaSoap->execute('addFile', $optionso);
				
			}
			
			if (!empty($photoSync)) {
			
				//print_r($photoSync);
				
				// stergem pozele care nu se mai afla in baza noastra de date
				unset($options);
				foreach ($photoSync as $key => $photo){
					$options['AGENTIA']		= 1173;
					$options['ID_LOCAL'] 	= $this->idApartament;
					$options['FILE']['ID']	= $key;
					
					$optionso = $this->arrayToObject($options);
	
					$soap_result = $imopediaSoap->execute('deleteFile', $optionso);
				}
			}
			
		}
		$imopediaSoap->disconnect();
		
	}
	
	public function getPhotoInfo(){
		$imopediaSoap = new ImopediaSoap('http://syncapi.imopedia.ro/api2/sync.wsdl?'.time(), "ag1173api", "qrjefpkn8wa45ghsJw31l");
		$imopediaSoap->connect();
		
		$options['AGENTIA'] 	= 1173;
		$options['ID_LOCAL'] 	= $this->idApartament;
		
		$soap_result = $imopediaSoap->execute('getProperty',$this->arrayToObject($options));
		
		$imopediaSoap->disconnect();
		
		//echo "Result getProperty:".PHP_EOL;
		//print_r($soap_result);
		$poze=$soap_result['_success'][0]['result'][0]['POZE_INFO'];
		
		$pozearr=unserialize($poze);
		
		if (!is_array($pozearr)) return false; 
		
		foreach ($pozearr as $poza){
			$ret[$poza['ID']]=1;
		}
		
		return $ret;
		
		
	}
	
	public function syncAgenti(){
		$imopediaSoap = new ImopediaSoap('http://syncapi.imopedia.ro/api2/sync.wsdl?'.time(), "ag1173api", "qrjefpkn8wa45ghsJw31l");
		$imopediaSoap->connect();

		$agenti=User::find_all();
		foreach ($agenti as $agent){
			$agarr['AGENTIA']		= 1173;
			$agarr['AGENT_ID']		= $agent->id;
			$agarr['CONTACT_PERS']	= $agent->full_name();
			$agarr['CONTACT_TEL']	= $agent->Telefon;
			$agarr['CONTACT_EMAIL']	= $agent->Email;
			//$agarr['AGENT_IMAGE']	= base64_encode(file_get_contents("http://igor.lanconect.ro/Imob2009/".$agent->image_path()));
			$agarr['AGENT_IMAGE']	= str_replace(" ","%20","http://igor.lanconect.ro/Imob2009/".$agent->image_path());
				
			$agobj= $this->arrayToObject($agarr);
			//$soap_result = $imopediaSoap->execute('saveAgent', $options);
			$rrr = $imopediaSoap->execute('saveAgent', $agobj);
		}
		
		$imopediaSoap->disconnect();
		
		return true;
	}
	
	public function deleteOferta(){
		$imopediaSoap = new ImopediaSoap('http://syncapi.imopedia.ro/api2/sync.wsdl?'.time(), "ag1173api", "qrjefpkn8wa45ghsJw31l");
		$imopediaSoap->connect();
		
		$options['AGENTIA']		= 1173;
		$options['ID_LOCAL']	= $this->idApartament;
		
		$soap_result = $imopediaSoap->execute('deleteProperty',$this->arrayToObject($options));
		
		$imopediaSoap->disconnect();
		
		//print_r($soap_result);
		
		if (isset($soap_result['_success'][0]['info'])) return true;
		
		return false;
	}
	
	
	private function are_dotarea($dotare,$idApartament){
		$ret = false;
		$sql = "
			SELECT D.Descriere,D.idImobiliare
			FROM Apartament AS A, DotareApartament AS DA, Dotare AS D
			WHERE D.Descriere = '{$dotare}'
			AND DA.idDotare = D.id
			AND DA.idApartament = A.id
			AND A.id ={$idApartament}";
		$dotareList = Dotare::find_by_sql($sql);
		if (!empty($dotareList)) {
			$ret = true;
		}
		return $ret;
	}
	
	private function objectToArray($data)
	{
		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = $this->objectToArray($value);
			}
			return $result;
		}
		return $data;
	}
	
	private function arrayToObject($array) {
		if(!is_array($array)) {
			return $array;
		}
	
		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				$name = (trim($name));
				if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);
				}
			}
			return $object;
		}
		else {
			return FALSE;
		}
	}
	
}
?>