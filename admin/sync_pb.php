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
	global $cartier;
	global $oras;
	global $fotografii;
	global $fisier;
	global $fh;
	
	$id=$oferta->id;
	//if ($inchiriere) { $id+=9000;}
	
	fwrite($fh, "<property>\n");

		fwrite($fh, "<location>\n");

			fwrite($fh, "<long>");
				fwrite($fh, $apartament->Lng );
			fwrite($fh, "</long>\n");
			
			fwrite($fh, "<lat>");
				fwrite($fh, $apartament->Lat );
			fwrite($fh, "</lat>\n");
			
		fwrite($fh, "</location>\n");
	
		fwrite($fh, "<listing-details>\n");

			fwrite($fh, "<listing-type>");
				fwrite($fh, ($inchiriere==0 ? 1 : 2 ));
			fwrite($fh, "</listing-type>\n");

			fwrite($fh, "<listing-status>");
				fwrite($fh, 1);
			fwrite($fh, "</listing-status>\n");
			
			fwrite($fh, "<provider-listingcode>");
				fwrite($fh,"SP".str_pad($id,5,"0",STR_PAD_LEFT));
			fwrite($fh, "</provider-listingcode>\n");
			
			fwrite($fh, "<listing-url>");
				$link="http://www.simsparkman-imobiliare.ro/oferte-imobiliare/";
				$tmp="";
				if ($oferta->Vanzare==1) $tmp="vanzare";
				if ($oferta->Inchiriere==1) {
					if ($tmp!="") $tmp.="-";
					$tmp.="inchiriere";
				}
				switch ($apartament->TipProprietate) {
					case 0:$tmp.="-apartament-in-bloc";break;
					case 1:$tmp.="-apartament-in-vila";break;
					case 2:$tmp.="-casa-vila";break;
					case 3:$tmp.="-teren";break;
					case 4:$tmp.="-spatiu-".$apartament->TipSpatiu;
				}
				if ($apartament->TipProprietate<3) $tmp.="-{$apartament->NumarCamere}-camere";
				$tmp.="-".$oras->Denumire."-".$cartier->Denumire."-".$subzona->Denumire;
				$tmp.="--sp".str_pad($oferta->id,5,"0",STR_PAD_LEFT).".html";
				$lista=array("\s"," ");
				$link.=str_replace($lista,"-",html_entity_decode($tmp));
				fwrite($fh, $link);
			fwrite($fh, "</listing-url>\n");
			
			fwrite($fh, "<description>");
				//fwrite($fh, $anunt);
				fwrite($fh, $apartament->Detalii." Cod oferta SP".str_pad($oferta->id, 5,"0",STR_PAD_LEFT));
			fwrite($fh, "</description>\n");
			
			fwrite($fh, "<listing-phone>");
				fwrite($fh, $agent->Telefon );
			fwrite($fh, "</listing-phone>\n");
			
			fwrite($fh, "<listing-email>");
				fwrite($fh, $agent->Email );
			fwrite($fh, "</listing-email>\n");
			
			fwrite($fh, "<listing-contact-name>");
				fwrite($fh, $agent->full_name() );
			fwrite($fh, "</listing-contact-name>\n");
	
		fwrite($fh, "</listing-details>\n");
		
		fwrite($fh, "<basic-details>\n");
			
			fwrite($fh, "<property-type>");
				switch ($apartament->TipProprietate){
					case 0: $tmp=10; break;
					case 1: $tmp=10; break;
					case 2: $tmp=12; break;
					case 3: $tmp=30; break;
					case 4:
						switch ($apartament->TipSpatiu){
							case "comercial": $tmp=21; break;
							case "birouri": $tmp=20; break;
							case "industrial": $tmp=22; break;
							case "hotel": $tmp=20; break; 				//??????? ce vrei sa punem aici ca cei de la norc nu au asa ceva? 
							default: $tmp=21;
						}
						break;
				}
				fwrite($fh, $tmp );
			fwrite($fh, "</property-type>\n");
			
			fwrite($fh, "<price>");
				fwrite($fh, ($inchiriere==0 ? $oferta->Pret : $oferta->PretChirie) );
			fwrite($fh, "</price>\n");
			
			fwrite($fh, "<currency>");
				fwrite($fh, "EUR");
			fwrite($fh, "</currency>\n");
			
			fwrite($fh, "<year-built>");
				fwrite($fh, $apartament->AnConstructie );
			fwrite($fh, "</year-built>\n");
			
			fwrite($fh, "<rooms-number>");
				fwrite($fh, $apartament->NumarCamere );
			fwrite($fh, "</rooms-number>\n");
			
			fwrite($fh, "<bathrooms-number>");
				fwrite($fh, $apartament->NrGrupuriSanitare );
			fwrite($fh, "</bathrooms-number>\n");
			
			fwrite($fh, "<parking-number>");
				fwrite($fh, $apartament->NumarGaraje+$apartament->NumarParcari );					//  locuri parcare
			fwrite($fh, "</parking-number>\n");
			
			fwrite($fh, "<floor-number>");
				fwrite($fh, $apartament->Etaj );
			fwrite($fh, "</floor-number>\n");
			
			fwrite($fh, "<building-description>");
				$tmp="";
				if ($apartament->TipProprietate<2) {
					$tmp="P+".$apartament->EtajeBloc;
				}
				else {
					$structura="";
					if ($apartament->Subsol==1) $structura.="+ s ";
					if ($apartament->Demisol==1) $structura.="+ d ";
					if ($apartament->Parter==1) $structura.="+ p ";
					if ($apartament->Etaje>0) $structura.="+ ".$apartament->Etaje." ";
					if ($apartament->Mansarda==1) $structura.="+ m";
					if ($apartament->Pod==1) $structura.="+ pod";
					$tmp=substr($structura,1);
				}
				fwrite($fh, $tmp );
			fwrite($fh, "</building-description>\n");
			
			fwrite($fh, "<is-last-floor>");
				$tmp="";
				if ($apartament->TipProprietate<2) {
					$tmp=($apartament->Etaj==$apartament->EtajeBloc ? "yes" : "no");
				}
				fwrite($fh, $tmp );
			fwrite($fh, "</is-last-floor>\n");
			
			fwrite($fh, "<front-length>");
				if ($apartament->TipProprietate>1) { fwrite($fh, $apartament->Deschidere); }
			fwrite($fh, "</front-length>\n");
			
			fwrite($fh, "<area-builded>");
				fwrite($fh, $apartament->SuprafataConstruita );
			fwrite($fh, "</area-builded>\n");
			
			fwrite($fh, "<area-useful>");
				fwrite($fh, $apartament->SuprafataUtila>0 ? $apartament->SuprafataUtila : $apartament->SuprafataConstruita);
			fwrite($fh, "</area-useful>\n");
			
			fwrite($fh, "<area-land>");
				if ($apartament->TipProprietate!=3) { 
					$tmp=$apartament->SuprafataCurte;
				}
				else {
					$tmp = $apartament->SuprafataUtila;
				}
				fwrite($fh, $tmp);
			fwrite($fh, "</area-land>\n");
			
		fwrite($fh, "</basic-details>\n");

		fwrite($fh, "<pictures>\n");
		
		foreach ($fotografii as $foto) {
			fwrite($fh, "<picture>\n");
			
			fwrite($fh, "<picture-url>");
				fwrite($fh, "http://crm.simsparkman.ro/images/{$foto->NumeFisier}");
			fwrite($fh, "</picture-url>\n");
			fwrite($fh, "<picture-caption>");
				fwrite($fh, $foto->Detalii );
			fwrite($fh, "</picture-caption>\n");
			
			fwrite($fh, "</picture>\n");
		}
		
		fwrite($fh, "</pictures>\n");

		fwrite($fh, "<agent>\n");

			fwrite($fh, "<agent-name>");
				fwrite($fh, $agent->full_name());
			fwrite($fh, "</agent-name>\n");
			
			fwrite($fh, "<agent-email>");
				fwrite($fh, $agent->Email);
			fwrite($fh, "</agent-email>\n");
			
			fwrite($fh, "<agent-phone>");
				fwrite($fh, $agent->Telefon);
			fwrite($fh, "</agent-phone>\n");
			
			fwrite($fh, "<agent-avatar-url>");
				fwrite($fh, "http://crm.simsparkman.ro/images/".$agent->Poza);
			fwrite($fh, "</agent-avatar-url>\n");
			
		fwrite($fh, "</agent>\n");

		fwrite($fh, "<agency>\n");
			fwrite($fh, "<agency-name>");
				fwrite($fh, "Sims Parkman");
			fwrite($fh, "</agency-name>\n");
			
			fwrite($fh, "<agency-city>");
				fwrite($fh, "Bucuresti");
			fwrite($fh, "</agency-city>\n");
			
			fwrite($fh, "<agency-street-address>");
				fwrite($fh, "Bd. Unirii, Nr 45, Bl E3, Sc 4, Ap 141");
			fwrite($fh, "</agency-street-address>\n");
			
			fwrite($fh, "<agency-url>");
				fwrite($fh, "http://www.simsparkman.ro");
			fwrite($fh, "</agency-url>\n");
			
			fwrite($fh, "<agency-email>");
				fwrite($fh, "office@simsparkman.ro");
			fwrite($fh, "</agency-email>\n");
			
			fwrite($fh, "<agency-phone>");
				fwrite($fh, "0314.398.268");
			fwrite($fh, "</agency-phone>\n");
			
			fwrite($fh, "<agency-logo-url>");
				fwrite($fh, "http://crm.simsparkman.ro/images/logoromimo.jpg");
			fwrite($fh, "</agency-logo-url>\n");
		fwrite($fh, "</agency>\n");	
			
		fwrite($fh, "<more-details>");
			
			fwrite($fh, "<pot>");
				fwrite($fh, $apartament->POT);
			fwrite($fh, "</pot>\n");

			fwrite($fh, "<cut>");
				fwrite($fh, $apartament->CUT);
			fwrite($fh, "</cut>\n");

			fwrite($fh, "<destination>");
				fwrite($fh, $apartament->Destinatie);
			fwrite($fh, "</destination>\n");
			
		fwrite($fh, "</more-details>\n");
	fwrite($fh, "</property>\n");
		
	
}

//echo "Sincronizare in curs ...<br/>";
$fisier=".".DS."export".DS."propertybook.xml";
$fh=fopen($fisier, "w");
fwrite($fh, "<properties>\n");

$sql="SELECT * FROM Oferta WHERE ExportPB>0 and ExportPB<>3 AND Stare='de actualitate'";// AND ExportNorc<>3 AND Stare='de actualitate'"; //
// status oferta: 
//					0 - nu se exporta
//					1 - creare
//					2 - update
//					3 - delete
//					4 - exportat
$oferte=Oferta::find_by_sql($sql);
if (!empty($oferte)){
	foreach ($oferte as $oferta) {
		//if (( $oferta->OfertaWeb <> 3 ) && ( $oferta->Stare == "de actualitate" )){
			$apartament=Apartament::find_by_id($oferta->idApartament);
			$client=Client::find_by_id($apartament->idClient);
			$agent=User::find_by_id($oferta->IdAgentVanzare);
			$subzona=Subzona::find_by_id($apartament->idSubzona);
			$cartier=Cartier::find_by_id($subzona->idCartier);
			$oras=Zona::find_by_id($cartier->idZona);
			$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin";
			$fotografii=Foto::find_by_sql($sql);
			//posteazaAnunt(1);
			if ($oferta->Vanzare==1){
				posteazaAnunt(0);
			}
			if ($oferta->Inchiriere==1){
				posteazaAnunt(1);
			}
		//}
	}
}

fwrite($fh, "</properties>\n");
fclose($fh);
//echo "<br/>Sincronizare terminata.";
//require_once(".././include/head.php");
//redirect_to($currentPage)
?>
