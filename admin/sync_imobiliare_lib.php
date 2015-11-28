<?php 
function dotari($categorie="",$idApartament=""){
	$ret="";
	$categorieList=explode(",", $categorie);
	$categorie=implode("' OR CD.Descriere='", $categorieList);
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D, CategorieDotari AS CD
		WHERE D.idCategorieDotari = CD.id
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND (CD.Descriere = '{$categorie}')
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)){
		foreach ($dotareList as $dotare){
			if ($dotare->idImobiliare>0) {$ret.=$dotare->idImobiliare." ";}
			if ($categorie=="Vecinatati") {$ret.=$dotare->Descriere.", ";}
		}
	}
	return $ret;
}

function count_dotari($categorie="",$idApartament=""){
	$ret=0;
	$categorieList=explode(",", $categorie);
	$categorie=implode("' OR CD.Descriere='", $categorieList);
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D, CategorieDotari AS CD
		WHERE D.idCategorieDotari = CD.id
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND (CD.Descriere = '{$categorie}')
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)){
		foreach ($dotareList as $dotare){
			$ret=$ret+1;
		}
	}
	return $ret;
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

function corespondent($proprietate,$val1="",$val2="",$val3="",$val4=""){
	if ($proprietate<2) return $val1;
	if ($proprietate==2) return $val2;
	if ($proprietate==3) return $val3;
	if ($proprietate==4) return $val4;
}

function dotare_imobiliare($dotare,$id,$proprietate,$val1="",$val2="",$val3="",$val4=""){
	if (are_dotarea($dotare, $id)) {
		if ($proprietate<2) return $val1;
		if ($proprietate==2) return $val2;
		if ($proprietate==3) return $val3;
		if ($proprietate==4) return $val4;
	}
	return "";
}

function posteazaAnunt($inchiriere=0,$afisare=1){
	
	global $oferta;
	global $apartament;
	global $client;
	global $agent;
	global $subzona;
	global $fotografii;
	global $s;
	global $session_id;
	global $idImobiliare;
	global $ok;
	
	$zona=Cartier::find_by_id($subzona->idCartier);
	$oras=Zona::find_by_id($zona->idZona);
	switch ($oras->Denumire){
		case "Bucuresti": $orasImo=13822; break;
		case "Buftea": $orasImo=8116; break;
		default: $orasImo=13822;
	}
	
	$id=$oferta->id;
	if ($inchiriere) { $id+=90000;}
	
	$compartimentare=array(	"Decomandat" => 26 ,
						   	"Semidecomandat" => 27,
							"Circular" => 29,
							"Comandat" => 28,
							"Duplex" => 26);
	$moneda=array(
					"EUR"=>172,
					"RON"=>173,
					"LEI"=>173,
					"USD"=>174
	);
	
	$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
	<oferta tip="';//."apartament"
	switch ($apartament->TipProprietate){
		case 0:$ofertaxml.="apartament"; break;
		case 1:$ofertaxml.="apartament"; break;
		case 2:$ofertaxml.="casavila"; break;
		case 3:$ofertaxml.="teren"; break;
		case 4:$ofertaxml.="spatiu"; break;
	} 
	$ofertaxml.='" versiune="3">
	<id2>'. $id . '</id2>'
	.($inchiriere>0 ? "<deinchiriat>1</deinchiriat>":"<devanzare>1</devanzare>").'
	<tara>1048</tara>
	<judet>10</judet>
	<localitate>'.$orasImo.'</localitate>
	<zona>'.$subzona->idImobiliare.'</zona>
	<siteagentie>0</siteagentie>
	<portal>1</portal>';
	if ($apartament->TipProprietate<2) $ofertaxml.='<tiplocuinta>'.($apartament->NumarCamere>1 ? "110" : "111").'</tiplocuinta>';
	if ($apartament->TipProprietate==4) {
		switch ($apartament->TipSpatiu){
			case "birouri": $ofertaxml.='<tipspatiu>419</tipspatiu>';break;
			case "comercial": $ofertaxml.='<tipspatiu>420</tipspatiu>';break;
			case "industrial": $ofertaxml.='<tipspatiu>421</tipspatiu>';break;
			case "hotel": $ofertaxml.='<tipspatiu>422</tipspatiu>';break;
			default: $ofertaxml.='<tipspatiu>420</tipspatiu>';
		}
	}
	
	if ($apartament->TipProprietate<3) $ofertaxml.='<nrcamere>'.$apartament->NumarCamere.'</nrcamere>';
	if (strpos("014", $apartament->TipProprietate)!==false) $ofertaxml.='<etaj>'.($apartament->Etaj+45).'</etaj>';
	
	$ofertaxml.='<longitudine>'.$apartament->Lng.'</longitudine>
	<latitudine>'.$apartament->Lat.'</latitudine>
	<altitudine>200</altitudine>
	<caroiaj></caroiaj>';
	
	
	if ($apartament->SuprafataConstruita>0) {$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";}
	if ($oferta->Titlu!="") {
		$ofertaxml.="<titlu><lang id=\"1048\">".base64_encode($oferta->Titlu)."</lang></titlu>";
	}
	
	if (!($inchiriere>0)){
		$ofertaxml.="<pretvanzare>".($oferta->Pret+0)."</pretvanzare>";
		$ofertaxml.="<monedavanzare>{$moneda[$oferta->Moneda]}</monedavanzare>";
	}
	else {
		$ofertaxml.="<pretinchiriere>{$oferta->PretChirie}</pretinchiriere>";
		$ofertaxml.="<monedainchiriere>{$moneda[$oferta->Moneda]}</monedainchiriere>";
	}
	if ($oferta->ComisionCumparatorZero=='1') $ofertaxml.="<comisionzero>1</comisionzero>";
	else {
		$ofertaxml.="<comisionzero>2</comisionzero>";
		$ofertaxml.="<comisioncumparator><lang id=\"1048\">".base64_encode($oferta->ComisionClient)."</lang></comisioncumparator>";
	}
	
	// utilitati
	$tmp="";
	$x=dotare_imobiliare("gaze", $apartament->id, $apartament->TipProprietate, "2","123","307", "357");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("curent", $apartament->id, $apartament->TipProprietate, "32","98","308", "352");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("apa curenta", $apartament->id, $apartament->TipProprietate, "90","120","305", "354");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("canalizare", $apartament->id, $apartament->TipProprietate, "91","121","306", "355");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("curent trifazic", $apartament->id, $apartament->TipProprietate, "","111","309", "353");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("termoficare", $apartament->id, $apartament->TipProprietate, "26","170","", "340");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("centrala bloc", $apartament->id, $apartament->TipProprietate, "27","","", "");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("centrala proprie", $apartament->id, $apartament->TipProprietate, "28","171","", "341");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("incalzire cu sobe", $apartament->id, $apartament->TipProprietate, "35","172","", "342");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("incalzire pardoseala", $apartament->id, $apartament->TipProprietate, "36","174","", "344");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("aer conditionat", $apartament->id, $apartament->TipProprietate, "44","176","", "346");
	if ($x!="") $tmp.=$x." ";
	$tmp=substr($tmp,0,-1);
	$ofertaxml.="<utilitati>{$tmp}</utilitati>";
	
	//alte detalii zona
	$tmp="";
	$x=dotare_imobiliare("asfaltate", $apartament->id, $apartament->TipProprietate, "67","297","321", "423");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("betonate", $apartament->id, $apartament->TipProprietate, "72","299","323", "425");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("neamenajate", $apartament->id, $apartament->TipProprietate, "74","301","325", "427");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("pietruite", $apartament->id, $apartament->TipProprietate, "71","298","322", "424");
	if ($x!="") $tmp.=$x." ";
	$x=dotare_imobiliare("de pamant", $apartament->id, $apartament->TipProprietate, "73","300","324", "426");
	if ($x!="") $tmp.=$x." ";
	$tmp=substr($tmp,0,-1);
	$ofertaxml.="<altedetaliizona>{$tmp}</altedetaliizona>";
	
	if ($apartament->TipProprietate!=3) {  // fara terenuri
		$ofertaxml.="<suprafatautila>{$apartament->SuprafataUtila}</suprafatautila>";
		$ofertaxml.="<anconstructie>{$apartament->AnConstructie}</anconstructie>";
		$ofertaxml.="<nrgaraje>{$apartament->NumarGaraje}</nrgaraje>";
		//dotari
		$tmp="";
		$x=dotare_imobiliare("bucatarie mobilata", $apartament->id, $apartament->TipProprietate, "88","233","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("mobilat clasic", $apartament->id, $apartament->TipProprietate, "81","280","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("mobilat modern", $apartament->id, $apartament->TipProprietate, "82","281","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("semimobilat", $apartament->id, $apartament->TipProprietate, "83","282","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("nemobilat", $apartament->id, $apartament->TipProprietate, "481","482","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("frigider", $apartament->id, $apartament->TipProprietate, "102","270","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("cuptor cu microunde", $apartament->id, $apartament->TipProprietate, "103","265","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("aragaz", $apartament->id, $apartament->TipProprietate, "104","263","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("masina de spalat rufe", $apartament->id, $apartament->TipProprietate, "95","273","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("masina de spalat vase", $apartament->id, $apartament->TipProprietate, "106","274","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("televizor", $apartament->id, $apartament->TipProprietate, "112","278","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("hota", $apartament->id, $apartament->TipProprietate, "105","272","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("apometre", $apartament->id, $apartament->TipProprietate, "127","238","", "395");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("repartitoare", $apartament->id, $apartament->TipProprietate, "128","239","", "396");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("contor individual gaze", $apartament->id, $apartament->TipProprietate, "129","240","", "397");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("interfon", $apartament->id, $apartament->TipProprietate, "144","255","", "408");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("lift", $apartament->id, $apartament->TipProprietate, "145","256","", "409");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("uscatorie", $apartament->id, $apartament->TipProprietate, "148","","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("boxa", $apartament->id, $apartament->TipProprietate, "153","","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("debara", $apartament->id, $apartament->TipProprietate, "154","","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("pivnita", $apartament->id, $apartament->TipProprietate, "","225","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("spatiu depozitare", $apartament->id, $apartament->TipProprietate, "","227","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("crama", $apartament->id, $apartament->TipProprietate, "","226","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("anexe", $apartament->id, $apartament->TipProprietate, "","230","", "");
		if ($x!="") $tmp.=$x." ";
		if ($apartament->TipCurte!="") {
			$i=0;
			if ($apartament->TipProprietate==2) {
				$i=110;
			}
			if ($apartament->TipCurte=="comuna") {$tmp.=(242+$i)." ";}
			else {$tmp.=(241+$i)." "; }
		}
		if (($apartament->TipProprietate<2)&&($apartament->NumarTerase>0)) {$tmp.="151 ";}
		if (($apartament->TipProprietate<2)&&($apartament->NrGrupuriSanitare>1)) {
			$tmp.="152 ";
		}
		if (($apartament->TipProprietate<2)&&($apartament->NrGrupuriSanitare>1)) {
			$tmp.="229 ";
		}
		$tmp=substr($tmp,0,-1);
		$ofertaxml.="<dotari>{$tmp}</dotari>";
		
		// finisaje
		$tmp="";
		$x=dotare_imobiliare("stare buna", $apartament->id, $apartament->TipProprietate, "5","198","", "381");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("curat", $apartament->id, $apartament->TipProprietate, "5","198","", "381");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("nou", $apartament->id, $apartament->TipProprietate, "24","197","", "380");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("renovat", $apartament->id, $apartament->TipProprietate, "24","197","", "380");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("necesita renovare", $apartament->id, $apartament->TipProprietate, "99","199","", "382");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("termopan", $apartament->id, $apartament->TipProprietate, "12","201","", "384");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("parchet", $apartament->id, $apartament->TipProprietate, "50","459","", "378");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("mocheta", $apartament->id, $apartament->TipProprietate, "57","461","", "377");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("gresie", $apartament->id, $apartament->TipProprietate, "55","460","", "374");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("faianta", $apartament->id, $apartament->TipProprietate, "62","189","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("usa metalica", $apartament->id, $apartament->TipProprietate, "160","214","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("tamplarie interioara", $apartament->id, $apartament->TipProprietate, "165","219","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("vopsea lavabila", $apartament->id, $apartament->TipProprietate, "60","190","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("huma", $apartament->id, $apartament->TipProprietate, "65","194","", "");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("tapet", $apartament->id, $apartament->TipProprietate, "64","195","", "");
		if ($x!="") $tmp.=$x." ";
		$tmp=substr($tmp,0,-1);
		$ofertaxml.="<finisaje>{$tmp}</finisaje>";
		
		// structura de rezistenta
		$tmp="";
		if (are_dotarea("beton", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,136,368,"",432);
		if (are_dotarea("caramida", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,137,366,"",430);
		if (are_dotarea("bca", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,138,367,"",431);
		if (are_dotarea("lemn", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,139,369,"",433);
		if (are_dotarea("metal", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,140,370,"",435);
		if ($tmp!="") {
			$ofertaxml.="<structurarezistenta>{$tmp}</structurarezistenta>";
		}
		
		// stadiu constructie
		$tmp="";
		if ((are_dotarea("nou / finalizat", $apartament->id))||(are_dotarea("stare buna", $apartament->id))||(are_dotarea("necesita renovare", $apartament->id))||(are_dotarea("reabilitat termic", $apartament->id))) {
			if ($apartament->TipProprietate<2) $tmp="127";
			if ($apartament->TipProprietate==2) $tmp="362";
			if ($apartament->TipProprietate==4) $tmp="551";
		}
		if (are_dotarea("nou / nefinalizat", $apartament->id)){
			if ($apartament->TipProprietate<2) $tmp="129";
			if ($apartament->TipProprietate==2) $tmp="364";
			if ($apartament->TipProprietate==4) $tmp="552";
		}
		if ($tmp!="") {
			$ofertaxml.="<stadiuconstructie>{$tmp}</stadiuconstructie>";
		}
	}
	
	if ($apartament->TipProprietate==0) { // apartamente bloc
		$ofertaxml.="<nrnivele>{$apartament->EtajeBloc}</nrnivele>";
	}
	
	if (($apartament->TipProprietate==1)||($apartament->TipProprietate==2)) {  //apartamente in vila si case
		$ofertaxml.="<nrnivele>{$apartament->Etaje}</nrnivele>";
		$ofertaxml.="<demisol>{$apartament->Demisol}</demisol>";
		$ofertaxml.="<mansarda>{$apartament->Mansarda}</mansarda>";
		$ofertaxml.="<subsol>{$apartament->Subsol}</subsol>";
	}
	
	
	if ($apartament->TipProprietate<3) {   // apartamente si case
		$ofertaxml.="<regimhotelier>0</regimhotelier>";
		//$ofertaxml.="<nrnivele>{$apartament->EtajeBloc}</nrnivele>";
		$ofertaxml.="<nrbai>{$apartament->NrGrupuriSanitare}</nrbai>";
		$ofertaxml.="<nrbalcoane>{$apartament->NumarBalcoane}</nrbalcoane>";
		$ofertaxml.="<nrbucatarii>{$apartament->NumarBucatarii}</nrbucatarii>";
		$ofertaxml.="<nrlocuriparcare>{$apartament->NumarParcari}</nrlocuriparcare>";
	}

	
	if ($apartament->TipProprietate<4) {    // fara spatii
		$tmp="";
		if (are_dotarea("birouri", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,468,456,"","");
		if (are_dotarea("rezidential", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,466,454,471,"");
		if (are_dotarea("comercial", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,467,455,473,"");
		if (are_dotarea("agricol", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"","",474,"");
		if (are_dotarea("industrial", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"","",472,"");
		$ofertaxml.="<destinatie>{$tmp}</destinatie>";
		
	}
	
	if ($apartament->TipProprietate<2) {     // doar apartamente
		$ofertaxml.='<tipcompartimentare>'.$compartimentare[$apartament->TipApartament].'</tipcompartimentare>';
		$ofertaxml.="<tipimobil>".(121+$apartament->TipProprietate)."</tipimobil>";
		$ofertaxml.="<confort>".($apartament->Confort+36)."</confort>";
		//$ofertaxml.="<dotari>".dotari("Mobilier,Electrocasnice,Contorizare,Spatii utile,Dotari Imobil",$apartament->id)."</dotari>";
		$ofertaxml.="<finisaje>".dotari("Finisaje / Dotari",$apartament->id).
								(are_dotarea("renovat", $apartament->id) ? "24 " : "").
								(are_dotarea("stare buna", $apartament->id) ? "5 " : "").
								(are_dotarea("curat", $apartament->id) ? "5 " : "").
								(are_dotarea("necesita renovare", $apartament->id) ? "99 " : "")."</finisaje>";
		//$ofertaxml.="<utilitati>".dotari("Utilitati,Sistem de incalzire",$apartament->id).(are_dotarea("aer conditionat", $apartament->id) ? "44 " : "")."</utilitati>";
		
	}
	
	if ($apartament->TipProprietate==2) {  // doar case
		$ofertaxml.="<frontstradal>{$apartament->Deschidere}</frontstradal>";
		$ofertaxml.="<suprafatateren>{$apartament->SuprafataCurte}</suprafatateren>";
		$ofertaxml.="<nrterase>{$apartament->NumarTerase}</nrterase>";
		//$ofertaxml.="<demisol>".($apartament->Demisol+0)."</demisol>";
		//$ofertaxml.="<subsol>".($apartament->Subsol+0)."</subsol>";
		//$ofertaxml.="<mansarda>".($apartament->Mansarda+0)."</mansarda>";
		$ofertaxml.="<nrfronturi>".($apartament->NumarDeschideri)."</nrfronturi>";
		$ofertaxml.="<destinatie>".dotari("Destinatie",$apartament->id)."</destinatie>";
		
		$tmp="";
		if (are_dotarea("tabla", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"",2,"","");
		if (are_dotarea("tigla", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"",3,"","");
		if (are_dotarea("sindrila", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"",4,"","");
		$ofertaxml.="<invelitoareacoperis>{$tmp}</invelitoareacoperis>";
	}
	
	if ($apartament->TipProprietate==3) {  // doar terenuri
		$ofertaxml.="<suprafatateren>{$apartament->SuprafataUtila}</suprafatateren>";
		$ofertaxml.="<frontstradal>{$apartament->Deschidere}</frontstradal>";
		$ofertaxml.="<umsuprafatateren>382</umsuprafatateren>";
		switch ($apartament->Clasificare) {
			case "intravilan":$ofertaxml.="<clasificareteren>373</clasificareteren>"; break;
			case "extravilan":$ofertaxml.="<clasificareteren>374</clasificareteren>"; break;
			default :$ofertaxml.="<clasificareteren>373</clasificareteren>"; break;
		}
		switch ($apartament->TipTeren) {
			case "constructii":$ofertaxml.="<tipteren>375</tipteren>"; break;
			case "agricol":$ofertaxml.="<tipteren>376</tipteren>"; break;
			case "padure":$ofertaxml.="<tipteren>377</tipteren>"; break;
			default:$ofertaxml.="<tipteren>375</tipteren>"; break;
			
		}
		$ofertaxml.="<nrfronturistradale>{$apartament->NumarDeschideri}</nrfronturistradale>";
		$ofertaxml.="<inclinatieteren>{$apartament->Inclinatie}</inclinatieteren>";
		$ofertaxml.="<latimedrumacces>{$apartament->LatimeDrumAcces}</latimedrumacces>";
		//$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";
		$ofertaxml.="<constructiepeteren>".($apartament->ConstructiePeTeren+0)."</constructiepeteren>";
	}
	
	if ($apartament->TipProprietate==4) {  // doar spatii
		$ofertaxml.="<nrincaperi>{$apartament->NumarCamere}</nrincaperi>";
		$ofertaxml.="<nrgrupurisanitare>{$apartament->NrGrupuriSanitare}</nrgrupurisanitare>";
		$ofertaxml.="<destinatierecomandata><lang id=\"1048\">".base64_encode($apartament->Destinatie)."</lang></destinatierecomandata>";
		$ofertaxml.="<disp_prop><lang id=\"1048\">".base64_encode("imediat")."</lang></disp_prop>";
		switch ($apartament->ClasaBirouri){
			case "A": $ofertaxml.='<clasabirouri>554</clasabirouri>';break;
			case "B": $ofertaxml.='<clasabirouri>555</clasabirouri>';break;
			case "C": $ofertaxml.='<clasabirouri>556</clasabirouri>';break;
			default: $ofertaxml.='<clasabirouri></clasabirouri>';
		}
		
		
		
		$tmp="";
		switch ($apartament->TipConstructie){
			case "bloc":$tmp=424; break;
			case "cladire de birouri":$tmp=425; break;
			case "hala":$tmp=426; break;
			case "depozit":$tmp=427; break;
			case "casa/vila":$tmp=428; break;
			case "hotel":$tmp=429; break;
			case "centru comercial":$tmp=562; break;
		}
		$ofertaxml.="<tipimobil>{$tmp}</tipimobil>";
		$ofertaxml.="<inaltimespatiu>{$apartament->Inaltime}</inaltimespatiu>";
		$ofertaxml.="<nrparcari>{$apartament->NumarParcari}</nrparcari>";
		if ($apartament->Demisol==1) {
			$ofertaxml.="<demisol>1</demisol>";
		}
		if ($apartament->Subsol==1) {
			$ofertaxml.="<subsol>1</subsol>";
		}
		if ($apartament->Mansarda==1) {
			$ofertaxml.="<mansarda>1</mansarda>";
		}
		
		if ($apartament->Etaje>0) {
			$ofertaxml.="<nrnivele>{$apartament->Etaje}</nrnivele>";
		}
		//if ($apartament->SuprafataConstruita>0){
		//	$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";
		//}
		if ($apartament->SuprafataCurte>0){
			$ofertaxml.="<suprafatateren>{$apartament->SuprafataCurte}</suprafatateren>";
		}
		if ($apartament->SuprafataTerasa>0){
			$ofertaxml.="<suprafataterase>{$apartament->SuprafataTerasa}</suprafataterase>";
		}
		
		$tmp="";
		$x=dotare_imobiliare("lift marfa", $apartament->id, $apartament->TipProprietate, "","","", "435");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("marfa", $apartament->id, $apartament->TipProprietate, "","","", "451");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("CFR", $apartament->id, $apartament->TipProprietate, "","","", "448");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("TIR", $apartament->id, $apartament->TipProprietate, "","","", "449");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("Rampa TIR", $apartament->id, $apartament->TipProprietate, "","","", "450");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("pivnita", $apartament->id, $apartament->TipProprietate, "","","", "437");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("spatiu depozitare", $apartament->id, $apartament->TipProprietate, "","","", "439");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("crama", $apartament->id, $apartament->TipProprietate, "","","", "438");
		if ($x!="") $tmp.=$x." ";
		$x=dotare_imobiliare("anexe", $apartament->id, $apartament->TipProprietate, "","","", "440");
		if ($x!="") $tmp.=$x." ";
		$tmp=substr($tmp,0,-1);
		$ofertaxml.="<altecaracteristici>{$tmp}</altecaracteristici>";
	}
	$ofertaxml.="<agent>{$oferta->IdAgentVanzare}</agent>";
 		
	$ofertaxml.="<vecinatati><lang id=\"1048\">".base64_encode(dotari("Vecinatati",$apartament->id))."</lang></vecinatati>";
	$ofertaxml.="<descriere><lang id=\"1048\">".base64_encode($apartament->Detalii.", cod oferta SP".$inchiriere.str_pad($oferta->id,4,"0",STR_PAD_LEFT))."</lang></descriere>";
	$ofertaxml.="<sector>{$apartament->Sector}</sector>";
	$ofertaxml.="<alias>SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT)."</alias>";
	if ($oferta->Negociabil>0) { 
		$ofertaxml.="<pretnegociabil>1</pretnegociabil>"; 
	}
	if ($oferta->Exclusivitate>0) {
		$ofertaxml.="<exclusivitate>1</exclusivitate>";
	}
	if ($oferta->OfertaWeb>0) {
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
		$tmp.="-".$oras->Denumire."-".$zona->Denumire."-".$subzona->Denumire;
		$tmp.="--sp".str_pad($oferta->id,5,"0",STR_PAD_LEFT).".html";
		$lista=array("\s"," ");
		$link.=str_replace($lista,"-",html_entity_decode($tmp));
		$ofertaxml.="<linkextern>{$link}</linkextern>";
	}
	// inca nu au fost reanalizate 
	
	
	// ?? nu mai e inm baza $ofertaxml.="<servicii>".dotari("Servicii???",$apartament->id)."</servicii>";
	
	//$ofertaxml.="<altedetaliizona>67,302,303</altedetaliizona>";
	
	$sql="SELECT COUNT(*) FROM Foto WHERE idApartament={$apartament->id} AND Privat<>'1'";
	$nrimagini=Foto::count_by_sql($sql);
	$nrpoza=0;
	if ($nrimagini>0){
		$ofertaxml.="<imagini nrimagini=\"{$nrimagini}\">";
		$fotoList=Foto::find_by_sql("SELECT * FROM Foto WHERE idApartament={$apartament->id} AND Privat<>'1' ORDER BY Ordin");
		foreach ($fotoList as $foto) {
			$nrpoza++;
			$ofertaxml.="<imagine dummy=\"False\" modificata=\"1228840157\" latime=\"800\" inaltime=\"600\" pozitie=\"{$nrpoza}\">";
			$ofertaxml.="<descriere>".base64_encode($foto->Detalii)."</descriere>";
			$ofertaxml.="<blob>";
			$ofertaxml.= base64_encode(file_get_contents("..".DS.$foto->image_path()));			
			$ofertaxml.="</blob>";
			$ofertaxml.="</imagine>";
		}
		$ofertaxml.="</imagini>";
	}
	
	if (($oferta->ExportImobiliare<3)&&($oferta->Stare=='de actualitate')) {
		if ($oferta->ExportImobiliare=1) {
			$operatie="MOD";
			$ofertaxml.="<datamodificare>".time()."</datamodificare>";
		}
		else { 
			$operatie="ADD";
			$ofertaxml.="<dataadaugare>".time()."</dataadaugare>";
		}
	}
	else { $operatie="DEL";}
	
	$ofertaxml.='</oferta>';
	
	//echo $ofertaxml;
	
	
	// publica oferta
	$ok=1;
	switch ($apartament->TipProprietate)
	{	
		case 0: $oftip=0; break;
		case 1: $oftip=0; break;
		case 2: $oftip=1; break;
		case 3: $oftip=3; break;
		case 4: $oftip=4; break;
		
	}
	
	try {
		$result = $s->__soapCall( 
			'publica_oferta', 
			array( 
				'publica_oferta' => array( 
					'id_str'		=> $oftip.':' . $id,
					'sid' 			=> $session_id, 
					'operatie'		=> $operatie,
					'ofertaxml' 	=> $ofertaxml,
				) 	
			) 
		); 
	} catch( Exception $e ) {
		$ok=0;
		$mesaj="";
		if ($afisare>0) { $mesaj='Eroare Publicare oferta: ' . $e->getMessage(); }
		die( $mesaj ); 
	}
	if (isset($result->mesaj)) {$idImobiliare=array_pop(explode(" ", $result->mesaj));}
	if ($afisare>0) {echo '<pre>PUBLICARE OFERTA: ' . print_r( $result, true ) . '</pre>';}
	if ($result->cod=="0") return true;
	return false; 
}

function posteazaAgent($afisare=0){
	
	global $s;
	global $session_id;
	
	$agenti=User::find_all();
	foreach ($agenti as $agent){
		$agentxml="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";
		$agentxml.="<agent>
		<id>{$agent->id}</id>
		<email>{$agent->Email}</email>
		<mobil>{$agent->Telefon}</mobil>
		<nume>".$agent->full_name()."</nume>
		<username>{$agent->User}</username>
		<password>{$agent->Parola}</password>
		<functie>Broker imobiliar</functie>
		";
		if ($agent->Poza!=""){
			$agentxml.="<poza>".base64_encode(file_get_contents("..".DS.$agent->image_path()))."</poza>";
		}
		// <telefon>0314398268</telefon>
		$agentxml.="</agent>";
		
		//echo $agentxml."";
		// publica AGENT

		$operatie="MOD";

		try {
			$result = $s->__soapCall( 
				'publica_agent', 
				array( 
					'publica_agent' => array( 
						'id'			=> $agent->id,
						'sid' 			=> $session_id, 
						'operatie'		=> $operatie,
						'agentxml' 		=> $agentxml,
					) 	
				) 
			); 
		} catch( Exception $e ) {
			$mesaj="";
			if ($afisare>0) { $mesaj='Eroare Publicare agent: ' . $e->getMessage(); }
			die( $mesaj );
		}
		
		if ($afisare>0) {echo '<pre>PUBLICARE Agent id '.$agent->id.': ' . print_r( $result, true ) . '</pre>';}
		
	}
}
?>