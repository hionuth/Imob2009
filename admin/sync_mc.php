<?php
require_once(".././include/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);

function valid_code($code)
{
	return $code >= 200 && $code < 300;
}

function setAtribut(&$data,$atribut,$valoare,$tip="")
{
	switch ($tip){
		case "N": if ($valoare!="") { $data[$atribut]=$valoare; }
		default: $data[$atribut]=$valoare; 
	}
}

function are_dotarea($dotare,$idApartament){
	$ret=0;
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D
		WHERE D.Descriere = '{$dotare}'
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)) $ret=1;
	return $ret;
}

function scrieDotari($categorie,$idApartament){
	$ret="";
	$sql="SELECT * FROM CategorieDotari  WHERE TipProprietate=1 AND Descriere='{$categorie}'";
	$CatDotList=CategorieDotari::find_by_sql($sql);
	if (!empty($CatDotList)){
		$CatDot=array_shift($CatDotList);
		$sql="SELECT * FROM Dotare WHERE idCategorieDotari='{$CatDot->id}'";
		$DotList=Dotare::find_by_sql($sql);
		if (!empty($DotList)){
			foreach ($DotList as $Dot){
				$sql="SELECT * FROM DotareApartament WHERE idDotare='{$Dot->id}' AND idApartament='{$idApartament}'";
				$DotApList=Dotareapartament::find_by_sql($sql);
				if (!empty($DotApList)){
					$ret.=", ".$Dot->Descriere;
				}
			}
		}
	}
	return $ret;
}

function posteazaAnunt($inchiriere=0){
	global $oferta;
	global $apartament;
	global $client;
	global $agent;
	global $subzona;
	global $strada;
	global $fotografii;
	global $request;

	$id=$oferta->id;
	$data["key"]="2HVO01c20rHj0lB60jI50dwB";
	$data["tip_oferta"]=($inchiriere==0 ? "vanzare" : "inchiriere");
	switch ($apartament->TipProprietate){
		case 0: $data["categorie_imobil"]=($apartament->NumarCamere > 1 ? "apartament" : "garsoniera"); break;
		case 1: $data["categorie_imobil"]=($apartament->NumarCamere > 1 ? "apartament" : "garsoniera"); break;
		case 2: $data["categorie_imobil"]="casa"; break;
		case 3: $data["categorie_imobil"]="teren"; break;
		case 4: {
			if ($apartament->TipSpatiu=="birouri") {$data["categorie_imobil"]="spatiu_birouri"; break;}
			if ($apartament->TipSpatiu=="hotel") {
				$data["categorie_imobil"]="spatiu_birouri"; break;
			}
			if ($apartament->TipSpatiu=="comercial") {
				$data["categorie_imobil"]="spatiu_comercial"; break;
			}
			if ($apartament->TipSpatiu=="industrial") {
				$data["categorie_imobil"]="hala_industriala"; break;
			}
		}
	}
	setAtribut($data, "zone_id" ,$subzona->idMC);
	setAtribut($data, "orase_id", 1);
	setAtribut($data, "strada_imobil", $subzona->Denumire);
	//setAtribut($data, "numar_strada", $apartament->Numar);
	
	
	
	setAtribut($data, "camere_imobil", $apartament->NumarCamere);
	
	setAtribut($data, "bai_imobil", $apartament->NrGrupuriSanitare , "N");
	setAtribut($data,"suprafata_imobil" , ($apartament->SuprafataConstruita > 0 ? $apartament->SuprafataConstruita : $apartament->SuprafataUtila), "N");
	setAtribut($data, "pret_imobil" , ($inchiriere ? $oferta->PretChirie : $oferta->Pret));
	setAtribut($data, "pret_tva", "cu_tva");
	setAtribut($data, "pret_negociabil", 1);
	setAtribut($data, "afiseaza_pmp", 1);
	
	if (are_dotarea("centrala de bloc", $apartament->id)) setAtribut($data, "incalzire_imobil", "centrala_bloc");
	if (are_dotarea("termoficare", $apartament->id)) setAtribut($data, "incalzire_imobil", "centrala_zona");
	if (are_dotarea("centrala de apartament", $apartament->id)) setAtribut($data, "incalzire_imobil", "centrala_proprie");
	if (are_dotarea("incalzire cu sobe", $apartament->id)) setAtribut($data, "incalzire_imobil", "soba");
	
	if ((are_dotarea("garaj", $apartament->id))||($apartament->NumarGaraje>0)) setAtribut($data, "parcare_imobil", "garaj");
	if (($apartament->NumarParcari>0)||are_dotarea("parcare subterana", $apartament->id)||are_dotarea("parcare inchiriata", $apartament->id)||are_dotarea("parcare proprie", $apartament->id)) setAtribut($data, "parcare_imobil", "privata");

	switch ($apartament->Etaj){
		case -3:setAtribut($data, "etaj_imobil","D");break;
		case -2:setAtribut($data, "etaj_imobil","D");break;
		case -1:setAtribut($data, "etaj_imobil",$apartament->Etaje);break;
		case 0:setAtribut($data, "etaj_imobil","P");break;
		default:setAtribut($data, "etaj_imobil",$apartament->Etaj);break;
	}
	//setAtribut($data, "etaj_imobil", ($apartament->Etaj > 0 ? $apartament->Etaj : "P"));
	if (($apartament->TipProprietate==1)||($apartament->TipProprietate==2)||($apartament->TipProprietate==4)) {
		$str="";
		if ($apartament->Subsol>0) $str.="S+";
		if ($apartament->Demisol>0) $str.="D+";
		if ($apartament->Parter>0) $str.="P+";
		if ($apartament->Etaje>0) $str.=$apartament->Etaje."+";
		if ($apartament->Mansarda>0) $str.="M+";
		if ($apartament->Pod>0) $str.="Pod+";
		$str=substr($str, 0, -1);
		setAtribut($data, "etajDin_imobil", $str);
	}
	else {
		if ($apartament->TipProprietate==0) {
			setAtribut($data, "etajDin_imobil", $apartament->EtajeBloc);
		}
	}
	setAtribut($data, "an_constructie_imobil", $apartament->AnConstructie, "N");
	if ($apartament->AnRenovare>0) setAtribut($data, "an_renovare_imobil", $apartament->AnRenovare, "N");
	
	// ---
	if ($apartament->Mansarda>0) setAtribut($data, "mansarda", 1);
	
	// -----
	
	setAtribut($data, "terase_balcoane", $apartament->NumarBalcoane, "N");
	setAtribut($data, "compartimentare", ($apartament->TipApartament !="Circular" ? strtolower($apartament->TipApartament) : "semidecomandat"));
	if (are_dotarea("termopan", $apartament->id)) $data["pvc_termopan_tamplarie"]=1;
	if (are_dotarea("gresie", $apartament->id )) $data["imbunatatiri_gresie"]=1;
	if (are_dotarea("faianta", $apartament->id)) $data["imbunatatiri_faianta"]=1;
	if (are_dotarea("parchet", $apartament->id)) $data["imbunatatiri_parchet"]=1;
	if (are_dotarea("canalizare", $apartament->id)) $data["canalizare"]="canal";
	if (are_dotarea("beton", $apartament->id)) $data["beton_constructie_imobil"]=1;
	if (are_dotarea("caramida", $apartament->id)) $data["caramida_constructie_imobil"]=1;
	if (are_dotarea("metal", $apartament->id)) $data["alta_varianta_constructie_imobil"]="metal";
	if (are_dotarea("centrala proprie", $apartament->id)) $data["centrala_gaz"]=1;
	if (are_dotarea("gaze", $apartament->id )) $data["conectare_gaze"]=1;
	
	// -----
	
// 	$anunt="Confort ".$apartament->Confort.", ".strtolower($apartament->TipApartament);
// 	$anunt.=scrieDotari("Mobilier", $apartament->id);
// 	$anunt.=scrieDotari("Electrocasnice", $apartament->id);
// 	$anunt.=scrieDotari("Finisaje / Dotari", $apartament->id);
// 	$anunt.=scrieDotari("Contorizare", $apartament->id);
// 	$anunt.=scrieDotari("Spatii utile", $apartament->id);
// 	$anunt.=scrieDotari("Dotari Imobil", $apartament->id);
// 	$anunt.=scrieDotari("Utilitati", $apartament->id);
// 	$tmp=scrieDotari("Vedere", $apartament->id);
// 	if ($tmp!="") $anunt.="; Vedere: ".substr($tmp, 2, strlen($tmp));
// 	$tmp=scrieDotari("Vecinatati", $apartament->id);
// 	if ($tmp!="") $anunt.="; Vecinatati: ".substr($tmp, 2, strlen($tmp));
	$anunt=$apartament->Detalii;
	$anunt.=" Cod oferta SP".str_pad($id,5,"0",STR_PAD_LEFT);
	
	setAtribut($data, "info_imobil", $anunt);
	setAtribut($data, "Ylat", $apartament->Lat);
	setAtribut($data, "Ylong", $apartament->Lng);
	
	// ------
	
	if ($apartament->TipProprietate==3) {
		$data["suprafata_teren"]=$apartament->SuprafataUtila;
		$data["teren_deschidere"]=$apartament->Deschidere;
		
	}
	
	if ($apartament->TipProprietate==2) {
		$data["amprenta_sol"]=$apartament->AmprentaSol;
	}
	// ------
	
	setAtribut($data, "telefon_proprietar", substr($client->TelefonMobil,-5));
	setAtribut($data, "email", $agent->Email);
	setAtribut($data, "id_intern", "SP".($inchiriere ? "1" : "0").str_pad($id,4,"0",STR_PAD_LEFT));
	
	// -------
	if ($apartament->TipProprietate==4) {
		if ($apartament->TipSpatiu=="birouri") {
			$data["clasa_birouri"]=$apartament->ClasaBirouri;
		}
		$data["grupuri_sanitare_imobil"]=$apartament->NrGrupuriSanitare;
	}
	
	// -------
	
	$request->flush();
	$request->setVerb(($oferta->ExportMC==1 ? "post" : "put"));
	$request->setPath("/imobile.json");
	$request->buildPostBody($data);
	
	//print_r($data);
	$request->execute();
	$response=$request->getResponseBody();
	
	//return false;
	
	//$request->setPath('/imobile.json');
	//$request->setVerb('post');
	//$request->buildPostBody($data);
	//$request->execute();
	//$response = $request->getResponseBody();
	//print_r($data);
	//echo "<br/>";
	//print_r($response);
	//return false;
	
	echo "Sincronizare ".$data["id_intern"].": ";
	if (!valid_code($response->code)){
		echo "eroare sincronizare: ";
		print_r($response);
		echo "<br />";
		return false;
	}
	else {
		echo "succes<br/>";
	}
	$responseData=$response->data;
	$oferta->idMC=$responseData->id;
	
	// stergere fotografii anterioare
	$request->flush();
	$request->setVerb("DELETE");
	$request->setPath("/poze.json");
	$pozaData["key"]="2HVO01c20rHj0lB60jI50dwB";
	$pozaData["id_intern"]="SP".($inchiriere ? "1" : "0").str_pad($id,4,"0",STR_PAD_LEFT);
	$request->buildPostBody($pozaData);
	$request->execute();
	$response=$request->getResponseBody();
	if (!valid_code($response->code)) {
		echo "<br />";
		echo "Eroare stergere poze: ".$data["id_intern"];
		print_r($response);//return false;
	}
	
	// postare fotografii
	foreach ($fotografii as $foto) {
		$request->flush();
		$request->setVerb("post");
		$request->setPath("/poze.json");
		
		$pozaData["key"]="2HVO01c20rHj0lB60jI50dwB";
		$pozaData["id_intern"]="SP".($inchiriere ? "1" : "0").str_pad($id,4,"0",STR_PAD_LEFT);
		$pozaData["url"]="http://crm.simsparkman.ro/images/{$foto->NumeFisier}";
		$pozaData["ordine"]=$foto->Ordin;
		
		$request->buildPostBody($pozaData);
		
		//print_r($pozaData);
		$request->execute();
		$response=$request->getResponseBody();
		if (!valid_code($response->code)) {
			echo "<br />";
			echo "Eroare sincronizare poza: ".$data["id_intern"]." - ".$foto->id.": ";
			print_r($response);//return false;
		}
	}
	
	return true;
}

function stergeAnunt(){
	global $oferta;
	global $request;
	
	$id=$oferta->id;
	
	$data["key"]="2HVO01c20rHj0lB60jI50dwB";
	
	if ($oferta->Vanzare) {
		$data["id_intern"]="SP".str_pad($id,5,"0",STR_PAD_LEFT);
		
		echo "Stergere ".$data["id_intern"].": ";
		
		$request->flush();
		$request->setVerb("DELETE");
		$request->setPath("/imobile.json");
		$request->buildPostBody($data);
		
		//$request->setPath("/imobile/".$data["id_intern"]."json?key=".$data["key"]);
		$request->execute();
		$response=$request->getResponseBody();
		if (!valid_code($response->code)){
			echo "Eroare stergere oferta: ".$data["id_intern"].": ";
			print_r($response);
			echo "<br />";
			return false;
		}
		else echo "succes<br/>";
	}
	if ($oferta->Inchiriere) {
		$data["id_intern"]="SP1".str_pad($id,4,"0",STR_PAD_LEFT);
		echo "Stergere ".$data["id_intern"].": ";
		$request->flush();
		$request->setVerb("DELETE");
		$request->setPath("/imobile.json");
		$request->buildPostBody($data);
		//$request->setPath("/imobile/".$data["id_intern"]."json?key=".$data["key"]);
		$request->execute();
		$response=$request->getResponseBody();
		if (!valid_code($response->code)){
			echo "Eroare stergere oferta: ".$data["id_intern"].": ";
			print_r($response);
			echo "<br />";
			return false;
		}
		else echo "succes<br/>";
	}
	return true;
}

$request= New RestRequest('http://api.magazinuldecase.ro');


$sql="SELECT * FROM Oferta WHERE ExportMC>0 AND ExportMC<4"; //AND Stare='de actualitate'"; //
// status oferta:
//					0 - nu se exporta
//					1 - creare
//					2 - update
//					3 - delete
//					4 - exportat
$oferte=Oferta::find_by_sql($sql);
if (!empty($oferte)){
	foreach ($oferte as $oferta) {
		$apartament=Apartament::find_by_id($oferta->idApartament);
		$client=Client::find_by_id($apartament->idClient);
		$agent=User::find_by_id($oferta->IdAgentVanzare);
		$subzona=Subzona::find_by_id($apartament->idSubzona);
		$strada=Strada::find_by_id($apartament->idStrada);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} AND Privat<>'1' ORDER BY Ordin";
		$fotografii=Foto::find_by_sql($sql);
		//posteazaAnunt(1);
		if (($oferta->ExportMC<3)&&($oferta->Stare=="de actualitate")) {
			$succes=true;
			if ($oferta->Vanzare==1){
				if (!posteazaAnunt(0)) $succes=false;
			}
			if ($oferta->Inchiriere==1){
				if (!posteazaAnunt(1)) $succes=false;
			}
			if ($succes) $oferta->ExportMC=4;
		}
		if (($oferta->ExportMC==3)||($oferta->Stare!="de actualitate"))
		{
			stergeAnunt();
			$oferta->ExportMC=0;
			$oferta->idMC="";
		}
		$oferta->save();
	}
}
else {
	echo "Nu sunt oferte de sincronizat.";
}
echo "<br/>Sincronizare cu Magazinul de Case terminata.";
?>
