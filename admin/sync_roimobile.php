<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
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
	global $fisier;
	global $fh;
	
	$s="\t";
	$id=$oferta->id;
	if ($inchiriere) { $id+=9000;}
	
	$anunt=$id;
	$anunt.=$s."102";
	$anunt.=$s."42";
	$anunt.=$s."Bucuresti";
	$anunt.=$s.$subzona->Denumire;
	$anunt.=$s."";
	if ($inchiriere==1) {
		$anunt.=$s."inchiriere";
		$tmp="Inchiriere ";
	}
	else { 
		$tmp="Vanzare ";
		$anunt.=$s."vanzare";
	}
	
	$tmp.=($apartament->NumarCamere>1?"apartament ".$apartament->NumarCamere." camere ":"garsoniera ");
	if ($apartament->PunctReper!="") {$tmp.=" - ".$apartament->PunctReper;}
	$anunt.=$s.$tmp;
	
	$anunt.=$s;
	$anunt.=$subzona->Denumire.", confort ".$apartament->Confort.", ".strtolower($apartament->TipApartament).", ";
	$anunt.="etaj ".($apartament->Etaj>0 ? $apartament->Etaj : "P" )."/".$apartament->EtajeBloc.", ";
	if ($apartament->AnConstructie>0) $anunt.="bloc din anul ".$apartament->AnConstructie;
	$anunt.=", suprafata ".round(($apartament->SuprafataConstruita>0 ? $apartament->SuprafataConstruita : $apartament->SuprafataUtila),0)." mp";
	if ($apartament->NrGrupuriSanitare>1) $anunt.=", ".$apartament->NrGrupuriSanitare." bai";
	elseif ($apartament->NrGrupuriSanitare>0) $anunt.=", o baie"; 
	if ($apartament->NumarBalcoane >1) $anunt.=", ".$apartament->NumarBalcoane." balcoane";
	elseif ($apartament->NumarBalcoane >0) $anunt.=", un balcon";

	$anunt.=scrieDotari("Mobilier", $apartament->id);
	$anunt.=scrieDotari("Electrocasnice", $apartament->id);
	$anunt.=scrieDotari("Finisaje / Dotari", $apartament->id);
	$anunt.=scrieDotari("Sistem de incalzire", $apartament->id);
	$anunt.=scrieDotari("Contorizare", $apartament->id);
	$anunt.=scrieDotari("Spatii utile", $apartament->id);
	$anunt.=scrieDotari("Dotari Imobil", $apartament->id);
	$anunt.=scrieDotari("Utilitati", $apartament->id);
	$anunt.=scrieDotari("Parcare", $apartament->id);
	$tmp=scrieDotari("Vedere", $apartament->id);
	if ($tmp!="") $anunt.="; Vedere: ".substr($tmp, 2, strlen($tmp));
	$tmp=scrieDotari("Vecinatati", $apartament->id);
	if ($tmp!="") $anunt.="; Vecinatati: ".substr($tmp, 2, strlen($tmp));
	$anunt.=". Broker ".$agent->full_name().", tel. ".$agent->Telefon.", ".$agent->Email;
	$anunt.=", cod SP".str_pad($id,5,"0",STR_PAD_LEFT);
	
	$anunt.=$s.($inchiriere==1 ? $oferta->PretChirie : $oferta->Pret );
	$anunt.=$s.date("Y-m-d",strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +30 days")); // data expirare
	
	$site="http://igor.lanconect.ro/Imob2009/images/";
	$tmp="";
	foreach ($fotografii as $foto){
		if ($tmp!="")
		{
			$tmp.=",".$site.$foto->NumeFisier;
		}
		else {
			$tmp=$site.$foto->NumeFisier;
		}
	}
	$anunt.=$s.$tmp;
	 
	$anunt.="\n";
	fwrite($fh, $anunt);

}

$sql="SELECT * FROM Oferta WHERE (ExportRoImobile>0 AND ExportRoImobile<>3) AND Stare='de actualitate'";
// status oferta: 
//					0 - nu se exporta
//					1 - creare
//					2 - update
//					3 - delete
//					4 - exportat
$oferte=Oferta::find_by_sql($sql);
if (!empty($oferte)){
	$fisier=".".DS."export".DS."RoImobile.txt";
	$fh=fopen($fisier, "w");
	fwrite($fh, "\n");
	foreach ($oferte as $oferta) {
		$apartament=Apartament::find_by_id($oferta->idApartament);
		$client=Client::find_by_id($apartament->idClient);
		$agent=User::find_by_id($client->idUtilizator);
		$subzona=Subzona::find_by_id($apartament->idSubzona);
		$strada=Strada::find_by_id($apartament->idStrada);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin DESC";
		$fotografii=Foto::find_by_sql($sql);
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportRoImobile=($oferta->ExportRoImobile==3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportRoImobile=0;}
		$oferta->save();
	}
}


?>