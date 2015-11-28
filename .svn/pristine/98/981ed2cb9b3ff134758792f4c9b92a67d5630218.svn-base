<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

function trimiteXML($fisier=""){
	$ch=curl_init("http://www.pitagora.com.ro/xml/?code=a86e732336a3cbac03938de97c25b970&url=http://igor.lanconect.ro/Imob2009/admin".$fisier);
	echo "http://www.pitagora.com.ro/xml/?code=a86e732336a3cbac03938de97c25b970&url=http://igor.lanconect.ro/Imob2009/admin".$fisier."<br/>" ;
	curl_exec($ch);
	curl_close($ch);
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
	
	//sleep(1);
	$id=$oferta->id;
	if ($inchiriere) { $id+=9000;}
	$fisier=".".DS."export".DS."pitagora{$id}.xml";
	$fh=fopen($fisier, "w");
	fwrite($fh, "<anunturi>\n");
	fwrite($fh, "<anunt>\n");
	fwrite($fh, "<idanunt>{$id}</idanunt>\n");
	if (($oferta->ExportPitagora<3)&&($oferta->Stare=='de actualitate')) {
		fwrite($fh, "<com>upd</com>\n");
	}
	else{
		fwrite($fh, "<com>del</com>\n");
	}
	if ($apartament->NumarCamere==1) {$idCategorie=5+$inchiriere;}
	if ($apartament->NumarCamere==2) {$idCategorie=8+$inchiriere;}
	if ($apartament->NumarCamere==3) {$idCategorie=11+$inchiriere;}
	if ($apartament->NumarCamere==4) {$idCategorie=14+$inchiriere;}
	if ($apartament->NumarCamere>4) {$idCategorie=17+$inchiriere;}
	fwrite($fh, "<categorieid>{$idCategorie}</categorieid>\n");
	fwrite($fh, "<judetid>1</judetid>\n");
	fwrite($fh, "<localitateid>{$subzona->idPitagora}</localitateid>\n");
	fwrite($fh, "<pret>".($inchiriere==1 ? $oferta->PretChirie : $oferta->Pret)."</pret>\n");
	fwrite($fh,	"<moneda>{$oferta->Moneda}</moneda>\n");

	fwrite($fh, "<anunt>");
	fwrite($fh, $subzona->Denumire.", ".($apartament->PunctReper!=""? $apartament->PunctReper.", ":"") );
	fwrite($fh, "confort ".$apartament->Confort.", ".strtolower($apartament->TipApartament));
	if ($apartament->Etaj!="") { fwrite($fh, ", etaj ".($apartament->Etaj>0 ? $apartament->Etaj : "P"));}
	if ($apartament->EtajeBloc!="") { fwrite($fh, "/".$apartament->EtajeBloc);}
	if ($apartament->AnConstructie>0) { fwrite($fh,", bloc din anul ".$apartament->AnConstructie);}
	fwrite($fh, ", suprafata ".($apartament->SuprafataConstruita > 0 ? $apartament->SuprafataConstruita : $apartament->SuprafataUtila)." mp");
	if ($apartament->NrGrupuriSanitare>0) { fwrite($fh, ", ".($apartament->NrGrupuriSanitare>1 ? $apartament->NrGrupuriSanitare." bai" : "o baie"));}
	if ($apartament->NumarBalcoane > 0) { fwrite($fh, ", ".($apartament->NumarBalcoane > 1 ? $apartament->NumarBalcoane." balcoane" : "un balcon"));}
	fwrite($fh, scrieDotari("Mobilier", $apartament->id));	
	fwrite($fh, scrieDotari("Electrocasnice", $apartament->id));	
	fwrite($fh, scrieDotari("Finisaje / Dotari", $apartament->id));	
	fwrite($fh, scrieDotari("Sistem de incalzire", $apartament->id));
	fwrite($fh, scrieDotari("Contorizare", $apartament->id));
	fwrite($fh, scrieDotari("Parcare", $apartament->id));
	fwrite($fh,", pret negociabil ");
	fwrite($fh, "</anunt>\n");

	fwrite($fh, "<codanunt>SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT)."</codanunt>\n");
	fwrite($fh, "<emailagent>".$agent->Email."</emailagent>\n");
	fwrite($fh, "<telagent>".$agent->Telefon."</telagent>\n");
	fwrite($fh, "<numeagent>".$agent->full_name()."</numeagent>\n");
	fwrite($fh, "<special>0</special>\n");
	if ($apartament->Lat>0) {fwrite($fh, "<harta>http://www.map-imobiliare.ro/harta/?go={$apartament->Lat},{$apartament->Lng}</harta>\n"); }
	fwrite($fh, "<video></video>\n");
	fwrite($fh, "<an_constructie>{$apartament->AnConstructie}</an_constructie>\n");
	fwrite($fh, "<suprafata>".($apartament->SuprafataConstruita>0?$apartament->SuprafataConstruita : $apartament->SuprafataUtila )."</suprafata>\n");
	fwrite($fh, "<mobilat>1</mobilat>\n");
	if ($oferta->OfertaWeb>0) {fwrite($fh, "<link>http://www.simsparkman.ro/detaliioferta.php?id={$oferta->id}</link>\n");}
	fwrite($fh, "<exclusivitate>".($oferta->Exclusivitate>0 ? 1 : 0)."</exclusivitate>");
	fwrite($fh, "<colaborare>".($oferta->Exclusivitate>0 ? 1 : 0)."</colaborare>");
	$i=0;
	if (!empty($fotografii)){
		foreach ($fotografii as $foto) {
			$i++;
			fwrite($fh, "<poza{$i}>http://igor.lanconect.ro/Imob2009/{$foto->image_path()}</poza{$i}>\n");
		}
	}
	
	fwrite($fh, "</anunt>\n");
	fwrite($fh, "</anunturi>\n");
	fclose($fh);
	trimiteXML(substr($fisier, 1, strlen($fisier)));
	
}

echo "Sincronizare in curs ...<br/>";

$sql="SELECT * FROM Oferta WHERE ExportPitagora>0 AND ExportPitagora<4"; // AND Stare='de actualitate'";
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
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportPitagora=($oferta->ExportPitagora==3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportPitagora=0;}
		$oferta->save();
	}
}
echo "<br/>Sincronizare terminata.";
//require_once(".././include/head.php");
//redirect_to($currentPage)
?>