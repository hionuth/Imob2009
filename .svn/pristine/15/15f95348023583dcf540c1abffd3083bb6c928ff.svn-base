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
	global $fotografii;
	global $fisier;
	global $fh;
	
	$id=$oferta->id;
	//if ($inchiriere) { $id+=9000;}
	
	fwrite($fh, "<RespoAd>\n");
	
	fwrite($fh, "<User>\n");
		//fwrite($fh, $agent->id."\n");		//  trebuie cerut id-ul de la Roimobile
		fwrite($fh, "58200\n");
	fwrite($fh, "</User>\n");
	
	fwrite($fh, "<Contact>\n");
		fwrite($fh, "<public>");
			fwrite($fh, "1");
		fwrite($fh, "</public>\n");
		
		fwrite($fh, "<name>");
			fwrite($fh, $agent->full_name());
		fwrite($fh, "</name>\n");
		
		fwrite($fh, "<firstname>");
			fwrite($fh, $agent->Prenume);
		fwrite($fh, "</firstname>\n");
		
		fwrite($fh, "<lastname>");
			fwrite($fh, $agent->Nume);
		fwrite($fh, "</lastname>\n");
		
		fwrite($fh, "<function>");
			fwrite($fh, "Broker");
		fwrite($fh, "</function>\n");
		
		fwrite($fh, "<company>");
			fwrite($fh, "Sims Parkman");
		fwrite($fh, "</company>\n");
		
		fwrite($fh, "<street>");
			fwrite($fh, "Calea Calarasi");
		fwrite($fh, "</street>\n");
		
		fwrite($fh, "<town>");
			fwrite($fh, "Bucuresti");
		fwrite($fh, "</town>\n");
		
		fwrite($fh, "<zip>");
			fwrite($fh, "030614");
		fwrite($fh, "</zip>\n");
		
		fwrite($fh, "<homepage>");
			fwrite($fh, "http://www.simsparkman.ro");
		fwrite($fh, "</homepage>\n");
		
		fwrite($fh, "<refcountryid>");
			fwrite($fh, "96");
		fwrite($fh, "</refcountryid>\n");
		
		fwrite($fh, "<telephone>");
			fwrite($fh, "0314.398.268" );
		fwrite($fh, "</telephone>\n");
		
		fwrite($fh, "<mobilephone>");
			fwrite($fh, $agent->Telefon );
		fwrite($fh, "</mobilephone>\n");
		
		fwrite($fh, "<fax>");
			fwrite($fh, "");
		fwrite($fh, "</fax>\n");
		
		fwrite($fh, "<externalid>");
			fwrite($fh, "");
		fwrite($fh, "</externalid>\n");
		
		fwrite($fh, "<userid>");
			fwrite($fh, $agent->id);				//  dat de Romimo ??
		fwrite($fh, "</userid>\n");
		
		fwrite($fh, "<email>");
			fwrite($fh, $agent->Email);
		fwrite($fh, "</email>\n");
		
		fwrite($fh, "<active>");
			fwrite($fh,"1");
		fwrite($fh, "</active>\n");
		
	fwrite($fh, "</Contact>\n");
	
	fwrite($fh, "<Ad>");

		fwrite($fh, "<refuserid>");
			fwrite($fh, $agent->id );				// dat de Romimo
		fwrite($fh, "</refuserid>\n");
		
		fwrite($fh, "<refclientid>");
			fwrite($fh,"18" );
		fwrite($fh, "</refclientid>\n");
	
		fwrite($fh, "<externalid>");
			fwrite($fh, $id);
		fwrite($fh, "</externalid>\n");
		
		fwrite($fh, "<refadstateid>");
			fwrite($fh, "1");						// aici e operatia de stergere ? 
		fwrite($fh, "</refadstateid>\n");
		
		fwrite($fh, "<refadtypeid>");
			fwrite($fh, "3");
		fwrite($fh, "</refadtypeid>\n");
		
		fwrite($fh, "<refmaincategory>");
			fwrite($fh, "1");			//  1	Apartamente ;2	Case ; 3	Terenuri; 4	Spatii comerciale
		fwrite($fh, "</refmaincategory>\n");
		
		fwrite($fh, "<refsubcategory>");
			fwrite($fh, ($apartament->NumarCamere>1 ? $apartament->NumarCamere+5 : 5));
		fwrite($fh, "</refsubcategory>\n");
		
		fwrite($fh, "<refcountryid>");
			fwrite($fh, "96" );
		fwrite($fh, "</refcountryid>\n");
		
		fwrite($fh, "<countyname>");
			fwrite($fh, "Bucuresti" );
		fwrite($fh, "</countyname>\n");
		
		fwrite($fh, "<cityname>");
			fwrite($fh,($apartament->Sector >0 ? "Sector ".$apartament->Sector :"Bucuresti") );		// sau sector
		fwrite($fh, "</cityname>\n");
		
		fwrite($fh, "<latitude>");
			fwrite($fh, $apartament->Lat);
		fwrite($fh, "</latitude>\n");
		
		fwrite($fh, "<longitude>");
			fwrite($fh, $apartament->Lng);
		fwrite($fh, "</longitude>\n");
		
		fwrite($fh, "<dealtype>");
			fwrite($fh, "0" );
		fwrite($fh, "</dealtype>\n");
		
		if ($inchiriere==0) {
			fwrite($fh, "<forsale>");
				fwrite($fh,"1");
			fwrite($fh, "</forsale>\n");
			
			fwrite($fh, "<buyprice>");
				fwrite($fh, $oferta->Pret );
			fwrite($fh, "</buyprice>\n");
			
			fwrite($fh, "<forrent>");
				fwrite($fh, "0");
			fwrite($fh, "</forrent>\n");
			
			fwrite($fh, "<rentprice>");
				fwrite($fh, "0");
			fwrite($fh, "</rentprice>\n");
		}
		if ($inchiriere==1) {
			fwrite($fh, "<forrent>");
				fwrite($fh, "1");
			fwrite($fh, "</forrent>\n");
			
			fwrite($fh, "<rentprice>");
				fwrite($fh, $oferta->PretChirie );
			fwrite($fh, "</rentprice>\n");
			
			fwrite($fh, "<forsale>");
				fwrite($fh,"0");
			fwrite($fh, "</forsale>\n");
			
			fwrite($fh, "<buyprice>");
				fwrite($fh, 0 );
			fwrite($fh, "</buyprice>\n");
		}
		
		fwrite($fh, "<refcurrencyid>");
			fwrite($fh, "1" );
		fwrite($fh, "</refcurrencyid>\n");
		
		if ($inchiriere==1) {
			$tmp="Inchiriere ";
		}
		else { 
			$tmp="Vanzare ";
		}
		$tmp.=($apartament->NumarCamere>1?"apartament ".$apartament->NumarCamere." camere, ":"garsoniera, ");
		$tmp.=$subzona->Denumire;
		if ($apartament->PunctReper!="") {$tmp.=" - ".$apartament->PunctReper;}
				
		fwrite($fh, "<title>");
			fwrite($fh, $tmp);
		fwrite($fh, "</title>\n");
		
		$anunt=$subzona->Denumire.", confort ".$apartament->Confort.", ".strtolower($apartament->TipApartament).", ";
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
		$anunt.="; cod SP".str_pad($id,5,"0",STR_PAD_LEFT);
		
		fwrite($fh, "<text>");
			fwrite($fh, $anunt );
		fwrite($fh, "</text>\n");
		
		fwrite($fh, "<validfrom>");
			fwrite($fh, date("Y-m-d"));
		fwrite($fh, "</validfrom>\n");
		
		fwrite($fh, "<validto>");
			fwrite($fh, date("Y-m-d",strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +30 days")));
		fwrite($fh, "</validto>\n");
		
		//fwrite($fh, "<>");
		//	fwrite($fh, );
		//fwrite($fh, "</>\n");
		
	fwrite($fh, "</Ad>\n");
	
	fwrite($fh, "<Pictures>\n");
		fwrite($fh, "<picture refexternaltype=\"1\" externalid=\"{$id}\" originalname=\"http://igor.lanconect.ro/Imob2009/images/logoromimo.jpg\"></picture>\n");
	foreach ($fotografii as $foto) {
		fwrite($fh, "<picture ");
		fwrite($fh, "refexternaltype=\"3\" rank=\"{$foto->Ordin}\" externalid=\"{$id}\" originalname=\"http://igor.lanconect.ro/Imob2009/images/{$foto->NumeFisier}\" description=\"{$foto->Detalii}\"");
		fwrite($fh, "></picture>\n");
	}
	
	fwrite($fh, "</Pictures>\n");
	
	
	fwrite($fh, "</RespoAd>\n");
	
}

//echo "Sincronizare in curs ...<br/>";
$fisier=".".DS."export".DS."romimo.xml";
$fh=fopen($fisier, "w");
fwrite($fh, "<RespoAds>\n");

$sql="SELECT * FROM Oferta WHERE ExportRomimo>0 AND ExportRomimo<>3 AND Stare='de actualitate'"; //AND ExportRomimo<4
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
		$agent=User::find_by_id($client->idUtilizator);
		$subzona=Subzona::find_by_id($apartament->idSubzona);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin";
		$fotografii=Foto::find_by_sql($sql);
		//posteazaAnunt(1);
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportRomimo=($oferta->ExportRomimo==3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportRomimo=0;}
		$oferta->save();
	}
}

fwrite($fh, "</RespoAds>\n");
fclose($fh);
//echo "<br/>Sincronizare terminata.";
//require_once(".././include/head.php");
//redirect_to($currentPage)
?>
