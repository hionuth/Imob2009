<?php
require_once(".././include/initialize.php");
//if (!$session->is_logged_in()) {
//	redirect_to("login.php");
//}
ini_set('display_errors', 1);

function scrieDotari($categorie,$idApartament){
	$ret="";
	$sql="SELECT * FROM CategorieDotari WHERE Descriere='{$categorie}'";
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

function alteDotari($idApartament,$tip) {
	$ret="";
	$sql="SELECT * FROM CategorieDotari  WHERE TipProprietate='{$tip}' AND Privat<>1";
	$CatDotList=CategorieDotari::find_by_sql($sql);
	if (!empty($CatDotList)){
		foreach ($CatDotList as $CatDot){
			$sql="SELECT * FROM Dotare WHERE idCategorieDotari='{$CatDot->id}'";
			$DotList=Dotare::find_by_sql($sql);
			if (!empty($DotList)){
				foreach ($DotList as $Dot){
					if (are_dotarea($Dot->Descriere, $idApartament)){
						$ret.=", ".$Dot->Descriere;
					}
				}
			}
		}
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

function posteazaAnunt($inchiriere=0){
	global $oferta;
	global $apartament;
	global $client;
	global $agent;
	global $subzona;
	global $cartier;
	global $fotografii;
	
	$s="|";
	//0
	if ($inchiriere) {
		if ($apartament->TipProprietate<2) {
			$linie="ia";
		}
		if ($apartament->TipProprietate==2) {
			$linie="ic";
		}
		if ($apartament->TipProprietate==4) {
			if ($apartament->TipSpatiu=="birouri") {
				$linie="ib";
			}
			if ($apartament->TipSpatiu=="comercial") {
				$linie="es";
			}
			if ($apartament->TipSpatiu=="industrial") {
				$linie="ii";
			}
		}
		if ($apartament->TipProprietate==3) {
			$linie="vt";
		}
		
	}
	else {
		if ($apartament->TipProprietate<2) {
			$linie="va";
		}
		if ($apartament->TipProprietate==2) {
			$linie="vc";
		}
		if ($apartament->TipProprietate==3) {
			$linie="vt";
		}
		if ($apartament->TipProprietate==4) {
			if ($apartament->TipSpatiu=="birouri") {
				$linie="vb";
			}
			if ($apartament->TipSpatiu=="comercial") {
				$linie="vs";
			}
			if ($apartament->TipSpatiu=="industrial") {
				$linie="vi";
			}
			if ($apartament->TipSpatiu=="hotel") {
				$linie="vs";
			}
		}
	}
	//1
	$linie.=$s.$oferta->id;
	//2
	//$linie.=$s.$subzona->Denumire;
	$linie.=$s.$cartier->Denumire;
	//3
	$linie.=$s."Bucuresti";
	//4
	$linie.=$s."Bucuresti";
	//5
	//$linie.=$s.$apartament->PunctReper;
	$linie.=$s.$subzona->Denumire;
	//6
	if ($apartament->TipProprietate<2) {
		switch ($apartament->TipApartament){
			case "Decomandat" : $linie.=$s."D";
				break;
			case "Semidecomandat" : $linie.=$s."SD";
				break;
			default: $linie.=$s."ND";
		}
	}
	if ($apartament->TipProprietate==2) { 
		if ($apartament->Etaje<2) {
			$linie.=$s."Casa";
		}
		else {
			$linie.=$s."Vila";
		} 
	}
	if ($apartament->TipProprietate==4) {
		if ($apartament->TipSpatiu=="industrial") {
			$linie.=$s."Hala";
		}
		else {
			if ($apartament->TipConstructie=="cladire de birouri") {
				$linie.=$s."cladire birouri";
			}
			if ($apartament->TipConstructie=="centru comercial") {
				$linie.=$s."complex comercial";
			}
			if ($apartament->TipConstructie=="hala") {
				$linie.=$s."hala";
			}
			if ($apartament->TipConstructie=="bloc") {
				$linie.=$s."apartament";
			}
			if ($apartament->TipConstructie=="depozit") {
				$linie.=$s."hala";
			}
			if ($apartament->TipConstructie=="casa/vila") {
				$linie.=$s."vila";
			}
			if ($apartament->TipConstructie=="hotel") {
				$linie.=$s."apartament";
			}
		}
	}
	if ($apartament->TipProprietate==3){
		if ($apartament->Clasificare=="extravilan") {$linie.=$s."extravilan";}
		else {$linie.=$s."intravilan";}
	}
	//7
	if (!$inchiriere) $linie.=$s.$oferta->Pret;
	else $linie.=$s.$oferta->PretChirie;
	//8
	$linie.=$s.$oferta->Moneda;
	//9
	$linie.=$s."";
	//10
	$separator=array("\r\n", "\n", "\r");
	$linie.=$s.str_replace($separator, "<br>", $apartament->Detalii);
	//11
	switch ($client->idUtilizator){
		case 2: $linie.=$s."2134"; break;
		case 3: $linie.=$s."2133"; break;
		case 5: $linie.=$s."2794"; break;
		case 7: $linie.=$s."3932"; break;
		default:$linie.=$s."2133";
	}
	//$client->idUtilizator;
	//12-13
	$site="http://www.simsparkman.ro/foto/";
	$thumb="http://igor.lanconect.ro/Imob2009/images/small/s";
	$i=0;
	$tmp="";
	$thumbs="";
	foreach ($fotografii as $foto){
		$i++;
		if ($i>1) {
			if ($tmp!="")
			{
				$thumbs.="++".$thumb.$foto->NumeFisier;
				$tmp.="++".$site.$foto->NumeFisier;
			}
			else {
				$thumbs=$thumb.$foto->NumeFisier;
				$tmp=$site.$foto->NumeFisier;
				
			}
		}
		else { $linie.=$s.$thumb.$foto->NumeFisier.$s.$site.$foto->NumeFisier;}
	}
	//14-15
	$linie.=$s.$thumbs.$s.$tmp;
	//16
	$linie.=$s.($apartament->SuprafataConstruita > 0 ? $apartament->SuprafataConstruita : $apartament->SuprafataUtila);
	//17
	if ($apartament->TipProprietate==2) {$linie.=$s.$apartament->SuprafataCurte;}
	else {$linie.=$s."";}
	//18
	if (($apartament->TipProprietate<2)||($apartament->TipProprietate==4)) {
		if ($apartament->Etaj>0) {$linie.=$s.$apartament->Etaj;}
		else { $linie.=$s."P";}
	}
	else {$linie.=$s."";}
	//19
	if (($apartament->TipProprietate<2)||($apartament->TipProprietate==4)) {
		$linie.=$s.$apartament->EtajeBloc;
	}
	else {
		$linie.=$s."";
	}
	//20
	if ($apartament->TipProprietate!=3) {
		$linie.=$s.$apartament->NumarCamere;
	}
	else {
		$linie.=$s."";
	}
	//21 
	$linie.=$s."";
	//22
	$linie.=$s."";
	//23
	if ($apartament->TipProprietate==3){
		$linie.=$s.$apartament->Deschidere;
	}
	else {
		$linie.=$s."";
	}
	//24
	if ($apartament->TipProprietate==3){
		$linie.=$s.(are_dotarea("apa curenta", $apartament->id) ? "retea apa-canal" : "fara");
	}
	else {
		$linie.=$s."";
	}
	//25
	if ($apartament->TipProprietate==3){
		$linie.=$s.(are_dotarea("curent", $apartament->id) ? 1 : 0);
	}
	else {
		$linie.=$s."";
	}
	//26
	if ($apartament->TipProprietate==3){
		$linie.=$s.(are_dotarea("gaze", $apartament->id) ? 1 : 0);
	}
	else {
		$linie.=$s."";
	}
	//27
	if ($apartament->TipProprietate==3){
		$linie.=$s.(are_dotarea("canalizare", $apartament->id) ? "retea apa-canal" : "fara");
	}
	else {
		$linie.=$s."";
	}
	//28
	if ($apartament->TipProprietate==3){
		switch ($apartament->TipTeren){
			case "constructii": $linie.=$s."constructii case"; break;
			case "agricol": $linie.=$s."agricultura"; break;
			case "padure": $linie.=$s."padure"; break;
			default: $linie.=$s."";
		}
	}
	else {
		$linie.=$s."";
	}
	//29 - access
	$linie.=$s."";  
	//30 - inclinatie
	$linie.=$s."";	 
	//31
	if ($apartament->TipProprietate==3){
		$linie.=$s.($apartament->ConstructiePeTeren==1 ? "da" : "nu");
	}
	else {
		$linie.=$s."";
	}
	//32 - regim inaltime
	if (($apartament->TipProprietate==2)||($apartament->TipProprietate==3)) {
		$structura="";
		if ($apartament->Subsol==1) $structura.="+S ";
		if ($apartament->Demisol==1) $structura.="+D ";
		if ($apartament->Parter==1) $structura.="+P ";
		if ($apartament->Etaje>0) $structura.="+".$apartament->Etaje." ";
		if ($apartament->Mansarda==1) $structura.="+M";
		//if ($apartament->Pod==1) $structura.="+ pod";
		$linie.=$s.substr($structura,1);
	}
	else {
		$linie.=$s."";
	}
	//33
	if ($apartament->TipProprietate<3) {
		$linie.=$s.$apartament->NrGrupuriSanitare;
	}
	else {
		$linie.=$s."";
	}
	//34
	if ($apartament->TipProprietate<4) {
		$linie.=$s.($apartament->NrGrupuriSanitare>0 ? "propriu" : "fara");
	}
	else {
		$linie.=$s."";
	}
	//35 - amenajat
	$linie.=$s."";
	//36
	if ($apartament->TipProprietate!=3) {
		$mobila="";
		if ($apartament->are_dotarea("nemobilat")) $mobila="nemobilat";
		if ($apartament->are_dotarea("semimobilat")) $mobila="partial";
		if ($apartament->are_dotarea("clasic")) $mobila="complet";
		if ($apartament->are_dotarea("modern")) $mobila="lux";
		$linie.=$s.$mobila;
	}
	else {
		$linie.=$s."";
	}
	//37
	if ($apartament->TipProprietate!=3) {
		$incalzire="";
		if ($apartament->are_dotarea("centrala de apartament")) $incalzire="centrala termica";
		if ($apartament->are_dotarea("termoficare")) $incalzire="termoficare";
		if ($apartament->are_dotarea("debransat")) $incalzire="fara (debransat)";
		if ($incalzire=="") { $incalzire ="alte moduri";}
		$linie.=$s.$incalzire;
	}
	else {
		$linie.=$s."";
	}
	//38
	if ($apartament->TipProprietate<3) {
		$linie.=$s.$apartament->AnConstructie;
	}
	else {
		$linie.=$s."";
	}
	//39
	if ($apartament->TipProprietate<2) {
		$structura="";
		if ($apartament->are_dotarea("beton")) $structura="beton";
		if ($apartament->are_dotarea("caramida")) $structura="caramida";
		if ($apartament->are_dotarea("bca")) $structura="BCA";
		$linie.=$s.$structura;	
	}
	else {
		$linie.=$s."";
	}
	//40	
	$linie.=$s."absent";
	//41
	$linie.=$s."";  // orientare ?????
	//42
	$linie.=$s."http://www.simsparkman.ro/detaliioferta.php?id=".$oferta->id;
	//43  utilitati, imbunatatiri
	$dot="";
	$tmp=scrieDotari("Finisaje / Dotari", $apartament->id);
	if ($tmp!="") $dot.=$tmp;
	$tmp=scrieDotari("Stare interior", $apartament->id);
	if ($tmp!="") $dot.=$tmp;
	
	// 	$tmp=scrieDotari("Mobilier", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Electrocasnice", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	 	
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Sistem de incalzire", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Contorizare", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Spatii utile", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Dotari Imobil", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Utilitati", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Parcare", $apartament->id);
	// 	if ($tmp!="") $dot.=$tmp;
	// 	$tmp=scrieDotari("Vedere", $apartament->id);
	// 	if ($tmp!="") $dot.=", Vedere:".substr($tmp, 2, strlen($tmp));
	// 	$tmp=scrieDotari("Vecinatati", $apartament->id);
	// 	if ($tmp!="") $dot.=", Vecinatati:".substr($tmp, 2, strlen($tmp));
	//$dot=alteDotari($apartament->id, $apartament->TipProprietate);
	$linie.=$s.substr($dot, 2, strlen($dot));
	
	//44
	if ($apartament->TipProprietate<3){
		$linie.=$s.$apartament->NumarBalcoane;
	}
	else {
		$linie.=$s."";
	}
	//45
	$linie.=$s.$agent->full_name();
	//46
	$linie.=$s.$agent->Telefon;
	//47
	$linie.=$s."http://igor.lanconect.ro/Imob2009/images/".$agent->Poza;
	//48
	$linie.=$s.$agent->Email;
	//49
	$linie.=$s.$oferta->DataActualizare;
	
	echo $linie."\n";
}


$sql="SELECT * FROM Oferta WHERE (ExportCI>0 AND ExportCI<>3) AND Stare='de actualitate'";
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
		$cartier=Cartier::find_by_id($subzona->idCartier);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} AND Privat<>'1' ORDER BY Ordin";
		$fotografii=Foto::find_by_sql($sql);
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportCI=($oferta->ExportCI==3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportCI=0;}
		$oferta->save();
	}
}

?>